<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;

class Product extends BaseController
{
  protected $productModel, $categoryModel;
  public function __construct()
  {
    $this->productModel = new ProductModel();
    $this->categoryModel = new CategoryModel();
  }

  public function index()
  {
    $data = [
      'title' => 'Products',
      'nav' => 'shop',
      'products' => $this->productModel->findAll()
    ];

    return view('product/index', $data);
  }

  public function detail($slug)
  {
    $data = [
      'product' => $this->productModel->getProduct($slug),
      'latestProducts' => $this->productModel->limit(5)->findAll(),
    ];

    return view('product/detail', $data);
  }
}
