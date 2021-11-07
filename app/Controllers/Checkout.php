<?php

namespace App\Controllers;

class Checkout extends BaseController
{
  protected $client, $cart;

  public function __construct()
  {
    $this->client = \Config\Services::curlrequest();
    $this->cart = \Config\Services::cart();
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
}
