<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use Dompdf\Dompdf;
use Myth\Auth\Models\UserModel;

class Home extends BaseController
{
  protected $transactionModel, $userModel;
  public function __construct()
  {
    $this->userModel = new UserModel();
    $this->transactionModel = new TransactionModel();
  }

  public function index()
  {
    return view('index');
  }

  public function about()
  {
    return view('about');
  }

  public function download($id)
  {
    $transaction = $this->transactionModel->find($id);
    if ($transaction['user_id'] != user_id()) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    if ($transaction['status'] == 'Settlement' || $transaction['status'] == 'On Delivery') {

      $transaction['order'] = json_decode($transaction['order'], true);
      $transaction['user'] = $this->userModel->find($transaction['user_id']);

      $data = [
        'title' => 'Bill | Sok Kabeh',
        'transaction' => $transaction,
      ];

      $dompdf = new Dompdf();
      $dompdf->loadHtml(view('bill/transaction_bill', $data));
      $dompdf->setPaper('A4');
      $dompdf->render();
      ob_end_clean();
      $dompdf->stream('Sok Kabeh | Bill', array("Attachment" => true));
      return;
    }

    return redirect()->to('/profile/transaction/' . $id);
  }
}
