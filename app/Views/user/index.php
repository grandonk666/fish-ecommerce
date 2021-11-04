<?= $this->extend('layouts/adminTemplate'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid p-0">
  <h1 class="h3 mb-3"><?= $title; ?></h1>

  <div class="row">
    <div class="col-lg-9">
      <div class="card mb-3">
        <div class="row">
          <div class="col-md-5">
            <div class="card-body text-center">
              <img src="<?= base_url('/images/' . $user->user_image) ?>" alt="<?= $user->name ?>" style="object-fit: cover;" class="rounded-circle mb-2" height="250" width="250">
              <h3 class="text-muted"><?= $user->username ?></h3>
            </div>
          </div>
          <div class="col-md-7">
            <div class="card-body">
              <p class="h1"><?= $user->name ?></p>
              <p class="h3 text-muted"><?= $user->email ?></p>
              <p class="h3 text-muted"><?= $user->phone ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>