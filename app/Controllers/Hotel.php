<?php

namespace App\Controllers;

use App\Models\KamarModel;
use App\Models\RuanganModel;
use App\Models\TransaksiModel;
use Midtrans\Snap;
use Dompdf\Dompdf;

class Hotel extends BaseController
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
		$data = [
			'title' => 'Sunset Hotel',
			'nav' => 'home',
			'kamar' => $this->kamarModel->where(['featured' => 1])->findAll()
		];

		return view('hotel/index', $data);
	}

	public function rooms()
	{
		$kamar = $this->kamarModel->getKamar();
		$daftarTipe = array_unique($this->kamarModel->findColumn('tipe'));
		$hargaTertinggi = max($this->kamarModel->findColumn('harga'));
		$luasTerendah = min($this->kamarModel->findColumn('luas'));
		$kapasitasTerendah = min($this->kamarModel->findColumn('kapasitas'));

		if ($this->request->getVar())
		{
			$tipe = $this->request->getVar('tipe');
			$luas = (int)$this->request->getVar('luas');
			$kapasitas = (int)$this->request->getVar('kapasitas');
			$harga = (int)$this->request->getVar('harga');
			$hewan = ($this->request->getVar('hewan')) ? 1 : 0;
			$sarapan = ($this->request->getVar('sarapan')) ? 1 : 0;
			$internet = ($this->request->getVar('internet')) ? 1 : 0;

			$filter = [
				'luas >=' => $luas,
				'kapasitas >=' => $kapasitas,
				'harga <=' => $harga,
				'hewan' => $hewan,
				'sarapan' => $sarapan,
				'internet' => $internet,
			];
			if ($tipe != 'all')
			{
				$filter['tipe'] = $tipe;
			}

			$kamar = $this->kamarModel->where($filter)->findAll();
		}

		// dd($this->kamarModel->where('harga <=', 500000)->findAll());

		$data = [
			'title' => 'Sunset Hotel | Rooms',
			'nav' => 'rooms',
			'kamar' => $kamar,
			'daftarTipe' => $daftarTipe,
			'hargaTertinggi' => $hargaTertinggi,
			'luasTerendah' => $luasTerendah,
			'kapasitasTerendah' => $kapasitasTerendah,
		];

		return view('hotel/rooms', $data);
	}

	public function detail($slug)
	{
		$kamar = $this->kamarModel->getKamar($slug);
		$gallery = null;

		if ($kamar)
		{
			// throw new \CodeIgniter\Exceptions\PageNotFoundException('Kamar tidak ditemukan');
			// dd($kamar);
			$gallery = json_decode($kamar['gallery'], true);
		}

		$data = [
			'title' => 'Room | Sunset Hotel',
			'nav' => 'rooms',
			'kamar' => $kamar,
			'gallery' => $gallery
		];


		return view('hotel/detail', $data);
	}

	public function order($slug)
	{
		if (!logged_in())
		{
			return redirect()->to('/login');
		}

		$kamar = $this->kamarModel->getKamar($slug);
		$ruanganTersedia = $this->ruanganModel->where(['id_kamar' => $kamar['id'], 'tersedia' => 1])->findAll();

		$data = [
			'title' => 'Order | Sunset Hotel',
			'nav' => 'order',
			'kamar' => $kamar,
			'ruangan_tersedia' => $ruanganTersedia,
			'validation' => \Config\Services::validation()
		];

		return view('hotel/order', $data);
	}

	public function payment($slug)
	{
		if (!$this->validate([
			'first-name' => [
				'label' => "First Name",
				'rules' => 'required',
				'errors' => [
					'required' => '{field} must filled',
				]
			],
			'last-name' => [
				'label' => "Last Name",
				'rules' => 'required',
				'errors' => [
					'required' => '{field} must filled',
				]
			],
			'email' => [
				'label' => "Email",
				'rules' => 'required|valid_email',
				'errors' => [
					'required' => '{field} must filled',
				]
			],
			'phone' => [
				'label' => "Phone",
				'rules' => 'required',
				'errors' => [
					'required' => '{field} must filled',
				]
			],
			'ruangan' => [
				'label' => "Room",
				'rules' => 'required',
				'errors' => [
					'required' => '{field} must filled',
				]
			],
		]))
		{
			return redirect()->to('/order/' . $slug)->withInput();
		}


		$kamar = $this->kamarModel->getKamar($slug);
		$ruangan = $this->ruanganModel->find((int)$this->request->getVar('ruangan'));

		$adminFee = 5000;
		$price = $kamar['harga'] + $adminFee;

		$transaction_details = [
			'order_id' => rand(),
			'gross_amount' => $price, // no decimal allowed for creditcard
		];

		$item_details = [
			[
				'id' => $kamar['id'],
				'price' => $price,
				'quantity' => 1,
				'name' => $kamar['nama'] . ' Room No. ' . $ruangan['nomor_ruangan'],
			]
		];

		$customer_details = [
			'first_name'    => $this->request->getVar('first-name'),
			'last_name'     => $this->request->getVar('last-name'),
			'email'         => $this->request->getVar('email'),
			'phone'         => $this->request->getVar('phone'),
		];

		$enable_payments = ["permata_va", "bca_va", "bni_va", "bri_va", "other_va",  "Indomaret", "alfamart", "gopay"];

		$transaction = [
			'enabled_payments' => $enable_payments,
			'transaction_details' => $transaction_details,
			'customer_details' => $customer_details,
			'item_details' => $item_details,
		];

		$snapToken = Snap::getSnapToken($transaction);

		$data = [
			'title' => 'Payment | Sunset Hotel',
			'nav' => 'order',
			'kamar' => $kamar,
			'ruangan' => $ruangan,
			'snapToken' => $snapToken,
			'transaction_details' => $transaction_details,
			'item_details' => $item_details[0],
			'customer_details' => $customer_details,
		];

		return view('hotel/payment', $data);
	}

	public function finish()
	{
		$result = json_decode($this->request->getVar('result_data'), true);
		$nama = $this->request->getVar('nama');
		$item = $this->request->getVar('item');
		$kamarId = (int)$this->request->getVar('kamar_id');
		$ruanganId = (int)$this->request->getVar('ruangan_id');
		$kamar = $this->kamarModel->find($kamarId);

		if ($result['payment_type'] == 'bank_transfer')
		{
			$paymentCode = $result['va_numbers'][0]['va_number'];
			$payType = 'BANK TRANSFER';
		}
		elseif ($result['payment_type'] == 'cstore')
		{
			$paymentCode = $result['payment_code'];
			$payType = 'ALFAMART / INDOMARET';
		}
		else
		{
			$paymentCode = '';
			$payType = 'GOPAY';
		}

		if (array_key_exists('pdf_url', $result))
		{
			$url = $result['pdf_url'];
		}
		else
		{
			$url = '';
		}

		$data = [
			'order_id' => $result['order_id'],
			'user_id' => user_id(),
			'customer_name' => $nama,
			'item_name' => $item,
			'id_kamar' => $kamarId,
			'id_ruangan' => $ruanganId,
			'gross_amount' => $result['gross_amount'],
			'payment_type' => $payType,
			'transaction_status' => $result['transaction_status'],
			'transaction_id' => $result['transaction_id'],
			'status_code' => $result['status_code'],
			'payment_code' => $paymentCode,
			'pdf_url' => $url,
		];

		$this->transaksiModel->save($data);
		$this->ruanganModel->save([
			'id' => $ruanganId,
			'tersedia' => 0,
		]);
		$this->kamarModel->save([
			'id' => $kamarId,
			'number_order' => $kamar['number_order'] + 1,
		]);

		return redirect()->to('/transaction');
	}

	public function transaction()
	{
		$transaksi = null;
		$detail = $this->getTransactionDetail();

		if ($this->request->getVar('order_id'))
		{
			$order_id = $this->request->getVar('order_id');
			$transaksi = $this->transaksiModel->where(['order_id' => $order_id])->first();
			$detail = $this->getTransactionDetail($order_id);
		}

		$data = [
			'title' => 'Transaction | Sunset Hotel',
			'nav' => 'transaction',
			'transaksi' => $transaksi,
			'pesan' => $detail['pesan'],
			'pdf' => $detail['pdf'],
			'bill' => $detail['bill'],
			'badge' => $detail['badge'],
		];

		return view('hotel/transaction', $data);
	}

	public function download($id)
	{
		$transaksi = $this->transaksiModel->find($id);

		$data = [
			'title' => 'Bill | Sunset Hotel',
			'transaksi' => $transaksi,
		];

		$dompdf = new Dompdf();
		$dompdf->loadHtml(view('bill/transaction_bill', $data));
		$dompdf->setPaper('A4', 'landscape');
		$dompdf->render();
		ob_end_clean();
		$dompdf->stream('Sunset Hotel', array("Attachment" => false));
	}

	public function getTransactionDetail($order_id = false)
	{
		if ($order_id == false)
		{
			return [
				'pesan' => '',
				'pdf' => '',
				'bill' => '',
				'badge' => '',
			];
		}

		$transaksi = $this->transaksiModel->where(['order_id' => $order_id])->first();

		if ($transaksi == null)
		{
			return [
				'pesan' => 'Transaction with Order ID ' . $order_id . ' is not found !',
				'pdf' => '',
				'bill' => '',
				'badge' => '',
			];
		}
		switch ($transaksi['transaction_status'])
		{
			case 'Challenge by FDS':
				return [
					'pesan' => 'Your transaction is challenged by FDS, try order again and use different payment nethod',
					'badge' => 'warning',
					'pdf' => '',
					'bill' => '',
				];
				break;
			case 'Success':
				return [
					'pesan' => 'Your transaction is success and waiting for you to complete the payment',
					'pdf' => $transaksi['pdf_url'],
					'badge' => 'primary',
					'bill' => '',
				];
				break;
			case 'Settlement':
				return [
					'pesan' => 'Your transaction has been paid for and we have sent you an email as proof of payment, please check your email',
					'badge' => 'success',
					'bill' => $transaksi['id'],
					'pdf' => '',
				];
				break;
			case 'Pending':
				return [
					'pesan' => 'Your transaction is waiting to be paid, please pay using the payment method you choose',
					'pdf' => $transaksi['pdf_url'],
					'badge' => 'warning',
					'bill' => '',
				];
				break;
			case 'Denied':
				return [
					'pesan' => 'Your transaction is denied, please try to order again and make sure you are complete the order form',
					'badge' => 'danger',
					'pdf' => '',
					'bill' => '',
				];
				break;
			case 'Expire':
				return [
					'pesan' => 'Your transaction has expired because it has passed the time limit',
					'badge' => 'danger',
					'pdf' => '',
					'bill' => '',
				];
				break;
			case 'Canceled':
				return [
					'pesan' => 'Your transaction is canceled, you can try to order again',
					'badge' => 'danger',
					'pdf' => '',
					'bill' => '',
				];
				break;

			default:
				return [
					'pesan' => 'Your transaction is success and waiting for you to complete the payment',
					'badge' => 'primary',
					'pdf' => '',
					'bill' => '',
				];
				break;
		}
	}
}
