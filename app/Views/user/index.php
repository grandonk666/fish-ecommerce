<?= $this->extend('layouts/adminTemplate'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid p-0">
  <h1 class="h3 mb-3"><?= $title; ?></h1>

  <div class="row">
    <div class="col-lg-8">

      <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <div class="alert-message">
            <?= session()->getFlashdata('success'); ?>
          </div>
        </div>
      <?php endif; ?>

      <div class="card mb-3">
        <div class="row">
          <div class="card-body px-5">
            <p class="h1 mb-3"><?= $user->name ?></p>
            <div class="d-flex justify-content-between">
              <p class="h3"><?= lang('Home.username'); ?></p>
              <p class="h3 text-muted"><?= $user->username ?></p>
            </div>
            <div class="d-flex justify-content-between">
              <p class="h3"><?= lang('Home.email'); ?></p>
              <p class="h3 text-muted"><?= $user->email ?></p>
            </div>
            <div class="d-flex justify-content-between">
              <p class="h3"><?= lang('Home.phone'); ?></p>
              <p class="h3 text-muted"><?= $user->phone ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?= $this->endSection(); ?>