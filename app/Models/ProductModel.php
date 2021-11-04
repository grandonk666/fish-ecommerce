<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
  protected $table = 'products';
  protected $useTimestamps = true;
  protected $allowedFields = ['name', 'slug', 'image', 'category_id', 'detail', 'price'];

  public function getProduct($slug = false)
  {
    if ($slug == false) {
      return $this->orderBy('tipe', 'asc')->findAll();
    }

    return $this->where(['slug' => $slug])->first();
  }

  public function getCountProduct()
  {
    return $this->countAllResults();
  }
}
