<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
  protected $table = 'categories';
  protected $useTimestamps = true;
  protected $allowedFields = ['name', 'slug', 'image'];

  public function getCategory($slug = false)
  {
    if ($slug == false) {
      return $this->orderBy('tipe', 'asc')->findAll();
    }

    return $this->where(['slug' => $slug])->first();
  }

  public function getCountCategory()
  {
    return $this->countAllResults();
  }
}
