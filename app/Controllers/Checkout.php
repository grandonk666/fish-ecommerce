<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\TransactionModel;

class Checkout extends BaseController
{
  protected $client, $cart, $productModel, $transactionModel;

  public function __construct()
  {
    $this->client = \Config\Services::curlrequest();
    $this->cart = \Config\Services::cart();
    $this->productModel = new ProductModel();
    $this->transactionModel = new TransactionModel();
  }

  public function index()
  {
    if (!count($this->cart->contents())) {
      return redirect()->to('/cart');
    }

    $response = $this->client->get('https://api.rajaongkir.com/starter/province', [
      'headers' => ['key' => 'f26ecb1fd37bc662a35832e653f4a3fa']
    ]);

    $body = $response->getBody();
    if (strpos($response->getHeader('content-type'), 'application/json') !== false) {
      $body = json_decode($body, true);
    }

    $listProvince = $body['rajaongkir']['results'];

    $data = [
      'listProvince' => $listProvince,
      'validation' => \Config\Services::validation(),
      'subtotal' => $this->cart->total()
    ];

    return view('checkout', $data);
  }

  public function get_cities()
  {
    $response = $this->client->get('https://api.rajaongkir.com/starter/city?province=' . $this->request->getVar('province_id'), [
      'headers' => ['key' => 'f26ecb1fd37bc662a35832e653f4a3fa']
    ]);

    $body = $response->getBody();
    if (strpos($response->getHeader('content-type'), 'application/json') !== false) {
      $body = json_decode($body, true);
    }

    $listCity = $body['rajaongkir']['results'];

    return $this->response->setJSON($listCity);
  }

  public function get_costs()
  {
    $response = $this->client->post('https://api.rajaongkir.com/starter/cost', [
      'headers' => ['key' => 'f26ecb1fd37bc662a35832e653f4a3fa'],
      'form_params' => [
        'origin' => '444',
        'destination' => $this->request->getVar('city_id'),
        'weight' => 1000,
        'courier' => 'jne'
      ]
    ]);

    $body = $response->getBody();
    if (strpos($response->getHeader('content-type'), 'application/json') !== false) {
      $body = json_decode($body, true);
    }

    $listCost = $body['rajaongkir']['results'][0]['costs'];

    return $this->response->setJSON($listCost);
  }

  public function get_token()
  {
    \Midtrans\Config::$serverKey = 'SB-Mid-server-nDv_Z65iSjuX0xw6zXK6MeuD';
    \Midtrans\Config::$isProduction = false;
    \Midtrans\Config::$isSanitized = true;
    \Midtrans\Config::$is3ds = true;

    $transaction_details = [
      'order_id' => 'ID_' . rand(),
      'gross_amount' => (int)$this->cart->total() + (int)$this->request->getVar('delivery_cost'),
    ];

    $item_details = [];
    foreach ($this->cart->contents() as $cart) {
      $product = $this->productModel->find($cart['id']);

      $item = [
        "id" => $product['id'],
        "price" => $product['price'],
        "quantity" => $cart['qty'],
        "name" => $product['name']
      ];
      array_push($item_details, $item);
    }
    array_push($item_details, [
      "id" => "DELIVERY_" . rand(),
      "price" => (int)$this->request->getVar('delivery_cost'),
      "quantity" => 1,
      "name" => $this->request->getVar('delivery_service') . ' to ' . $this->request->getVar('city')
    ]);

    $customer_details = [
      'first_name'    => user()->firstname,
      'last_name'     => user()->lastname,
      'email'         => user()->email,
      'phone'         => user()->phone,
    ];

    $shipping_address = [
      'first_name'    => user()->firstname,
      'last_name'     => user()->lastname,
      'email'         => user()->email,
      'phone'         => user()->phone,
      "address"  => $this->request->getVar('delivery_address'),
      "city" => $this->request->getVar('city'),
      "postal_code" => $this->request->getVar('postal_code'),
      "country_code" => "IDN"
    ];

    $customer_details["shipping_address"] = $shipping_address;

    $enable_payments = ["bca_va", "bni_va", "bri_va", "other_va",  "Indomaret", "alfamart", "gopay"];

    $transaction = [
      'enabled_payments' => $enable_payments,
      'transaction_details' => $transaction_details,
      'customer_details' => $customer_details,
      'item_details' => $item_details,
    ];

    $snapToken = \Midtrans\Snap::getSnapToken($transaction);

    return $this->response->setJSON(['token' => $snapToken, 'list_items' => $item_details]);
  }

  public function finish()
  {
    $result = json_decode($this->request->getVar('result_data'), true);

    if ($result['payment_type'] == 'bank_transfer') {
      $paymentCode = $result['va_numbers'][0]['va_number'];
      $payType = 'BANK TRANSFER';
    } elseif ($result['payment_type'] == 'cstore') {
      $paymentCode = $result['payment_code'];
      $payType = 'ALFAMART / INDOMARET';
    } else {
      $paymentCode = '';
      $payType = 'GOPAY';
    }

    if (array_key_exists('pdf_url', $result)) {
      $url = $result['pdf_url'];
    } else {
      $url = '';
    }

    $data = [
      'serial_number' => $result['order_id'],
      'transaction_id' => $result['transaction_id'],
      'user_id' => user_id(),
      'status' => $result['transaction_status'],
      'status_code' => $result['status_code'],
      'total' => $result['gross_amount'],
      'province' => $this->request->getVar('province'),
      'city' => $this->request->getVar('city'),
      'address' => $this->request->getVar('delivery_address'),
      'order' => $this->request->getVar('list_items'),
      'payment_type' => $payType,
      'payment_code' => $paymentCode,
      'pdf_url' => $url,
      'delivery_cost' => (int)$this->request->getVar('delivery_cost'),
      'delivery_service' => $this->request->getVar('delivery_service')
    ];

    $this->transactionModel->save($data);

    $this->cart->destroy();

    session()->setFlashdata('success', 'Order Successfull');

    return redirect()->to('/profile/transaction');
  }
}
