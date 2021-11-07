<?php

namespace App\Controllers;

use Myth\Auth\Models\UserModel;

class AdminUser extends BaseController
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
      'users' => $this->userModel->findAll(),
    ];
    return view('admin/user/index', $data);
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
