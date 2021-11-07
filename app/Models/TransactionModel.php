<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
  protected $table = 'transactions';
  protected $useTimestamps = true;
  protected $allowedFields = [
    'serial_number',
    'transaction_id',
    'user_id',
    'status',
    'status_code',
    'total',
    'province',
    'city',
    'address',
    'order',
    'payment_type',
    'payment_code',
    'pdf_url',
    'delivery_cost',
    'delivery_service',
    'reciept_number'
  ];

  public function getUserTransaction($userId = false)
  {
    return $this->where(['user_id' => $userId])->findAll();
  }

  public function getCountTransaction()
  {
    return $this->countAllResults();
  }
}
