<?= $this->extend('layouts/adminTemplate'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid p-0">
  <h1 class="h3 mb-3"><?= $title; ?></h1>

  <div class="row">
    <div class="col-xxl-8">
      <div class="card">
        <div class="card-header">

          <h5 class="card-title mb-0">User info</h5>
        </div>
        <div class="card-body">
          <form action="<?= base_url('/profile/update'); ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field(); ?>

            <div class="row">
              <div class="col-md-8">
                <div class="row">
                  <div class="mb-3 col-md-6">
                    <label class="form-label" for="firstname">First name</label>
                    <input type="text" class="form-control <?= ($validation->hasError('firstname')) ? 'is-invalid' : ''; ?>" id="firstname" name="firstname" placeholder="First name" value="<?= old('firstname') ?? $user->firstname ?>">
                    <div class="invalid-feedback">
                      <?= $validation->getError('firstname'); ?>
                    </div>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label class="form-label" for="lastname">Last name</label>
                    <input type="text" class="form-control <?= ($validation->hasError('lastname')) ? 'is-invalid' : ''; ?>" id="lastname" name="lastname" placeholder="Last name" value="<?= old('lastname') ?? $user->lastname ?>">
                    <div class="invalid-feedback">
                      <?= $validation->getError('lastname'); ?>
                    </div>
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="username">Username</label>
                  <input type="text" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>" id="username" name="username" placeholder="Username" value="<?= old('username') ?? $user->username ?>">
                  <div class="invalid-feedback">
                    <?= $validation->getError('username'); ?>
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="phone">Phone</label>
                  <input type="phone" class="form-control <?= ($validation->hasError('phone')) ? 'is-invalid' : ''; ?>" id="phone" name="phone" placeholder="Phone" value="<?= old('phone') ?? $user->phone ?>">
                  <div class="invalid-feedback">
                    <?= $validation->getError('phone'); ?>
                  </div>
                </div>

              </div>
            </div>

            <button type="submit" class="btn btn-primary">Save changes</button>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>