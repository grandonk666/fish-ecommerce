<?= $this->extend('layouts/userTemplate'); ?>

<?= $this->section('content'); ?>

<div class="hero-wrap hero-bread" style="background-image: url(<?= base_url('/images/bg_2.jpg') ?>);">
  <div class="container-fluid" style="background-color: rgba(0, 0, 0, 0.2); padding: 15em 0;">
    <div class="row no-gutters slider-text align-items-center justify-content-center">
      <div class="col-md-10 ftco-animate text-center">
        <p class="breadcrumbs"><span class="mr-2"><a href="<?= base_url() ?>"><?= lang('Home.nav.home'); ?></a></span> <span><?= lang('Home.nav.order'); ?></span>
        </p>
        <h1 class="mb-0 display-3 text-light"><?= lang('Home.nav.order'); ?></h1>
      </div>
    </div>
  </div>
</div>

<section class="ftco-section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-xl-10 ftco-animate">
        <h3 class="mb-4 billing-heading"><?= lang('Home.orderInfo'); ?></h3>

        <form action="<?= base_url('/international/save/' . $product['slug']) ?>" method="post">
          <?= csrf_field(); ?>
          <input type="hidden" name="product_id" value="<?= $product['id']; ?>">

          <div class="row align-items-end">
            <div class="col-md-12">
              <div class="form-group">
                <label for="product"><?= lang('Home.product'); ?></label>
                <input type="text" name="product" required class="form-control <?= ($validation->hasError('product_id')) ? 'is-invalid' : ''; ?>" style="color:black !important" id="product" value="<?= $product['name'] ?>" readonly>
                <div class="invalid-feedback">
                  <?= $validation->getError('product_id'); ?>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="company_name"><?= lang('Home.companyName'); ?></label>
                <input type="text" name="company_name" required class="form-control <?= ($validation->hasError('company_name')) ? 'is-invalid' : ''; ?>" style="color:black !important" id="company_name" value="<?= old('company_name') ?>">
                <div class="invalid-feedback">
                  <?= $validation->getError('company_name'); ?>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="address"><?= lang('Home.detailShippingAddress'); ?></label>
                <textarea name="address" id="address" required rows="5" class="form-control <?= ($validation->hasError('address')) ? 'is-invalid' : ''; ?>" style="color:black !important"><?= old('address') ?></textarea>
                <div class="invalid-feedback">
                  <?= $validation->getError('address'); ?>
                </div>
              </div>
            </div>
          </div>
          <div class="justify-content-center row px-3">
            <button type="submit" class="d-inline-block btn btn-primary py-3 px-4 mt-4" style="width:30% !important;"><?= lang('Home.placeOrder'); ?></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<?= $this->endSection(); ?>