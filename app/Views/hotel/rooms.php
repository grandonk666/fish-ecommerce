<?= $this->extend('layouts/userTemplate'); ?>

<?= $this->section('content'); ?>

<!-- ======= Property Search Section ======= -->
<div class="click-closed"></div>
<!--/ Form Search Star /-->
<div class="box-collapse">
  <div class="title-box-d">
    <h3 class="title-d">Search Rooms</h3>
  </div>
  <span class="close-box-collapse right-boxed bi bi-x"></span>
  <div class="box-collapse-wrap form">
    <form action="<?= base_url('/rooms') ?>" method="POST" class="form-a">
      <div class="row">
        <div class="col-md-6 mb-2">
          <div class="form-group mt-3">
            <label class="pb-2" for="tipe">Type</label>
            <select class="form-control form-select form-control-a" id="tipe" name="tipe">
              <option value="all" selected>All Type</option>
              <?php foreach ($daftarTipe as $tipe) : ?>
                <option value="<?= $tipe; ?>"><?= $tipe; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="col-md-6 mb-2">
          <div class="form-group mt-3">
            <label class="pb-2" for="luas">Min Size</label>
            <select class="form-control form-select form-control-a" id="luas" name="luas">
              <option value="<?= $luasTerendah; ?>">No Min</option>
              <option value="10">10 m<sup>2</sup></option>
              <option value="20">20 m<sup>2</sup></option>
              <option value="30">30 m<sup>2</sup></option>
              <option value="40">40 m<sup>2</sup></option>
            </select>
          </div>
        </div>
        <div class="col-md-6 mb-2">
          <div class="form-group mt-3">
            <label class="pb-2" for="kapasitas">Min Capacity</label>
            <select class="form-control form-select form-control-a" id="kapasitas" name="kapasitas">
              <option value="<?= $kapasitasTerendah; ?>">No Min</option>
              <option value="2">2 people</option>
              <option value="3">3 people</option>
              <option value="4">4 people</option>
              <option value="5">5 people</option>
            </select>
          </div>
        </div>
        <div class="col-md-6 mb-2">
          <div class="form-group mt-3">
            <label class="pb-2" for="harga">Max Price</label>
            <select class="form-control form-select form-control-a" id="harga" name="harga">
              <option value="<?= $hargaTertinggi; ?>">No Max</option>
              <option value="200000">IDR 200.000</option>
              <option value="500000">IDR 500.000</option>
              <option value="1000000">IDR 1000.000</option>
              <option value="2000000">IDR 2000.000</option>
            </select>
          </div>
        </div>
        <div class="col-md-4 mb-2">
          <div class="form-group mt-3">
            <input class="form-check-input" type="checkbox" value="1" name="hewan" id="hewan">
            <label class="form-check-label" for="hewan">Pets</label>
          </div>
        </div>
        <div class="col-md-4 mb-2">
          <div class="form-group mt-3">
            <input class="form-check-input" type="checkbox" value="1" name="sarapan" id="sarapan" checked>
            <label class="form-check-label" for="sarapan">Breakfast</label>
          </div>
        </div>
        <div class="col-md-4 mb-2">
          <div class="form-group mt-3">
            <input class="form-check-input" type="checkbox" value="1" name="internet" id="internet" checked>
            <label class="form-check-label" for="internet">Internet</label>
          </div>
        </div>
        <div class="col-md-12">
          <button type="submit" class="btn btn-b mt-3">Search Rooms</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- End Property Search Section -->

<main id="main">
  <!-- ======= Intro Single ======= -->
  <section class="intro-single">
    <div class="container">
      <div class="row">
        <div class="col-md-9">
          <div class="title-single-box">
            <h1 class="title-single">Our Luxurious Rooms</h1>
            <span class="color-text-a">Make your choice</span>
          </div>
        </div>
        <div class="col-md-3">
          <button type="button" class="btn btn-a toggle-box mt-3" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01">
            <i class="bi bi-search me-3"></i>Search Rooms
          </button>
        </div>
      </div>
    </div>
  </section>
  <!-- End Intro Single-->

  <!-- ======= Property Grid ======= -->
  <section class="property-grid grid">
    <div class="container">
      <div class="row">
        <?php if (!$kamar) : ?>
          <div class="col-md-12">
            <h1 class="intro-title my-5">No Macth Rooms</h1>
            <div class="title-link">
              <a href="<?= base_url('/rooms') ?>">
                <span class="bi bi-chevron-left"></span>
                Back to All Rooms
              </a>
            </div>
          </div>
        <?php else : ?>

          <?php foreach ($kamar as $k) : ?>
            <div class="col-md-6">
              <div class="card-box-a card-shadow">
                <div class="img-box-a">
                  <img src="<?= base_url('/images/' . $k['foto']) ?>" alt="" class="img-a img-fluid" />
                </div>
                <div class="card-overlay">
                  <div class="card-overlay-a-content">
                    <div class="card-header-a">
                      <h2 class="card-title-a">
                        <a href="<?= base_url('/rooms/' . $k['slug']) ?>"><?= $k['nama']; ?></a>
                      </h2>
                    </div>
                    <div class="card-body-a">
                      <div class="price-box d-flex">
                        <span class="price-a">IDR <?= number_format($k['harga'], '0', '', '.'); ?></span>
                      </div>
                      <a href="<?= base_url('/rooms/' . $k['slug']) ?>" class="link-a">Click here to view
                        <span class="bi bi-chevron-right"></span>
                      </a>
                    </div>
                    <div class="card-footer-a">
                      <ul class="card-info d-flex justify-content-around">
                        <li>
                          <h4 class="card-info-title">Tipe</h4>
                          <span>
                            <?= $k['tipe']; ?>
                          </span>
                        </li>
                        <li>
                          <h4 class="card-info-title">Luas</h4>
                          <span>
                            <?= $k['luas']; ?> m<sup>2</sup>
                          </span>
                        </li>
                        <li>
                          <h4 class="card-info-title">Kapasitas</h4>
                          <span><?= $k['kapasitas']; ?></span>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>

        <?php endif; ?>
      </div>
    </div>
  </section>
  <!-- End Property Grid Single-->
</main>
<!-- End #main -->

<?= $this->endSection(); ?>