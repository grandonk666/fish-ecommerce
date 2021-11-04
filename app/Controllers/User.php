<?php

namespace App\Controllers;

use Myth\Auth\Models\UserModel;

class User extends BaseController
{
  protected $userModel, $db, $builder;
  public function __construct()
  {
    $this->db      = \Config\Database::connect();
    $this->builder = $this->db->table('auth_groups_users');
    $this->userModel = new UserModel();
  }

  public function index()
  {
    // $this->userModel->changeUserGroup($this->userModel->find(2), 'admin');

    $data = [
      'title' => 'Data User',
      'nav' => 'user',
      'user' => $this->userModel->findAll(),
    ];
    return view('admin/user/index', $data);
  }

  public function detail($id)
  {
    $data = [
      'title' => 'Detail User',
      'nav' => 'user',
      'user' => $this->userModel->find($id),
    ];
    return view('admin/user/detail', $data);
  }

  public function delete($id)
  {
    $user = $this->userModel->find($id);
    if ($user->user_image != 'profile-default.jpeg')
    {
      // hapus gambar
      unlink('images/' . $user->user_image);
    }

    $this->builder->delete(['user_id' => $id]);

    $this->userModel->delete($id);

    session()->setFlashdata('pesan', 'Data berhasil dihapus');

    return redirect()->to('/admin/user');
  }

  public function role($id)
  {
    $this->userModel->changeUserGroup(
      $this->userModel->find($id),
      $this->request->getVar('role')
    );

    return redirect()->to('/admin/user');
  }
}
