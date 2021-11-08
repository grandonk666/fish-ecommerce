<?php

namespace App\Models;

use CodeIgniter\Model;

class InternationalTransactionModel extends Model
{
  protected $table = 'international_transactions';
  protected $useTimestamps = true;
  protected $allowedFields = [
    'user_id',
    'product_id',
    'company_name',
    'address',
    'status',
    'invoice',
    'payment',
    'shipping_reciept'
  ];

  public function getUserTransaction($userId = false)
  {
    return $this->where(['user_id' => $userId])->findAll();
  }
}
