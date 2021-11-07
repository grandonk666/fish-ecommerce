<?= $this->extend('layouts/adminTemplate'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid p-0">
  <h1 class="h3 mb-3"><?= $title; ?></h1>

  <div class="row">
    <div class="col-lg-8">
      <div class="card mb-3">
        <div class="row">
          <div class="card-body px-5">
            <p class="h1 mb-3"><?= $user->name ?></p>
            <div class="d-flex justify-content-between">
              <p class="h3">Username</p>
              <p class="h3 text-muted"><?= $user->username ?></p>
            </div>
            <div class="d-flex justify-content-between">
              <p class="h3">Email</p>
              <p class="h3 text-muted"><?= $user->email ?></p>
            </div>
            <div class="d-flex justify-content-between">
              <p class="h3">Phone Number</p>
              <p class="h3 text-muted"><?= $user->phone ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?= $this->endSection(); ?>