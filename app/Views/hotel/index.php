<?= $this->extend('layouts/userTemplate'); ?>

<?= $this->section('content'); ?>

<!-- ======= Intro Section ======= -->
<div class="intro intro-carousel swiper-container position-relative">
  <div class="swiper-wrapper">
    <?php foreach ($kamar as $k) : ?>
      <div class="swiper-slide carousel-item-a intro-item bg-image" style="background-image: url(<?= base_url('/images/' . $k['foto']) ?>)">
        <div class="overlay overlay-a"></div>
        <div class="intro-content display-table">
          <div class="table-cell">
            <div class="container">
              <div class="row">
                <div class="col-lg-8">
                  <div class="intro-body">
                    <h1 class="intro-title mb-4">
                      <span class="color-b">Luxurious</span> Rooms <br />
                      & Good View
                    </h1>
                    <p class="intro-subtitle">Start from | IDR 200.000</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="swiper-pagination"></div>
</div>
<!-- End Intro Section -->

<main id="main">
  <!-- ======= Services Section ======= -->
  <section class="section-services section-t8">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="title-wrap d-flex justify-content-between">
            <div class="title-box">
              <h2 class="title-a">Our Services</h2>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="card-box-c foo">
            <div class="card-header-c d-flex">
              <div class="card-box-ico">
                <span class="bi bi-wifi"></span>
              </div>
            </div>
            <div class="card-body-c">
              <p class="content-c">
                Sed porttitor lectus nibh. Cras ultricies ligula sed magna
                dictum porta. Praesent sapien massa, convallis a
                pellentesque nec, egestas non nisi.
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card-box-c foo">
            <div class="card-header-c d-flex">
              <div class="card-box-ico">
                <span class="bi bi-calendar4-week"></span>
              </div>
            </div>
            <div class="card-body-c">
              <p class="content-c">
                Nulla porttitor accumsan tincidunt. Curabitur aliquet quam
                id dui posuere blandit. Mauris blandit aliquet elit, eget
                tincidunt nibh pulvinar a.
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card-box-c foo">
            <div class="card-header-c d-flex">
              <div class="card-box-ico">
                <span class="bi bi-card-checklist"></span>
              </div>
            </div>
            <div class="card-body-c">
              <p class="content-c">
                Sed porttitor lectus nibh. Cras ultricies ligula sed magna
                dictum porta. Praesent sapien massa, convallis a
                pellentesque nec, egestas non nisi.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Services Section -->

  <!-- ======= Latest Properties Section ======= -->
  <section class="section-property section-t8">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="title-wrap d-flex justify-content-between">
            <div class="title-box">
              <h2 class="title-a">Featured Rooms</h2>
            </div>
            <div class="title-link">
              <a href="<?= base_url('/rooms') ?>">All Rooms
                <span class="bi bi-chevron-right"></span>
              </a>
            </div>
          </div>
        </div>
      </div>

      <div id="property-carousel" class="swiper-container">
        <div class="swiper-wrapper">

          <?php foreach ($kamar as $k) : ?>
            <div class="carousel-item-b swiper-slide">
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
          <!-- End carousel item -->
        </div>
      </div>
      <div class="propery-carousel-pagination carousel-pagination"></div>
    </div>
  </section>
  <!-- End Latest Properties Section -->
</main>
<!-- End #main -->


<?= $this->endSection(); ?>