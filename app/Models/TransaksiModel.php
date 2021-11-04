<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
  protected $table = 'transaksi';
  protected $useTimestamps = true;
  protected $allowedFields = ['order_id', 'user_id', 'customer_name', 'item_name', 'id_kamar', 'id_ruangan', 'gross_amount', 'payment_type', 'transaction_status', 'transaction_id', 'status_code', 'payment_code', 'pdf_url'];

  public function getSearch($keyword, $id = null)
  {
    $filter = [];
    if ($id != null)
    {
      $filter = ['user_id' => $id];
    }

    return $this->like('order_id', $keyword)
      ->orLike('customer_name', $keyword)
      ->orLike('item_name', $keyword)
      ->orLike('payment_type', $keyword)
      ->orLike('transaction_status', $keyword)
      ->where($filter)
      ->findAll();
  }

  public function getSumPendapatan()
  {
    $trxSuccess = $this->where(['transaction_status' => 'Settlement'])->findColumn('gross_amount');

    $sum = 0;
    foreach ($trxSuccess as $trx)
    {
      $sum = $sum + $trx;
    }

    return $sum;
  }

  public function getTransaksiGrafik()
  {
    $query = $this->db->query("SELECT MONTHNAME(created_at) as month, COUNT(order_id) as total FROM transaksi GROUP BY MONTHNAME(created_at) ORDER BY MONTH(created_at)");
    $hasil = [];
    if (!empty($query))
    {
      foreach ($query->getResultArray() as $data)
      {
        $hasil[] = $data;
      }
    }
    foreach ($hasil as $data)
    {
      $total[] = $data['total'];
      $month[] = $data['month'];
    }
    $result = ['total' => $total, 'month' => $month];
    return $result;
  }

  public function getLatestTrx()
  {
    return $this->orderBy('created_at', 'desc')->findAll(5);
  }

  public function getTipeGrafik()
  {
    $query = $this->db->query("SELECT payment_type as tipe, COUNT(order_id) as total FROM transaksi GROUP BY payment_type");
    $hasil = [];
    if (!empty($query))
    {
      foreach ($query->getResultArray() as $data)
      {
        $hasil[] = $data;
      }
    }
    foreach ($hasil as $data)
    {
      $total[] = $data['total'];
      $tipe[] = $data['tipe'];
    }
    $result = ['total' => $total, 'tipe' => $tipe];
    return $result;
  }
}
