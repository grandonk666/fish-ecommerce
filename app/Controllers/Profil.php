<?php

namespace App\Controllers;

use Myth\Auth\Models\UserModel;
use App\Models\TransaksiModel;

class Profil extends BaseController
{
  protected $userModel, $transaksiModel;
  public function __construct()
  {
    $this->userModel = new UserModel();
    $this->transaksiModel = new TransaksiModel();
  }

  public function index()
  {
    $data = [
      'title' => 'My Profile',
      'nav' => 'profil',
      'user' => user(),
    ];
    return view('user/index', $data);
  }

  public function edit()
  {
    $data = [
      'title' => 'Settings',
      'validation' => \Config\Services::validation(),
      'nav' => 'settings',
      'user' => user(),
    ];
    return view('user/edit', $data);
  }

  public function update()
  {
    $id = user()->id;

    $rules = [
      'username'    => "required|alpha_numeric_space|min_length[3]|is_unique[users.username, id, $id]",
      'firstname'    => 'required|alpha_numeric_space|min_length[3]',
      'lastname'    => 'required|alpha_numeric_space|min_length[3]',
      'phone'    => 'required|numeric|min_length[3]',
      'image' => 'max_size[user_image,1024]|is_image[user_image]|mime_in[user_image,image/jpg,image/jpeg,image/png]'
    ];

    if (!$this->validate($rules))
    {
      return redirect()->to('/profile/settings')->withInput();
    }

    $data = [
      'id' => $id,
      'username' => $this->request->getVar('username'),
      'firstname' => $this->request->getVar('firstname'),
      'lastname' => $this->request->getVar('lastname'),
      'phone' => $this->request->getVar('phone'),
      'user_image' => $this->getFoto($this->request->getFile('user_image')),
    ];

    $this->userModel->save($data);

    session()->setFlashdata('pesan', 'Data berhasil diubah');

    return redirect()->to('/profile');
  }

  public function transaksi()
  {
    $dataTransaksi = $this->transaksiModel->where('user_id', user_id())->orderBy('created_at', 'desc')->findAll();

    if ($this->request->getVar('keyword'))
    {
      $dataTransaksi = $this->transaksiModel->getSearch($this->request->getVar('keyword'), user_id());
    }

    foreach ($dataTransaksi as $trx => $t)
    {
      switch ($dataTransaksi[$trx]['transaction_status'])
      {
        case 'Challenge by FDS':
          $dataTransaksi[$trx]['badge'] = 'warning';
          break;
        case 'Success':
          $dataTransaksi[$trx]['badge'] = 'primary';
          break;
        case 'Settlement':
          $dataTransaksi[$trx]['badge'] = 'success';
          break;
        case 'Pending':
          $dataTransaksi[$trx]['badge'] = 'warning';
          break;
        case 'Denied':
          $dataTransaksi[$trx]['badge'] = 'danger';
          break;
        case 'Expire':
          $dataTransaksi[$trx]['badge'] = 'danger';
          break;
        case 'Canceled':
          $dataTransaksi[$trx]['badge'] = 'danger';
          break;

        default:
          $dataTransaksi[$trx]['badge'] = 'primary';
          break;
      }
    }

    $data = [
      'nav' => 'transaksi user',
      'title' => 'Transaksi User',
      'transaksi' => $dataTransaksi,
    ];

    return view('user/transaksi', $data);
  }

  public function order($transactionId)
  {
    $transaksi = $this->transaksiModel->find($transactionId);
    $detail = $this->getTransactionDetail($transaksi);

    $data = [
      'title' => 'Detail Transaksi',
      'nav' => 'transaksi user',
      'transaksi' => $transaksi,
      'pesan' => $detail['pesan'],
      'pdf' => $detail['pdf'],
      'bill' => $detail['bill'],
      'badge' => $detail['badge'],
    ];

    return view('user/order', $data);
  }

  public function getFoto($fileFoto)
  {
    if ($fileFoto->getError() == 4)
    {
      return user()->user_image;
    }

    $namaFoto = $fileFoto->getRandomName();
    $fileFoto->move('images', $namaFoto);
    if (user()->user_image != 'profile-default.png')
    {
      unlink('images/' . user()->user_image);
    }
    return $namaFoto;
  }

  public function getTransactionDetail($transaksi)
  {
    switch ($transaksi['transaction_status'])
    {
      case 'Challenge by FDS':
        return [
          'pesan' => 'Transaksi Anda terhalang oleh FDS, Anda bisa mencoba melakukan order ulang dan gunakan metode pembayaran yang berbeda',
          'badge' => 'warning',
          'pdf' => '',
          'bill' => '',
        ];
        break;
      case 'Success':
        return [
          'pesan' => 'Transaksi Anda berhasil dan menunggu Anda menyelesaikan pembayaran',
          'pdf' => $transaksi['pdf_url'],
          'badge' => 'primary',
          'bill' => '',
        ];
        break;
      case 'Settlement':
        return [
          'pesan' => 'Transaksi Anda telah dibayar dan kami telah mengirimkan email sebagai bukti pembayaran, silakan periksa email Anda',
          'badge' => 'success',
          'bill' => $transaksi['id'],
          'pdf' => '',
        ];
        break;
      case 'Pending':
        return [
          'pesan' => 'Transaksi Anda sedang menunggu pembayaran, harap segera bayar menggunakan metode pembayaran yang Anda pilih',
          'pdf' => $transaksi['pdf_url'],
          'badge' => 'warning',
          'bill' => '',
        ];
        break;
      case 'Denied':
        return [
          'pesan' => 'Transaksi Anda ditolak, coba pesan lagi dan pastikan Anda sudah melengkapi formulir pemesanan',
          'badge' => 'danger',
          'pdf' => '',
          'bill' => '',
        ];
        break;
      case 'Expire':
        return [
          'pesan' => 'Transaksi Anda telah kedaluwarsa karena telah melewati batas waktu yang telah ditentukan',
          'badge' => 'danger',
          'pdf' => '',
          'bill' => '',
        ];
        break;
      case 'Canceled':
        return [
          'pesan' => 'Transaksi Anda dibatalkan, Anda dapat mencoba memesan lagi',
          'badge' => 'danger',
          'pdf' => '',
          'bill' => '',
        ];
        break;

      default:
        return [
          'pesan' => '',
          'badge' => '',
          'pdf' => '',
          'bill' => '',
        ];
        break;
    }
  }
}
