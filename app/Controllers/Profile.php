<?php

namespace App\Controllers;

use App\Models\InternationalTransactionModel;
use App\Models\ProductModel;
use App\Models\TransactionModel;
use Myth\Auth\Models\UserModel;

class Profile extends BaseController
{
  protected $userModel, $transactionModel, $internatioanalTransactionModel, $productModel;
  public function __construct()
  {
    $this->userModel = new UserModel();
    $this->productModel = new ProductModel();
    $this->transactionModel = new TransactionModel();
    $this->internatioanalTransactionModel = new InternationalTransactionModel();
  }

  public function index()
  {
    $data = [
      'title' => lang('Admin.myProfile'),
      'nav' => 'profile',
      'user' => user(),
    ];
    return view('user/index', $data);
  }

  public function edit()
  {
    $data = [
      'title' => lang('Admin.settings'),
      'validation' => \Config\Services::validation(),
      'nav' => 'settings',
      'user' => user(),
    ];
    return view('user/edit', $data);
  }

  public function update()
  {
    $id = user()->id;

    $rules = [
      'username'    => "required|alpha_numeric_space|min_length[3]|is_unique[users.username, id, $id]",
      'firstname'    => 'required|alpha_numeric_space|min_length[3]',
      'lastname'    => 'required|alpha_numeric_space|min_length[3]',
      'phone'    => 'required|numeric|min_length[3]',
    ];

    if (!$this->validate($rules)) {
      return redirect()->to('/profile/settings')->withInput();
    }

    $data = [
      'id' => $id,
      'username' => $this->request->getVar('username'),
      'firstname' => $this->request->getVar('firstname'),
      'lastname' => $this->request->getVar('lastname'),
      'phone' => $this->request->getVar('phone'),
    ];

    $this->userModel->save($data);

    session()->setFlashdata('success', lang('Admin.profileUpdated'));

    return redirect()->to('/profile');
  }

  public function transaction()
  {
    $dataTransactions = $this->transactionModel->getUserTransaction(user_id());
    $dataUsers = $this->userModel->findAll();

    $transactions = array_map(function ($transaction) use ($dataUsers) {
      $userIndex = array_search($transaction['user_id'], array_column($dataUsers, 'id'));
      $transaction['user'] = $dataUsers[$userIndex];

      $transaction['order'] = json_decode($transaction['order'], true);

      return $transaction;
    }, $dataTransactions);


    foreach ($transactions as $trx => $t) {
      switch ($transactions[$trx]['status']) {
        case 'Challenge by FDS':
          $transactions[$trx]['badge'] = 'warning';
          break;
        case 'Success':
          $transactions[$trx]['badge'] = 'primary';
          break;
        case 'Settlement':
          $transactions[$trx]['badge'] = 'success';
          break;
        case 'On Delivery':
          $transactions[$trx]['badge'] = 'success';
          break;
        case 'Pending':
          $transactions[$trx]['badge'] = 'warning';
          break;
        case 'Denied':
          $transactions[$trx]['badge'] = 'danger';
          break;
        case 'Expire':
          $transactions[$trx]['badge'] = 'danger';
          break;
        case 'Canceled':
          $transactions[$trx]['badge'] = 'danger';
          break;

        default:
          $transactions[$trx]['badge'] = 'primary';
          break;
      }
    }

    $data = [
      'nav' => 'user_transaction',
      'title' => lang('Admin.userDomestic'),
      'transactions' => $transactions,
    ];

    return view('transaction/index', $data);
  }

  public function transaction_detail($transactionId)
  {
    $transaction = $this->transactionModel->find($transactionId);
    if ($transaction['user_id'] != user_id()) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }
    $transaction['order'] = json_decode($transaction['order'], true);
    $transaction['user'] = $this->userModel->find($transaction['user_id']);
    $detail = $this->getTransactionDetail($transaction);

    $data = [
      'title' => lang('Admin.detailTransaction'),
      'nav' => 'user_transaction',
      'transaction' => $transaction,
      'pesan' => $detail['pesan'],
      'pdf' => $detail['pdf'],
      'bill' => $detail['bill'],
      'badge' => $detail['badge'],
    ];

