<!DOCTYPE html>
<html lang="en">

<head>
  <title>Sok Kabeh</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Amatic+SC:400,700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="<?= base_url('/home-asset/css/open-iconic-bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('/home-asset/css/animate.css') ?>">

  <link rel="stylesheet" href="<?= base_url('/home-asset/css/owl.carousel.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('/home-asset/css/owl.theme.default.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('/home-asset/css/magnific-popup.css') ?>">

  <link rel="stylesheet" href="<?= base_url('/home-asset/css/aos.css') ?>">

  <link rel="stylesheet" href="<?= base_url('/home-asset/css/ionicons.min.css') ?>">

  <link rel="stylesheet" href="<?= base_url('/home-asset/css/bootstrap-datepicker.css') ?>">
  <link rel="stylesheet" href="<?= base_url('/home-asset/css/jquery.timepicker.css') ?>">


  <link rel="stylesheet" href="<?= base_url('/home-asset/css/flaticon.css') ?>">
  <link rel="stylesheet" href="<?= base_url('/home-asset/css/icomoon.css') ?>">
  <link rel="stylesheet" href="<?= base_url('/home-asset/css/style.css') ?>">
  <style>
    .link-disabled {
      pointer-events: none;
    }

    .separator {
      display: flex;
      align-items: center;
      text-align: center;
    }

    .separator::before,
    .separator::after {
      content: '';
      flex: 1;
      border-bottom: 1px solid rgba(0, 0, 0, 0.3);
    }

    .separator::before {
      margin-right: .25em;
    }

    .separator::after {
      margin-left: .25em;
    }
  </style>


</head>

<body class="goto-here">
  <div class="py-1 bg-primary">
    <div class="container">
      <div class="row no-gutters d-flex align-items-start align-items-center px-md-0">
        <div class="col-lg-12 d-block">
          <div class="row d-flex">
            <div class="col-md pr-4 d-flex topper align-items-center">
              <div class="icon mr-2 d-flex justify-content-center align-items-center">
                <span class="icon-phone2"></span>
              </div>
              <span class="text">+62 812-9163-4919</span>
            </div>
            <div class="col-md pr-4 d-flex topper align-items-center">
              <div class="icon mr-2 d-flex justify-content-center align-items-center">
                <span class="icon-paper-plane"></span>
              </div>
              <span class="text">trikurniawan02091998@gmail.com</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
      <a class="navbar-brand" href="<?= base_url() ?>">Sok Kabeh</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> Menu
      </button>

      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a href="<?= base_url() ?>" class="nav-link">Home</a>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Shop</a>
            <div class="dropdown-menu" aria-labelledby="dropdown04">
              <a class="dropdown-item" href="<?= base_url('/product') ?>">
                Domestic (IDN)
              </a>
              <a class="dropdown-item" href="#">
                International
              </a>
            </div>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('/about') ?>" class="nav-link">About</a>
          </li>

          <?php if (logged_in()) : ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= user()->firstname ?></a>
              <div class="dropdown-menu" aria-labelledby="dropdown04">
                <a class="dropdown-item" href="<?= base_url('/admin/profile/transaction') ?>">Order
                  Transaction</a>
                <a class="dropdown-item" href="<?= base_url('/admin/profile') ?>">Profile</a>
                <form action="<?= base_url('/logout') ?>" method="post">
                  <?= csrf_field(); ?>
                  <button type="submit" class="dropdown-item" style="cursor: pointer">
                    Logout
                  </button>
                </form>
              </div>
            </li>
          <?php else : ?>
            <li class="nav-item"><a href="<?= base_url('/login') ?>" class="nav-link">Login</a></li>
          <?php endif; ?>

          <li class="nav-item cta cta-colored">
            <a href="#" class="nav-link">
              <span class="icon-shopping_cart"></span>
              <span id="cart-count">
                [0]
              </span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <?= $this->renderSection('content'); ?>

  <section class="ftco-section ftco-no-pt ftco-no-pb py-5 bg-light">
    <div class="container py-4">
      <div class="row d-flex justify-content-center py-5">
        <div class="col-md-6">
          <h2 style="font-size: 22px;" class="mb-0">Start Today</h2>
          <span>Get the best quality product</span>
        </div>
        <div class="col-md-6 d-flex align-items-center justify-content-center">
          <a href="<?= base_url('/register') ?>" class="btn btn-primary btn-lg">Register Now</a>
        </div>
      </div>
    </div>
  </section>
  <footer class="ftco-footer ftco-section">
    <div class="container">
      <div class="row">
        <div class="mouse">
          <a href="#" class="mouse-icon">
            <div class="mouse-wheel"><span class="ion-ios-arrow-up"></span>
            </div>
          </a>
        </div>
      </div>
      <div class="row mb-4">
        <div class="col-md">
          <div class="ftco-footer-widget">
            <h2 class="ftco-heading-2">SOK KABEH</h2>
            <p>Perfect solution for your cooking session</p>
            <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
              <li class="ftco-animate"><a href="#"><span class="icon-whatsapp"></span></a></li>
              <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
            </ul>
          </div>
        </div>
        <div class="col-md">
          <div class="ftco-footer-widget text-right">
            <h2 class="ftco-heading-2">Menu</h2>
            <ul class="list-unstyled">
              <li><a href="<?= base_url('/product') ?>" class="py-2 d-block">Shop</a>
              </li>
              <li><a href="<?= base_url('/about') ?>" class="py-2 d-block">About</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="ftco-footer-widget py-3 border-top">
            <p class="mb-0 text-muted text-center">
              &copy; Sok Kabeh 2021
            </p>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
      <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
      <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" />
    </svg></div>


  <script src="<?= base_url('/home-asset/js/jquery.min.js') ?>"></script>
  <script src="<?= base_url('/home-asset/js/jquery-migrate-3.0.1.min.js') ?>"></script>
  <script src="<?= base_url('/home-asset/js/popper.min.js') ?>"></script>
  <script src="<?= base_url('/home-asset/js/bootstrap.min.js') ?>"></script>
  <script src="<?= base_url('/home-asset/js/jquery.easing.1.3.js') ?>"></script>
  <script src="<?= base_url('/home-asset/js/jquery.waypoints.min.js') ?>"></script>
  <script src="<?= base_url('/home-asset/js/jquery.stellar.min.js') ?>"></script>
  <script src="<?= base_url('/home-asset/js/owl.carousel.min.js') ?>"></script>
  <script src="<?= base_url('/home-asset/js/jquery.magnific-popup.min.js') ?>"></script>
  <script src="<?= base_url('/home-asset/js/aos.js') ?>"></script>
  <script src="<?= base_url('/home-asset/js/jquery.animateNumber.min.js') ?>"></script>
  <script src="<?= base_url('/home-asset/js/bootstrap-datepicker.js') ?>"></script>
  <script src="<?= base_url('/home-asset/js/scrollax.min.js') ?>"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false">
  </script>
  <script src="<?= base_url('/home-asset/js/google-map.js') ?>"></script>
  <script src="<?= base_url('/home-asset/js/main.js') ?>"></script>

  <script>
    var refresh_count = () => {
      $.ajax({
        url: "<?php echo base_url('/cart/get_sum') ?>",
        type: "POST",
      }).done(function(data) {
        $('#cart-count').html("[" + data + "]")
      });
    }
    refresh_count();
  </script>

  <?= $this->renderSection('script'); ?>

</body>

</html>