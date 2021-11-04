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
          <form action="<?= base_url('/profil/update'); ?>" method="post" enctype="multipart/form-data">
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
              <div class="col-md-4">
                <div class="text-center">
                  <img alt="<?= $user->name ?>" src="<?= base_url('/images/' . $user->user_image) ?>" style="object-fit: cover;" class="rounded-circle img-responsive mb-3 img-preview" width="200" height="200" />

                  <input type="file" class="custom-file-input d-block <?= ($validation->hasError('user_image')) ? 'is-invalid' : ''; ?>" id="user_image" name="user_image" onchange="previewImg();">

                  <div class="invalid-feedback">
                    <?= $validation->getError('user_image'); ?>
                  </div>
                  <small>For best results, use an image at least 128px by 128px in .jpg format</small>
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

<script defer>
  function previewImg() {
    const sampul = document.querySelector("#user_image");
    const imgPreview = document.querySelector(".img-preview");

    const fileSampul = new FileReader();
    fileSampul.readAsDataURL(sampul.files[0]);

    fileSampul.onload = function(e) {
      imgPreview.src = e.target.result;
    };
  }
</script>

<?= $this->endSection(); ?>