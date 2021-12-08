<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;

class AdminCategory extends BaseController
{
  protected $categoryModel, $productModel;
  protected $saveRules = [
    'name' => [
      'label' => "Name",
      'rules' => 'required|is_unique[products.name]',
    ],
    'image' => [
      'label' => 'Image',
      'rules' => 'max_size[image,1024]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]',
    ]
  ];
  public function __construct()
  {
    $this->categoryModel = new CategoryModel();
    $this->productModel = new ProductModel();
  }

  public function index()
  {
    $dataCategory = $this->categoryModel->findAll();
    $dataProducts = $this->productModel->findAll();
    $categories = array_map(function ($category) use ($dataProducts) {
      $products = array_filter($dataProducts, function ($product) use ($category) {
        return $product['category_id'] == $category['id'];
      });
      $category['products'] = $products;
      return $category;
    }, $dataCategory);

    $data = [
      'nav' => 'category',
      'title' => lang('Admin.dataCategories'),
      'categories' => $categories
    ];

    return view('admin/category/index', $data);
  }

  public function create()
  {
    $data = [
      'nav' => 'category',
      'title' => lang('Admin.addCategory'),
      'validation' => \Config\Services::validation()
    ];

    return view('admin/category/create', $data);
  }

  public function save()
  {
    if (!$this->validate($this->saveRules)) {
      return redirect()->to('/admin/category/create')->withInput();
    }

    $data = [
      'name' => $this->request->getVar('name'),
      'slug' => url_title($this->request->getVar('name'), '-', true),
      'image' => $this->getCategoryImage($this->request->getFile('image')),
    ];

    $this->categoryModel->save($data);

    session()->setFlashdata('success', lang('Admin.categoryAdded'));

    return redirect()->to('/admin/category');
  }

  public function delete($id)
  {
    $category = $this->categoryModel->find($id);
    if ($category['image'] != 'default-category.jpg') {
      unlink('images/category-images/' . $category['image']);
    }

    $this->categoryModel->delete($id);

    session()->setFlashdata('success', lang('Admin.categoryDeleted'));

    return redirect()->to('/admin/category');
  }

  public function edit($id)
  {
    $category = $this->categoryModel->find($id);

    $data = [
      'nav' => 'category',
      'title' => lang('Admin.editCategory'),
      'validation' => \Config\Services::validation(),
      'category' => $category,
    ];

    return view('admin/category/edit', $data);
  }

  public function update($id)
  {
    $category = $this->categoryModel->find($id);
    $rules = $this->saveRules;
    $rules['name'] = [
      'label' => "Name",
      'rules' => "required|is_unique[categories.name, id, $id]",
    ];

    if (!$this->validate($rules)) {
      return redirect()->to('/admin/category/edit/' . $category['id'])->withInput();
    }

    $data = [
      'id' => $id,
      'name' => $this->request->getVar('name'),
      'slug' => url_title($this->request->getVar('name'), '-', true),
      'image' => $this->getCategoryImage($this->request->getFile('image'), $category),
    ];

    $this->categoryModel->save($data);

    session()->setFlashdata('success', lang('Admin.categoryUpdated'));

    return redirect()->to('/admin/category');
  }

  public function getCategoryImage($fileImage, $category = null)
  {
    if ($fileImage->getError() == 4) {
      return ($category != null) ? $category['image'] : 'category-default.jpg';
    }

    $fileName = $fileImage->getRandomName();
    $fileImage->move('images/category-images', $fileName);
    if ($category != null && $category['image'] != 'category-default.jpg') {
      unlink('images/category-images/' . $category['image']);
    }
    return $fileName;
  }
}
