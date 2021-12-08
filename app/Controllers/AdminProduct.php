<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;

class AdminProduct extends BaseController
{
  protected $productModel, $categoryModel;
  protected $saveRules = [
    'name' => [
      'label' => "Name",
      'rules' => 'required|is_unique[products.name]',
    ],
    'category' => [
      'label' => "Category",
      'rules' => 'required',
    ],
    'detail' => [
      'label' => "Detail",
      'rules' => 'required',
    ],
    'price' => [
      'label' => "Price",
      'rules' => 'required',
    ],
    'image' => [
      'label' => 'Image',
      'rules' => 'max_size[image,1024]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]',
    ],
    'domestic_stock' => [
      'label' => "Domestic Stock",
      'rules' => 'required',
    ],
    'international_stock' => [
      'label' => "International Stock",
      'rules' => 'required',
    ],
  ];
  public function __construct()
  {
    $this->productModel = new ProductModel();
    $this->categoryModel = new CategoryModel();
  }

  public function index()
  {
    $dataProducts = $this->productModel->findAll();
    $dataCategory = $this->categoryModel->findAll();
    $products = array_map(function ($product) use ($dataCategory) {
      $categoryIndex = array_search($product['category_id'], array_column($dataCategory, 'id'));
      $product['category'] = $dataCategory[$categoryIndex];
      return $product;
    }, $dataProducts);

    $data = [
      'nav' => 'product',
      'title' => lang('Admin.dataProducts'),
      'products' => $products,
    ];
    return view('admin/product/index', $data);
  }

  public function create()
  {
    $data = [
      'nav' => 'product',
      'validation' => \Config\Services::validation(),
      'title' => lang('Admin.addProduct'),
      'categories' => $this->categoryModel->findAll(),
    ];

    return view('admin/product/create', $data);
  }

  public function save()
  {
    if (!$this->validate($this->saveRules)) {
      return redirect()->to('/admin/product/create')->withInput();
    }

    $data = [
      'name' => $this->request->getVar('name'),
      'slug' => url_title($this->request->getVar('name'), '-', true),
      'category_id' => (int)$this->request->getVar('category'),
      'price' => (int)$this->request->getVar('price'),
      'domestic_stock' => (int)$this->request->getVar('domestic_stock'),
      'international_stock' => (int)$this->request->getVar('international_stock'),
      'detail' => $this->request->getVar('detail'),
      'image' => $this->getProductImage($this->request->getFile('image')),
    ];

    $this->productModel->save($data);

    session()->setFlashdata('success', lang('Admin.productAdded'));

    return redirect()->to('/admin/product');
  }

  public function delete($id)
  {
    $product = $this->productModel->find($id);
    if ($product['image'] != 'default-product.jpg') {
      unlink('images/product-images' . $product['image']);
    }

    $this->productModel->delete($id);

    session()->setFlashdata('success', lang('Admin.productDeleted'));

    return redirect()->to('/admin/product');
  }

  public function edit($id)
  {
    $data = [
      'nav' => 'product',
      'title' => lang('Admin.editProduct'),
      'validation' => \Config\Services::validation(),
      'product' => $this->productModel->find($id),
      'categories' => $this->categoryModel->findAll(),
    ];

    return view('admin/product/edit', $data);
  }

  public function update($id)
  {
    $product = $this->productModel->find($id);
    $rules = $this->saveRules;
    $rules['name'] = [
      'label' => "Name",
      'rules' => "required|is_unique[products.name, id, $id]",
    ];
    if (!$this->validate($rules)) {
      return redirect()->to('/admin/product/edit/' . $id)->withInput();
    }

    $data = [
      'id' => $id,
      'name' => $this->request->getVar('name'),
      'slug' => url_title($this->request->getVar('name'), '-', true),
      'category_id' => (int)$this->request->getVar('category'),
      'price' => (int)$this->request->getVar('price'),
      'domestic_stock' => (int)$this->request->getVar('domestic_stock'),
      'international_stock' => (int)$this->request->getVar('international_stock'),
      'detail' => $this->request->getVar('detail'),
      'image' => $this->getProductImage($this->request->getFile('image'), $product),
    ];

    $this->productModel->save($data);

    session()->setFlashdata('success', lang('Admin.productUpdated'));

    return redirect()->to('/admin/product');
  }

  public function getProductImage($fileImage, $product = null)
  {
    if ($fileImage->getError() == 4) {
      return ($product != null) ? $product['image'] : 'product-default.jpg';
    }

    $fileName = $fileImage->getRandomName();
    $fileImage->move('images/product-images', $fileName);
    if ($product != null && $product['image'] != 'product-default.jpg') {
      unlink('images/product-images/' . $product['image']);
    }
    return $fileName;
  }
}
