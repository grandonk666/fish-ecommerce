<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('/icons/apple-touch-icon.png') ?>">
  <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('/icons/favicon-32x32.png') ?>">
  <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('/icons/favicon-16x16.png') ?>">
  <link rel="manifest" href="<?= base_url('/icons/site.webmanifest') ?>">
  <link rel="mask-icon" href="<?= base_url('/icons/safari-pinned-tab.svg') ?>" color="#5bbad5">
  <link rel="shortcut icon" href="<?= base_url('/icons/favicon.ico') ?>">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-config" content="<?= base_url('/icons/browserconfig.xml') ?>">
  <meta name="theme-color" content="#ffffff">

  <meta name="apple-mobile-web-app-title" content="FISHOP">
  <meta name="application-name" content="FISHOP">
  <meta name="keywords" content="food, fish, seafood">
  <meta property="og:title" content="FISHOP | Fresh Fish And Seafoods">
  <meta name="twitter:title" content="FISHOP | Fresh Fish And Seafoods">
  <meta name="description" content="FISHOP is a place to get fresh and high quality fish">
  <meta property="og:description" content="FISHOP is a place to get fresh and high quality fish">
  <meta name="twitter:description" content="FISHOP is a place to get fresh and high quality fish">
  <meta name="image" content="<?= base_url('/images/bg_1.jpg') ?>">
  <meta property="og:image" content="<?= base_url('/images/bg_1.jpg') ?>">
  <meta name="twitter:image" content="<?= base_url('/images/bg_1.jpg') ?>">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:site" content="@site">
  <meta name="twitter:creator" content="@handle">
  <meta property="og:url" content="">
  <meta property="og:site_name" content="FISHOP">

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
          <span class="text-white">FISHOP</span>
        </a>

        <ul class="sidebar-nav">

          <?php if (in_groups('admin')) : ?>
            <li class="sidebar-header">
              <?= lang('Admin.nav.admin'); ?>
            </li>
            <li class="sidebar-item <?= ($nav == 'product') ? 'active' : '' ?>">
              <a class="sidebar-link" href="<?= base_url('/admin/product'); ?>">
                <i class="align-middle" data-feather="database"></i>
                <span class="align-middle"><?= lang('Admin.nav.products'); ?></span>
              </a>
            </li>
            <li class="sidebar-item <?= ($nav == 'category') ? 'active' : '' ?>">
              <a class="sidebar-link" href="<?= base_url('/admin/category'); ?>">
                <i class="align-middle" data-feather="layers"></i>
                <span class="align-middle"><?= lang('Admin.nav.categories'); ?></span>
              </a>
            </li>
            <li class="sidebar-item <?= ($nav == 'admin_transaction' || $nav == 'admin_international') ? 'active' : '' ?>">
              <a data-target="#admin_transaction" data-toggle="collapse" class="sidebar-link collapsed">
                <i class="align-middle" data-feather="dollar-sign"></i>
                <span class="align-middle"><?= lang('Admin.nav.transactions'); ?></span>
              </a>
              <ul id="admin_transaction" class="sidebar-dropdown list-unstyled collapse <?= ($nav == 'admin_transaction' || $nav == 'admin_international') ? 'show' : '' ?>" data-parent="#sidebar">
                <li class="sidebar-item <?= ($nav == 'admin_transaction') ? 'active' : '' ?>">
                  <a class="sidebar-link" href="<?= base_url('/admin/transaction'); ?>"><?= lang('Admin.nav.domestic'); ?></a>
                </li>
                <li class="sidebar-item <?= ($nav == 'admin_international') ? 'active' : '' ?>">
                  <a class="sidebar-link" href="<?= base_url('/admin/international'); ?>"><?= lang('Admin.nav.international'); ?></a>
                </li>
              </ul>
            </li>
            <li class="sidebar-item <?= ($nav == 'user') ? 'active' : '' ?>">
              <a class="sidebar-link" href="<?= base_url('/admin/user'); ?>">
                <i class="align-middle" data-feather="users"></i>
                <span class="align-middle"><?= lang('Admin.nav.userManage'); ?></span>
              </a>
            </li>
          <?php endif; ?>

          <li class="sidebar-header">
            <?= lang('Admin.nav.user'); ?>
          </li>
          <li class="sidebar-item <?= ($nav == 'profile') ? 'active' : '' ?>">
            <a class="sidebar-link" href="<?= base_url('/profile'); ?>">
              <i class="align-middle" data-feather="user"></i>
              <span class="align-middle"><?= lang('Admin.nav.profile'); ?></span>
            </a>
          </li>
          <li class="sidebar-item <?= ($nav == 'user_transaction' || $nav == 'user_international') ? 'active' : '' ?>">
            <a data-target="#user_transaction" data-toggle="collapse" class="sidebar-link collapsed">
              <i class="align-middle" data-feather="maximize-2"></i>
              <span class="align-middle"><?= lang('Admin.nav.myTransactions'); ?></span>
            </a>
            <ul id="user_transaction" class="sidebar-dropdown list-unstyled collapse <?= ($nav == 'user_transaction' || $nav == 'user_international') ? 'show' : '' ?>" data-parent="#sidebar">
              <li class="sidebar-item <?= ($nav == 'user_transaction') ? 'active' : '' ?>">
                <a class="sidebar-link" href="<?= base_url('/profile/transaction'); ?>"><?= lang('Admin.nav.domestic'); ?></a>
              </li>
              <li class="sidebar-item <?= ($nav == 'user_international') ? 'active' : '' ?>">
                <a class="sidebar-link" href="<?= base_url('/profile/international'); ?>"><?= lang('Admin.nav.international'); ?></a>
              </li>
            </ul>
          </li>
          <li class="sidebar-item <?= ($nav == 'settings') ? 'active' : '' ?>">
            <a class="sidebar-link" href="<?= base_url('/profile/settings'); ?>">
              <i class="align-middle" data-feather="settings"></i>
              <span class="align-middle"><?= lang('Admin.nav.settings'); ?></span>
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

        <div class="btn-group ml-3">
          <a href="<?= base_url('lang/id') ?>" class="<?= session()->get('lang') == 'id' ? 'active' : '' ?> btn btn-outline-secondary">ID</a>
          <a href="<?= base_url('lang/en') ?>" class="<?= session()->get('lang') == 'en' ? 'active' : '' ?> btn btn-outline-secondary">EN</a>
        </div>

        <div class="navbar-collapse collapse">
          <ul class="navbar-nav navbar-align">
            <li class="nav-item dropdown">
              <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-toggle="dropdown">
                <i class="align-middle" data-feather="settings"></i>
              </a>

              <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-toggle="dropdown">
                <span class="text-dark"><?= lang('Admin.welcome'); ?>, <?= user()->username; ?></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="<?= base_url('/profile'); ?>">
                  <i class="align-middle mr-1" data-feather="user"></i> <?= lang('Admin.nav.profile'); ?>
                </a>
                <a class="dropdown-item" href="<?= base_url('/profile/settings'); ?>">
                  <i class="align-middle mr-1" data-feather="settings"></i> <?= lang('Admin.nav.settings'); ?>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?= base_url(); ?>"><?= lang('Admin.nav.backWebsite'); ?></a>
                <button class="dropdown-item" type="button" data-toggle="modal" data-target="#logoutModal">
                  <?= lang('Admin.nav.logout'); ?>
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
              <h5 class="modal-title"><?= lang('Admin.logout'); ?></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body m-3">
              <p class="mb-0 text-center h2">
                <?= lang('Admin.areYouSure'); ?>
              </p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">
                <?= lang('Admin.cancel'); ?>
              </button>
              <a type="button" class="btn btn-danger" href="<?= base_url('/logout') ?>">
                <?= lang('Admin.logout'); ?>
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
              <p class="mb-0"><strong>FISHOP</strong>
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