<?php

namespace App\Controllers;

use App\Models\KamarModel;
use App\Models\RuanganModel;
use App\Models\TransaksiModel;

class Dashboard extends BaseController
{
  protected $kamarModel, $ruanganModel, $transaksiModel;
  public function __construct()
  {
    $this->kamarModel = new KamarModel();
    $this->ruanganModel = new RuanganModel();
    $this->transaksiModel = new TransaksiModel();
  }

  public function index()
  {
    $countKamar = $this->kamarModel->getCountKamar();
    $countRuangan = $this->ruanganModel->getCountRuangan();
    $sumOrder = $this->kamarModel->getSumOrder();
    $sumPendapatan = $this->transaksiModel->getSumPendapatan();
    $lastTrx = $this->transaksiModel->getLatestTrx();
    $trxGrafik = $this->transaksiModel->getTransaksiGrafik();
    $tipeGrafik = $this->transaksiModel->getTipeGrafik();
    $kamarGrafik = $this->kamarModel->getKamarGrafik();

    foreach ($lastTrx as $trx => $t)
    {
      switch ($lastTrx[$trx]['transaction_status'])
      {
        case 'Challenge by FDS':
          $lastTrx[$trx]['badge'] = 'warning';
          break;
        case 'Success':
          $lastTrx[$trx]['badge'] = 'primary';
          break;
        case 'Settlement':
          $lastTrx[$trx]['badge'] = 'success';
          break;
        case 'Pending':
          $lastTrx[$trx]['badge'] = 'warning';
          break;
        case 'Denied':
          $lastTrx[$trx]['badge'] = 'danger';
          break;
        case 'Expire':
          $lastTrx[$trx]['badge'] = 'danger';
          break;
        case 'Canceled':
          $lastTrx[$trx]['badge'] = 'danger';
          break;

        default:
          $lastTrx[$trx]['badge'] = 'primary';
          break;
      }
    }

    $data = [
      'nav' => 'dashboard',
      'title' => 'Dashboard',
      'total_kamar' => $countKamar,
      'total_ruangan' => $countRuangan,
      'total_order' => $sumOrder,
      'total_pendapatan' => $sumPendapatan,
      'trx_grafik' => $trxGrafik,
      'tipe_grafik' => $tipeGrafik,
      'kamar_grafik' => $kamarGrafik,
      'transaksi_terakhir' => $lastTrx
    ];

    return view('admin/dashboard/index', $data);
  }
}
