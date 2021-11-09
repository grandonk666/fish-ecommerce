<?php

namespace App\Controllers;

use App\Models\InternationalTransactionModel;
use App\Models\ProductModel;
use CodeIgniter\I18n\Time;

class International extends BaseController
{
  protected $productModel, $internatioanalTransactionModel;
  protected $saveRules = [
    'company_name' => [
      'label' => "Company Name",
      'rules' => 'required',
    ],
    'address' => [
      'label' => "Address",
      'rules' => 'required',
    ],
    'product_id' => [
      'label' => "Product",
      'rules' => 'required',
    ],
  ];

  public function __construct()
  {
    $this->productModel = new ProductModel();
    $this->internatioanalTransactionModel = new InternationalTransactionModel();
  }

  public function index()
  {
    $data = [
      'title' => 'International',
      'nav' => 'shop',
      'products' => $this->productModel->findAll()
    ];

    return view('/international/index', $data);
  }

  public function order($slug)
  {
    $data = [
      'title' => 'International',
      'nav' => 'shop',
      'validation' => \Config\Services::validation(),
      'product' => $this->productModel->getProduct($slug)
    ];

    return view('/international/order', $data);
  }

  public function save($slug)
  {
    if (!$this->validate($this->saveRules)) {
      return redirect()->to('/international/' . $slug)->withInput();
    }

    $data = [
      'user_id' => user_id(),
      'product_id' => (int)$this->request->getVar('product_id'),
      'company_name' => $this->request->getVar('company_name'),
      'address' => $this->request->getVar('address'),
      'status' => 'Waiting Approvement'
    ];

    $product = $this->productModel->find($data['product_id']);

    $this->internatioanalTransactionModel->save($data);
    $this->productModel->save([
      'id' => $product['id'],
      'international_stock' => $product['international_stock'] - 1
    ]);

    session()->setFlashdata('success', 'Order Successfull');

    return redirect()->to('/profile/international');
  }

  public function payment()
  {
    $rules = [
      'payment' => [
        'label' => 'Payment',
        'rules' => 'max_size[payment,2048]',
      ]
    ];
    if (!$this->validate($rules)) {
      return redirect()->to('/profile/international/' . $this->request->getVar('transaction_id'))
        ->withInput();
    }

    $transaction = $this->internatioanalTransactionModel->find($this->request->getVar('transaction_id'));
    if ($transaction['status'] != 'Waiting Payment') {
      session()->setFlashdata('error', 'Dont Need Payment');
      return redirect()->to('/profile/international/' . $this->request->getVar('transaction_id'));
    }

    $payment = $this->getPaymentFile($this->request->getFile('payment'), $transaction);
    if (!$payment) {
      session()->setFlashdata('error', 'Upload Failed');
      return redirect()->to('/profile/international/' . $this->request->getVar('transaction_id'));
    }

    $this->internatioanalTransactionModel->save([
      'id' => $transaction['id'],
      'payment' => $payment,
      'status' => 'Checking Payment'
    ]);

    session()->setFlashdata('success', 'Payment Updated');

    return redirect()->to('/profile/international/' . $this->request->getVar('transaction_id'));
  }

  public function getPaymentFile($uploadedFile, $transaction)
  {
    if ($uploadedFile->getError() == 4) {
      return null;
    }

    $originalName = $uploadedFile->getClientName();
    $names = explode('.', $originalName);
    $originalName = $names[0];
    $ext = $uploadedFile->getClientExtension();
    $time = Time::now();
    $time = $time->toDateString();
    $fileName = $originalName . $time . '.' . $ext;
    $uploadedFile->move('payment', $fileName);
    if ($transaction['payment']) {
      unlink('payment/' . $transaction['payment']);
    }
    return $fileName;
  }
}
