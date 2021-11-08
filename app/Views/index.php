<?= $this->extend('layouts/userTemplate'); ?>

<?= $this->section('content'); ?>

<div class="hero-wrap hero-bread" style="background-image: url(<?= base_url('/images/bg_1.jpg') ?>);">
  <div class="container-fluid" style="background-color: rgba(0, 0, 0, 0.2); padding: 15em 0;">
    <div class="row no-gutters slider-text align-items-center justify-content-center">
      <div class="col-md-12 ftco-animate text-center">
        <h1 class="mb-2 text-light">100% Fresh Foods</h1>
        <h2 class="subheading mb-4 text-light">We deliver the best quality
          product</h2>
        <p><a href="3" class="btn btn-primary">
            Shop Now
          </a></p>
      </div>
    </div>
  </div>
</div>

<section class="ftco-section">
  <div class="container">
    <div class="row no-gutters ftco-services">
      <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
        <div class="media block-6 services mb-md-0 mb-4">
          <div class="icon bg-color-1 active d-flex justify-content-center align-items-center mb-2">
            <span class="flaticon-shipped"></span>
          </div>
          <div class="media-body">
            <h3 class="heading">Shipping</h3>
            <span>To Your Home</span>
          </div>
        </div>
      </div>
      <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
        <div class="media block-6 services mb-md-0 mb-4">
          <div class="icon bg-color-2 d-flex justify-content-center align-items-center mb-2">
            <span class="flaticon-diet"></span>
          </div>
          <div class="media-body">
            <h3 class="heading">Always Fresh</h3>
            <span>Product Well Package</span>
          </div>
        </div>
      </div>
      <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
        <div class="media block-6 services mb-md-0 mb-4">
          <div class="icon bg-color-3 d-flex justify-content-center align-items-center mb-2">
            <span class="flaticon-award"></span>
          </div>
          <div class="media-body">
            <h3 class="heading">Superior Quality</h3>
            <span>Quality Products</span>
          </div>
        </div>
      </div>
      <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
        <div class="media block-6 services mb-md-0 mb-4">
          <div class="icon bg-color-4 d-flex justify-content-center align-items-center mb-2">
            <span class="flaticon-customer-service"></span>
          </div>
          <div class="media-body">
            <h3 class="heading">Support</h3>
            <span>24/7 Support</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="ftco-section">
  <div class="container">
    <div class="row">
      <div class="col-md-5 p-md-5 img img-2 d-flex justify-content-center align-items-center" style="background-image: url(<?= base_url('/images/domestic-purchase.jpg') ?>);">
      </div>
      <div class="col-md-7 py-3 wrap-about pb-md-5 ftco-animate">
        <div class="heading-section-bold mb-4 mt-md-5">
          <div class="ml-md-0">
            <h2 class="mb-4">Domestic
            </h2>
          </div>
        </div>
        <div class="pb-md-5">
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus
            accusamus provident, perspiciatis facere hic accusantium!</p>
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex aliquid
            dolorum voluptatibus, expedita omnis numquam animi quae totam
            pariatur fugit!</p>
          <p><a href="<?= base_url('/product') ?>" class="btn btn-primary">Shop now</a></p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="ftco-section">
  <div class="container">
    <div class="row">
      <div class="col-md-7 py-3 wrap-about pb-md-5 ftco-animate">
        <div class="heading-section-bold mb-4 mt-md-5">
          <div class="ml-md-0">
            <h2 class="mb-4">International
            </h2>
          </div>
        </div>
        <div class="pb-md-5">
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus
            accusamus provident, perspiciatis facere hic accusantium!</p>
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex aliquid
            dolorum voluptatibus, expedita omnis numquam animi quae totam
            pariatur fugit!</p>
          <p><a href="<?= base_url('/international') ?>" class="btn btn-primary">Shop now</a></p>
        </div>
      </div>
      <div class="col-md-5 p-md-5 img img-2 d-flex justify-content-center align-items-center" style="background-image: url(<?= base_url('/images/international-purchase.jpg') ?>);">
      </div>
    </div>
  </div>
</section>

<?= $this->endSection(); ?>