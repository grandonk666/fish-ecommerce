<?php

namespace App\Controllers;

use App\Models\InternationalTransactionModel;
use App\Models\ProductModel;
use CodeIgniter\I18n\Time;
use Myth\Auth\Models\UserModel;

class AdminInternational extends BaseController
{
  protected $userModel, $internatioanalTransactionModel, $productModel;
  public function __construct()
  {
    $this->userModel = new UserModel();
    $this->productModel = new ProductModel();
    $this->internatioanalTransactionModel = new InternationalTransactionModel();
  }

  public function index()
  {
    $dataTransactions = $this->internatioanalTransactionModel->findAll();
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
      'nav' => 'admin_international',
      'title' => lang('Admin.dataInter'),
      'transactions' => $transactions,
    ];

    return view('transaction/international', $data);
  }

  public function detail($id)
  {
    $transaction = $this->internatioanalTransactionModel->find($id);

    $transaction['product'] = $this->productModel->find($transaction['product_id']);
    $transaction['user'] = $this->userModel->find($transaction['user_id']);
    $detail = $this->getTransactionDetail($transaction);

    $data = [
      'title' => lang('Admin.detailTransaction'),
      'nav' => 'admin_international',
      'validation' => \Config\Services::validation(),
      'transaction' => $transaction,
      'pesan' => $detail['pesan'],
      'pdf' => $detail['pdf'],
      'bill' => $detail['bill'],
      'badge' => $detail['badge'],
    ];

    return view('transaction/international_detail', $data);
  }

  public function invoice()
  {
    $rules = [
      'invoice' => [
        'label' => 'Invoice',
        'rules' => 'max_size[invoice,2048]',
      ]
    ];
    if (!$this->validate($rules)) {
      return redirect()->to('/admin/international/' . $this->request->getVar('transaction_id'))
        ->withInput();
    }

    $transaction = $this->internatioanalTransactionModel->find($this->request->getVar('transaction_id'));
    if ($transaction['status'] != 'Waiting Approvement') {
      session()->setFlashdata('error', lang('Admin.dontNeedInvoice'));
      return redirect()->to('/admin/international/' . $this->request->getVar('transaction_id'));
    }

    $invoice = $this->getInvoiceFile($this->request->getFile('invoice'), $transaction);
    if (!$invoice) {
      session()->setFlashdata('error', lang('Admin.uploadFailed'));
      return redirect()->to('/admin/international/' . $this->request->getVar('transaction_id'));
    }

    $this->internatioanalTransactionModel->save([
      'id' => $transaction['id'],
      'invoice' => $invoice,
      'status' => 'Waiting Payment'
    ]);

    session()->setFlashdata('success', lang('Admin.invoiceUpdated'));

    return redirect()->to('/admin/international/' . $this->request->getVar('transaction_id'));
  }

  public function reciept()
  {
    $rules = [
      'reciept' => [
        'label' => 'Reciept',
        'rules' => 'max_size[reciept,2048]',
      ]
    ];
    if (!$this->validate($rules)) {
      return redirect()->to('/admin/international/' . $this->request->getVar('transaction_id'))
        ->withInput();
    }

    $transaction = $this->internatioanalTransactionModel->find($this->request->getVar('transaction_id'));
    if ($transaction['status'] != 'Checking Payment') {
      session()->setFlashdata('error', lang('Admin.dontNeedReciept'));
      return redirect()->to('/admin/international/' . $this->request->getVar('transaction_id'));
    }

    $reciept = $this->getRecieptFile($this->request->getFile('reciept'), $transaction);
    if (!$reciept) {
      session()->setFlashdata('error', lang('Admin.uploadFailed'));
      return redirect()->to('/admin/international/' . $this->request->getVar('transaction_id'));
    }

    $this->internatioanalTransactionModel->save([
      'id' => $transaction['id'],
      'shipping_reciept' => $reciept,
      'status' => 'On Delivery'
    ]);

    session()->setFlashdata('success', lang('Admin.recieptUpdated'));

    return redirect()->to('/admin/international/' . $this->request->getVar('transaction_id'));
  }


  public function getInvoiceFile($uploadedFile, $transaction)
  {
    if ($uploadedFile->getError() == 4) {
      return null;
    }

    $originalName = $uploadedFile->getClientName();
    $names = explode('.', $originalName);
    $originalName = $names[0];
    $ext = $uploadedFile->getClientExtension();
    $time = Time::now();
    $time = $time->toDateString();
    $fileName = $originalName . $time . '.' . $ext;
    $uploadedFile->move('invoice', $fileName);
    if ($transaction['invoice']) {
      unlink('invoice/' . $transaction['invoice']);
    }
    return $fileName;
  }

  public function getRecieptFile($uploadedFile, $transaction)
  {
    if ($uploadedFile->getError() == 4) {
      return null;
    }

    $originalName = $uploadedFile->getClientName();
    $names = explode('.', $originalName);
    $originalName = $names[0];
    $ext = $uploadedFile->getClientExtension();
    $time = Time::now();
    $time = $time->toDateString();
    $fileName = $originalName . $time . '.' . $ext;
    $uploadedFile->move('reciept', $fileName);
    if ($transaction['shipping_reciept']) {
      unlink('reciept/' . $transaction['shipping_reciept']);
    }
    return $fileName;
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
