<?php

namespace App\Controllers;

use App\Models\TransaksiModel;
use Midtrans\Notification;

class Transaksi extends BaseController
{
  protected $kamarModel, $ruanganModel, $transaksiModel;
  public function __construct()
  {
    // $this->kamarModel = new KamarModel();
    // $this->ruanganModel = new RuanganModel();
    $this->transaksiModel = new TransaksiModel();
  }

  public function index()
  {
    $dataTransaksi = $this->transaksiModel->orderBy('created_at', 'desc')->findAll();

    if ($this->request->getVar('keyword'))
    {
      $dataTransaksi = $this->transaksiModel->getSearch($this->request->getVar('keyword'));
    }

    foreach ($dataTransaksi as $trx => $t)
    {
      switch ($dataTransaksi[$trx]['transaction_status'])
      {
        case 'Challenge by FDS':
          $dataTransaksi[$trx]['badge'] = 'warning';
          break;
        case 'Success':
          $dataTransaksi[$trx]['badge'] = 'primary';
          break;
        case 'Settlement':
          $dataTransaksi[$trx]['badge'] = 'success';
          break;
        case 'Pending':
          $dataTransaksi[$trx]['badge'] = 'warning';
          break;
        case 'Denied':
          $dataTransaksi[$trx]['badge'] = 'danger';
          break;
        case 'Expire':
          $dataTransaksi[$trx]['badge'] = 'danger';
          break;
        case 'Canceled':
          $dataTransaksi[$trx]['badge'] = 'danger';
          break;

        default:
          $dataTransaksi[$trx]['badge'] = 'success';
          break;
      }
    }

    $data = [
      'nav' => 'transaksi',
      'title' => 'Data Transaksi',
      'transaksi' => $dataTransaksi,
    ];

    return view('admin/transaksi/index', $data);
  }

  public function notifikasi()
  {
    $notif = new Notification();

    $transaction = $notif->transaction_status;
    $type = $notif->payment_type;
    $order_id = $notif->order_id;
    $fraud = $notif->fraud_status;

    $transaksi = $this->transaksiModel->where(['order_id' => $order_id])->first();

    if ($transaction == 'capture')
    {
      // For credit card transaction, we need to check whether transaction is challenge by FDS or not
      if ($type == 'credit_card')
      {
        if ($fraud == 'challenge')
        {
          // TODO set payment status in merchant's database to 'Challenge by FDS'
          $this->transaksiModel->save([
            'id' => $transaksi['id'],
            'transaction_status' => 'Challenge by FDS',
          ]);
          // TODO merchant should decide whether this transaction is authorized or not in MAP
          echo "Transaction order_id: " . $order_id . " is challenged by FDS";
        }
        else
        {
          // TODO set payment status in merchant's database to 'Success'
          $this->transaksiModel->save([
            'id' => $transaksi['id'],
            'transaction_status' => 'Success',
          ]);
          echo "Transaction order_id: " . $order_id . " successfully captured using " . $type;
        }
      }
    }
    else if ($transaction == 'settlement')
    {
      // TODO set payment status in merchant's database to 'Settlement'
      $this->transaksiModel->save([
        'id' => $transaksi['id'],
        'transaction_status' => 'Settlement',
      ]);
      echo "Transaction order_id: " . $order_id . " successfully transfered using " . $type;
    }
    else if ($transaction == 'pending')
    {
      // TODO set payment status in merchant's database to 'Pending'
      $this->transaksiModel->save([
        'id' => $transaksi['id'],
        'transaction_status' => 'Pending',
      ]);
      echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
    }
    else if ($transaction == 'deny')
    {
      // TODO set payment status in merchant's database to 'Denied'
      $this->transaksiModel->save([
        'id' => $transaksi['id'],
        'transaction_status' => 'Denied',
      ]);
      echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
    }
    else if ($transaction == 'expire')
    {
      // TODO set payment status in merchant's database to 'expire'
      $this->transaksiModel->save([
        'id' => $transaksi['id'],
        'transaction_status' => 'Expire',
      ]);
      echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is expired.";
    }
    else if ($transaction == 'cancel')
    {
      // TODO set payment status in merchant's database to 'Denied'
      $this->transaksiModel->save([
        'id' => $transaksi['id'],
        'transaction_status' => 'Canceled',
      ]);
      echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is canceled.";
    }
  }
}
