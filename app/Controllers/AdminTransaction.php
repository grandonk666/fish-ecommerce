<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use Myth\Auth\Models\UserModel;
use Midtrans\Notification;

class AdminTransaction extends BaseController
{
  protected $userModel, $transactionModel;
  public function __construct()
  {
    $this->userModel = new UserModel();
    $this->transactionModel = new TransactionModel();
  }

  public function index()
  {
    $dataTransactions = $this->transactionModel->findAll();
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
      'nav' => 'admin_transaction',
      'title' => 'Data Transactions',
      'transactions' => $transactions,
    ];

    return view('transaction/index', $data);
  }

  public function detail($id)
  {
    $transaction = $this->transactionModel->find($id);
    $transaction['order'] = json_decode($transaction['order'], true);
    $transaction['user'] = $this->userModel->find($transaction['user_id']);
    $detail = $this->getTransactionDetail($transaction);

    $data = [
      'title' => 'Detail Transaction',
      'nav' => 'admin_transaction',
      'transaction' => $transaction,
      'pesan' => $detail['pesan'],
      'pdf' => $detail['pdf'],
      'bill' => $detail['bill'],
      'badge' => $detail['badge'],
    ];

    return view('transaction/detail', $data);
  }

  public function reciept()
  {
    $this->transactionModel->save([
      'id' => $this->request->getVar('transaction_id'),
      'reciept_number' => $this->request->getVar('reciept_number'),
      'status' => 'On Delivery'
    ]);

    session()->setFlashdata('success', 'Reciept Number Updated');

    return redirect()->to('/admin/transaction/' . $this->request->getVar('transaction_id'));
  }

  public function notification()
  {
    \Midtrans\Config::$isProduction = false;
    \Midtrans\Config::$serverKey = 'SB-Mid-server-nDv_Z65iSjuX0xw6zXK6MeuD';
    $notif = new \Midtrans\Notification();

    $status = $notif->transaction_status;
    $type = $notif->payment_type;
    $order_id = $notif->order_id;
    $fraud = $notif->fraud_status;

    $transaction = $this->transactionModel->where(['serial_number' => $order_id])->first();

    if ($status == 'capture') {
      // For credit card transaction, we need to check whether transaction is challenge by FDS or not
      if ($type == 'credit_card') {
        if ($fraud == 'challenge') {
          // TODO set payment status in merchant's database to 'Challenge by FDS'
          $this->transactionModel->save([
            'id' => $transaction['id'],
            'status' => 'Challenge by FDS',
          ]);
          // TODO merchant should decide whether this transaction is authorized or not in MAP
          echo "Transaction order_id: " . $order_id . " is challenged by FDS";
        } else {
          // TODO set payment status in merchant's database to 'Success'
          $this->transactionModel->save([
            'id' => $transaction['id'],
            'status' => 'Success',
          ]);
          echo "Transaction order_id: " . $order_id . " successfully captured using " . $type;
        }
      }
    } else if ($status == 'settlement') {
      // TODO set payment status in merchant's database to 'Settlement'
      $this->transactionModel->save([
        'id' => $transaction['id'],
        'status' => 'Settlement',
      ]);
      echo "Transaction order_id: " . $order_id . " successfully transfered using " . $type;
    } else if ($status == 'pending') {
      // TODO set payment status in merchant's database to 'Pending'
      $this->transactionModel->save([
        'id' => $transaction['id'],
        'status' => 'Pending',
      ]);
      echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
    } else if ($status == 'deny') {
      // TODO set payment status in merchant's database to 'Denied'
      $this->transactionModel->save([
        'id' => $transaction['id'],
        'status' => 'Denied',
      ]);
      echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
    } else if ($status == 'expire') {
      // TODO set payment status in merchant's database to 'expire'
      $this->transactionModel->save([
        'id' => $transaction['id'],
        'status' => 'Expire',
      ]);
      echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is expired.";
    } else if ($status == 'cancel') {
      // TODO set payment status in merchant's database to 'Denied'
      $this->transactionModel->save([
        'id' => $transaction['id'],
        'status' => 'Canceled',
      ]);
      echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is canceled.";
    }
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
