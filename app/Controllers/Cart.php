<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Cart extends BaseController
{
  protected $cart, $productModel;
  public function __construct()
  {
    $this->productModel = new ProductModel();
    $this->cart = \Config\Services::cart();
  }

  public function index()
  {
    $data = [
      'cart' => $this->cart->contents(),
      'subtotal' => $this->cart->total()
    ];

    return view('cart', $data);
  }

  public function get_sum()
  {
    $data = [
      'total' => count($this->cart->contents())
    ];
    return $this->response->setJSON($data);
  }

  public function insert()
  {
    $product = $this->productModel->find($this->request->getVar('product_id'));

    $this->cart->insert(array(
      'id'      => $product['id'],
      'qty'     => $this->request->getVar('quantity'),
      'price'   => $product['price'],
      'name'    => $product['name'],
      'options' => [
        'image' => $product['image'],
        'domestic_stock' => $product['domestic_stock']
      ]
    ));

    return $this->response->setStatusCode(200, 'Added to cart');
  }

  public function update()
  {
    $this->cart->update([
      'rowid' => $this->request->getVar('rowid'),
      'qty' => $this->request->getVar('quantity'),
    ]);

    return redirect()->to('/cart');
  }

  public function delete()
  {
    $this->cart->remove($this->request->getVar('rowid'));

    return redirect()->to('/cart');
  }
}
