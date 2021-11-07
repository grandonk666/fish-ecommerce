<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <link href="<?= base_url('/images/favicon.png') ?>" rel="icon" />
  <link href="<?= base_url('/images/favicon.png') ?>" rel="apple-touch-icon" />

  <title><?= $title; ?></title>

  <link href="<?= base_url('/admin-asset/css/app.css') ?>" rel="stylesheet" />
</head>

<body>
  <div class="wrapper">
    <nav id="sidebar" class="sidebar d-print-none">
      <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="<?= base_url('/admin'); ?>">
          <span class="text-white">Sok Kabeh</span>
        </a>

        <ul class="sidebar-nav">

          <?php if (in_groups('admin')) : ?>
            <li class="sidebar-header">
              Administrator
            </li>
            <li class="sidebar-item <?= ($nav == 'product') ? 'active' : '' ?>">
              <a class="sidebar-link" href="<?= base_url('/admin/product'); ?>">
                <i class="align-middle" data-feather="database"></i>
                <span class="align-middle">Products</span>
              </a>
            </li>
            <li class="sidebar-item <?= ($nav == 'category') ? 'active' : '' ?>">
              <a class="sidebar-link" href="<?= base_url('/admin/category'); ?>">
                <i class="align-middle" data-feather="layers"></i>
                <span class="align-middle">Categories</span>
              </a>
            </li>
            <li class="sidebar-item <?= ($nav == 'admin_transaction') ? 'active' : '' ?>">
              <a class="sidebar-link" href="<?= base_url('/admin/transaction'); ?>">
                <i class="align-middle" data-feather="dollar-sign"></i>
                <span class="align-middle">Transactions</span>
              </a>
            </li>
            <li class="sidebar-item <?= ($nav == 'user') ? 'active' : '' ?>">
              <a class="sidebar-link" href="<?= base_url('/admin/user'); ?>">
                <i class="align-middle" data-feather="users"></i>
                <span class="align-middle">User Managment</span>
              </a>
            </li>
          <?php endif; ?>

          <li class="sidebar-header">
            User
          </li>
          <li class="sidebar-item <?= ($nav == 'profile') ? 'active' : '' ?>">
            <a class="sidebar-link" href="<?= base_url('/profile'); ?>">
              <i class="align-middle" data-feather="user"></i>
              <span class="align-middle">Profil</span>
            </a>
          </li>
          <li class="sidebar-item <?= ($nav == 'user_transaction') ? 'active' : '' ?>">
            <a class="sidebar-link" href="<?= base_url('/profile/transaction'); ?>">
              <i class="align-middle" data-feather="maximize-2"></i>
              <span class="align-middle">My Transaction</span>
            </a>
          </li>
          <li class="sidebar-item <?= ($nav == 'settings') ? 'active' : '' ?>">
            <a class="sidebar-link" href="<?= base_url('/profile/settings'); ?>">
              <i class="align-middle" data-feather="settings"></i>
              <span class="align-middle">Settings</span>
            </a>
          </li>

        </ul>
      </div>
    </nav>

    <div class="main">
      <nav class="navbar navbar-expand navbar-light navbar-bg d-print-none">
        <a class="sidebar-toggle d-flex">
          <i class="hamburger align-self-center"></i>
        </a>

        <div class="navbar-collapse collapse">
          <ul class="navbar-nav navbar-align">
            <li class="nav-item dropdown">
              <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-toggle="dropdown">
                <i class="align-middle" data-feather="settings"></i>
              </a>

              <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-toggle="dropdown">
                <span class="text-dark">Welcome Back, <?= user()->firstname; ?></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="<?= base_url('/profile'); ?>">
                  <i class="align-middle mr-1" data-feather="user"></i> Profile
                </a>
                <a class="dropdown-item" href="<?= base_url('/profile/settings'); ?>">
                  <i class="align-middle mr-1" data-feather="settings"></i> Settings
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?= base_url(); ?>">Kembali ke Website</a>
                <button class="dropdown-item" type="button" data-toggle="modal" data-target="#logoutModal">
                  Log out
                </button>
              </div>
            </li>
          </ul>
        </div>
      </nav>

      <!-- Modal -->
      <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">LOGOUT</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body m-3">
              <p class="mb-0 text-center h2">
                Are you sure ?
              </p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">
                Cancel
              </button>
              <a type="button" class="btn btn-danger" href="<?= base_url('/logout') ?>">
                Logout
              </a>
            </div>
          </div>
        </div>
      </div>

      <main class="content">
        <?= $this->renderSection('content'); ?>
      </main>

      <footer class="footer d-print-none">
        <div class="container-fluid">
          <div class="row text-muted">
            <div class="col-6 text-left">
              <p class="mb-0"><strong>Sok Kabeh</strong>
                &copy;
              </p>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>

  <script src="<?= base_url('/admin-asset/js/app.js') ?>"></script>
  <script src="<?= base_url('/admin-asset/js/imagePreview.js') ?>"></script>

</body>

</html>