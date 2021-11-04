<?= $this->extend('layouts/userTemplate'); ?>

<?= $this->section('content'); ?>

<main id="main">

  <?php if (empty($kamar)) : ?>
    <section class="intro-single">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1 class="intro-title my-5">No Macth Rooms</h1>
            <div class="title-link">
              <a href="<?= base_url('/rooms') ?>">
                <span class="bi bi-chevron-left"></span>
                Back to All Rooms
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
  <?php else : ?>

    <!-- ======= Intro Single ======= -->
    <section class="intro-single">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-lg-8">
            <div class="title-single-box">
              <h1 class="title-single"><?= $kamar['nama']; ?></h1>
              <span class="color-text-a"><?= $kamar['tipe']; ?></span>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Intro Single-->

    <!-- ======= Property Single ======= -->
    <section class="property-single nav-arrow-b">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-11">
            <div id="property-single-carousel" class="swiper-container">
              <div class="swiper-wrapper">
                <div class="carousel-item-b swiper-slide">
                  <img class="img-fluid" src="<?= base_url('/images/' . $kamar['foto']) ?>" alt="" />
                </div>
                <?php foreach ($gallery as $img) : ?>
                  <div class="carousel-item-b swiper-slide">
                    <img class="img-fluid" src="<?= base_url('/images/' . $img) ?>" alt="" />
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
            <div class="property-single-carousel-pagination carousel-pagination"></div>
          </div>
        </div>

        <div class="row mt-5">
          <div class="col-sm-12">
            <div class="row justify-content-between">
              <div class="col-md-5 col-lg-4">
                <div class="property-price d-flex justify-content-center foo">
                  <div class="card-header-c d-flex">
                    <div class="card-box-ico">
                      <span class="bi bi-cash"></span>
                    </div>
                    <div class="card-title-c align-self-center">
                      <h5 class="title-c">IDR <?= number_format($kamar['harga'], '0', '', '.'); ?></h5>
                    </div>
                  </div>
                </div>
                <div class="order">
                  <a class="btn btn-b align-self-end" href="<?= base_url('/order/' . $kamar['slug']) ?>">
                    <h3 class="color-text-b">ORDER NOW</h3>
                  </a>
                </div>
                <div class="property-summary">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="title-box-d section-t4">
                        <h3 class="title-d">Detail</h3>
                      </div>
                    </div>
                  </div>
                  <div class="summary-list">
                    <ul class="list">
                      <li class="d-flex justify-content-between">
                        <strong>Type</strong>
                        <span><?= $kamar['tipe']; ?></span>
                      </li>
                      <li class="d-flex justify-content-between">
                        <strong>Size</strong>
                        <span><?= $kamar['luas']; ?> m<sup>2</sup></span>
                      </li>
                      <li class="d-flex justify-content-between">
                        <strong>Capacity</strong>
                        <span><?= $kamar['kapasitas']; ?> people</span>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-md-7 col-lg-7 section-md-t3">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="title-box-d">
                      <h3 class="title-d">Room Description</h3>
                    </div>
                  </div>
                </div>
                <div class="property-description">
                  <p class="description color-text-a">
                    <?= $kamar['deskripsi']; ?>
                  </p>
                </div>
                <div class="row section-t3">
                  <div class="col-sm-12">
                    <div class="title-box-d">
                      <h3 class="title-d">Extras</h3>
                    </div>
                  </div>
                </div>
                <div class="amenities-list color-text-a">
                  <ul class="list-a no-margin">
                    <?php if ($kamar['hewan']) : ?>
                      <li>Pets Allowed</li>
                    <?php endif; ?>
                    <?php if ($kamar['internet']) : ?>
                      <li>Internet</li>
                    <?php endif; ?>
                    <?php if ($kamar['sarapan']) : ?>
                      <li>Breakfast</li>
                    <?php endif; ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Property Single-->

  <?php endif; ?>
</main>
<!-- End #main -->

<?= $this->endSection(); ?>