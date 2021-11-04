<?= $this->extend('layouts/userTemplate'); ?>

<?= $this->section('content'); ?>

<div class="hero-wrap hero-bread" style="background-image: url(<?= base_url('/images/bg_2.jpg') ?>);">
  <div class="container-fluid" style="background-color: rgba(0, 0, 0, 0.2); padding: 15em 0;">
    <div class="row no-gutters slider-text align-items-center justify-content-center">
      <div class="col-md-10 ftco-animate text-center">
        <p class="breadcrumbs"><span class="mr-2"><a href="<?= base_url() ?>">Home</a></span> <span>About</span>
        </p>
        <h1 class="mb-0 display-3 text-light">About</h1>
      </div>
    </div>
  </div>
</div>

<section class="ftco-section">
  <div class="container">
    <div class="row">
      <div class="col-md-5 p-md-5 img img-2 d-flex justify-content-center align-items-center" style="background-image: url(<?= base_url('/images/about.jpg') ?>);">
      </div>
      <div class="col-md-7 py-3 wrap-about pb-md-5 ftco-animate">
        <div class="heading-section-bold mb-4 mt-md-5">
          <div class="ml-md-0">
            <h2 class="mb-4">Welcome to Sok Kabeh
            </h2>
          </div>
        </div>
        <div class="pb-md-5">
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus
            accusamus provident, perspiciatis facere hic accusantium!</p>
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex aliquid
            dolorum voluptatibus, expedita omnis numquam animi quae totam
            pariatur fugit!</p>
          <p><a href="#" class="btn btn-primary">Shop now</a></p>
        </div>
      </div>
    </div>
  </div>
</section>

<?= $this->endSection(); ?>