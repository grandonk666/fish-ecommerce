<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;

class Product extends BaseController
{
  protected $productModel, $categoryModel, $cart;
  public function __construct()
  {
    $this->productModel = new ProductModel();
    $this->categoryModel = new CategoryModel();
    $this->cart = \Config\Services::cart();
  }

  public function index()
  {
    $products = array_map(function ($product) {
      $product['in_cart'] = $this->isInCart($product['id']);
      return $product;
    }, $this->productModel->findAll());

    $data = [
      'title' => 'Products',
      'nav' => 'shop',
      'products' => $products
    ];

    return view('product/index', $data);
  }

  public function detail($slug)
  {
    $product = $this->productModel->getProduct($slug);
    $product['in_cart'] = $this->isInCart($product['id']);

    $latestProducts = array_map(function ($product) {
      $product['in_cart'] = $this->isInCart($product['id']);
      return $product;
    }, $this->productModel->limit(5)->findAll());

    $data = [
      'product' => $product,
      'latestProducts' => $latestProducts,
    ];

    return view('product/detail', $data);
  }

  public function isInCart($productId)
  {
    $inCart = array_search($productId, array_column($this->cart->contents(), 'id'));

    return is_int($inCart);
  }
}
