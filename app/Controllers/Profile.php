<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use Myth\Auth\Models\UserModel;

class Profile extends BaseController
{
  protected $userModel, $transactionModel;
  public function __construct()
  {
    $this->userModel = new UserModel();
    $this->transactionModel = new TransactionModel();
  }

  public function index()
  {
    $data = [
      'title' => 'My Profile',
      'nav' => 'profile',
      'user' => user(),
    ];
    return view('user/index', $data);
  }

  public function edit()
  {
    $data = [
      'title' => 'Settings',
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
      'image' => 'max_size[user_image,1024]|is_image[user_image]|mime_in[user_image,image/jpg,image/jpeg,image/png]'
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
      'user_image' => $this->getFoto($this->request->getFile('user_image')),
    ];

    $this->userModel->save($data);

    session()->setFlashdata('pesan', 'Data berhasil diubah');

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
      'title' => 'User Transaction',
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
      'title' => 'Detail Transaction',
      'nav' => 'user_transaction',
      'transaction' => $transaction,
      'pesan' => $detail['pesan'],
      'pdf' => $detail['pdf'],
      'bill' => $detail['bill'],
      'badge' => $detail['badge'],
    ];

    return view('transaction/detail', $data);
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
          'pesan' => 'The order has challenge by FDS, please try to reorder, or call the customer service',
          'badge' => 'danger',
          'pdf' => '',
          'bill' => '',
        ];
        break;
      case 'On Delivery':
        return [
          'pesan' => 'The order is on delivery to your place',
          'pdf' => '',
          'badge' => 'success',
          'bill' => '/download/' . $transaction['id'],
        ];
        break;
      case 'Success':
        return [
          'pesan' => 'The order is on proccessing',
          'pdf' => $transaction['pdf_url'],
          'badge' => 'primary',
          'bill' => '',
        ];
        break;
      case 'Settlement':
        return [
          'pesan' => 'The order has been paid for and will be processed soon. We have sent the detail to your email, please check your email',
          'badge' => 'success',
          'bill' => '/download/' . $transaction['id'],
          'pdf' => '',
        ];
        break;
      case 'Pending':
        return [
          'pesan' => 'The order is waiting to be paid, please pay immediately using the payment method you choose',
          'pdf' => $transaction['pdf_url'],
          'badge' => 'warning',
          'bill' => '',
        ];
        break;
      case 'Denied':
        return [
          'pesan' => 'The order has been denied, please try to reorder',
          'badge' => 'danger',
          'pdf' => '',
          'bill' => '',
        ];
        break;
      case 'Expire':
        return [
          'pesan' => 'The order has expired because it has passed the payment deadline',
          'badge' => 'danger',
          'pdf' => '',
          'bill' => '',
        ];
        break;
      case 'Canceled':
        return [
          'pesan' => 'The order has been cancelled',
          'badge' => 'danger',
          'pdf' => '',
          'bill' => '',
        ];
        break;

      default:
        return [
          'pesan' => 'The order is waiting to be paid, please pay immediately using the payment method you choose',
          'badge' => 'info',
          'pdf' => $transaction['pdf_url'] ?? '',
          'bill' => '',
        ];
        break;
    }
  }
}
