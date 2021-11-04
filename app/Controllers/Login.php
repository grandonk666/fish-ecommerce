<?php

namespace App\Controllers;

class Login extends BaseController
{
  public function index()
  {
    $data = [
      'title' => 'Login',
      'nav' => 'Login',
    ];
    return view('auth/login', $data);
  }

  public function auth()
  {
    $session = session();
    $username = $this->request->getVar('username');
    $password = $this->request->getVar('password');
    $data = ['username' => 'admin', 'password' => 'admin'];
    if ($data['username'] == $username)
    {
      if ($data['password'] == $password)
      {
        $ses_data = [
          'user_name'     => $data['username'],
          'logged_in'     => TRUE
        ];
        $session->set($ses_data);
        return redirect()->to('/admin');
      }
      else
      {
        $session->setFlashdata('msg', 'Password Salah');
        return redirect()->to('/login');
      }
    }
    else
    {
      $session->setFlashdata('msg', 'Username Tidak Ditemukan');
      return redirect()->to('/login');
    }
  }

  public function logout()
  {
    $session = session();
    $session->destroy();
    return redirect()->to('/login');
  }
}