    return view('transaction/detail', $data);
  }

  public function international_transaction()
  {
    $dataTransactions = $this->internatioanalTransactionModel->getUserTransaction(user_id());
    $dataUsers = $this->userModel->findAll();
    $dataProducts = $this->productModel->findAll();

    $transactions = array_map(function ($transaction) use ($dataUsers, $dataProducts) {
      $userIndex = array_search($transaction['user_id'], array_column($dataUsers, 'id'));
      $transaction['user'] = $dataUsers[$userIndex];

      $productIndex = array_search($transaction['product_id'], array_column($dataProducts, 'id'));
      $transaction['product'] = $dataProducts[$productIndex];

      return $transaction;
    }, $dataTransactions);


    foreach ($transactions as $trx => $t) {
      switch ($transactions[$trx]['status']) {
        case 'Waiting Approvement':
          $transactions[$trx]['badge'] = 'info';
          break;
        case 'Waiting Payment':
          $transactions[$trx]['badge'] = 'warning';
          break;
        case 'Checking Payment':
          $transactions[$trx]['badge'] = 'primary';
          break;
        case 'On Delivery':
          $transactions[$trx]['badge'] = 'success';
          break;
        case 'Denied':
          $transactions[$trx]['badge'] = 'danger';
          break;

        default:
          $transactions[$trx]['badge'] = 'info';
          break;
      }
    }

    $data = [
      'nav' => 'user_international',
      'title' => lang('admin.userInter'),
      'transactions' => $transactions,
    ];

    return view('transaction/international', $data);
  }

  public function international_detail($id)
  {
    $transaction = $this->internatioanalTransactionModel->find($id);
    if ($transaction['user_id'] != user_id()) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }
    $transaction['product'] = $this->productModel->find($transaction['product_id']);
    $transaction['user'] = $this->userModel->find($transaction['user_id']);
    $detail = $this->getTransactionDetail($transaction);

    $data = [
      'title' => lang('Admin.detailTransaction'),
      'nav' => 'user_international',
      'validation' => \Config\Services::validation(),
      'transaction' => $transaction,
      'pesan' => $detail['pesan'],
      'pdf' => $detail['pdf'],
      'bill' => $detail['bill'],
      'badge' => $detail['badge'],
    ];

    return view('transaction/international_detail', $data);
  }

  public function getFoto($fileFoto)
  {
    if ($fileFoto->getError() == 4) {
      return user()->user_image;
    }

    $namaFoto = $fileFoto->getRandomName();
    $fileFoto->move('images', $namaFoto);
    if (user()->user_image != 'profile-default.png') {
      unlink('images/' . user()->user_image);
    }
    return $namaFoto;
  }

  public function getTransactionDetail($transaction)
  {
    switch ($transaction['status']) {
      case 'Challenge by FDS':
        return [
          'pesan' => lang('Admin.chalangeMsg'),
          'badge' => 'danger',
          'pdf' => '',
          'bill' => '',
        ];
        break;
      case 'On Delivery':
        return [
          'pesan' => lang('Admin.onDeliveryMsg'),
          'pdf' => '',
          'badge' => 'success',
          'bill' => '',
        ];
        break;
      case 'Success':
        return [
          'pesan' => lang('Admin.successMsg'),
          'pdf' => $transaction['pdf_url'] ?? '',
          'badge' => 'primary',
          'bill' => '',
        ];
        break;
      case 'Settlement':
        return [
          'pesan' => lang('Admin.settlementMsg'),
          'badge' => 'success',
          'bill' => '/download/' . $transaction['id'],
          'pdf' => '',
        ];
        break;
      case 'Waiting Approvement':
        return [
          'pesan' => lang('Admin.waitApprove'),
          'badge' => 'info',
          'bill' => '',
          'pdf' => '',
        ];
        break;
      case 'Waiting Payment':
        return [
          'pesan' => lang('Admin.waitingPay'),
          'badge' => 'warning',
          'bill' => '',
          'pdf' => '',
        ];
        break;
      case 'Checking Payment':
        return [
          'pesan' => lang('Admin.checkPay'),
          'badge' => 'primary',
          'bill' => '',
          'pdf' => '',
        ];
        break;
      case 'Pending':
        return [
          'pesan' => lang('Admin.pendingMsg'),
          'pdf' => $transaction['pdf_url'],
          'badge' => 'warning',
          'bill' => '',
        ];
        break;
      case 'Denied':
        return [
          'pesan' => lang('Admin.deniedMsg'),
          'badge' => 'danger',
          'pdf' => '',
          'bill' => '',
        ];
        break;
      case 'Expire':
        return [
          'pesan' => lang('Admin.expireMsg'),
          'badge' => 'danger',
          'pdf' => '',
          'bill' => '',
        ];
        break;
      case 'Canceled':
        return [
          'pesan' => lang('Admin.cancelMsg'),
          'badge' => 'danger',
          'pdf' => '',
          'bill' => '',
        ];
        break;

      default:
        return [
          'pesan' => lang('Admin.defaultMsg'),
          'badge' => 'info',
          'pdf' => $transaction['pdf_url'] ?? '',
          'bill' => '',
        ];
        break;
    }
  }
}
