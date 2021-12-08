<?= $this->extend('layouts/adminTemplate'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid p-0">

  <h1 class="h3 mb-3"><?= $title; ?></h1>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">

          <form action="<?= base_url('/admin/category/save'); ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field(); ?>

            <div class="form-group row mb-3">
              <label for="name" class="col-form-label col-sm-3">
                <?= lang('Admin.name'); ?>
              </label>
              <div class="col-sm-9">
                <input type="text" class="form-control <?= ($validation->hasError('name')) ? 'is-invalid' : ''; ?>" id="name" name="name" value="<?= old('name'); ?>">
                <div class="invalid-feedback">
                  <?= $validation->getError('name'); ?>
                </div>
              </div>
            </div>

            <div class="form-group row mb-3">
              <div class="d-none img-container justify-content-end">
                <img height="120" width="120" class="img-preview mb-2 border border-dark" style="object-fit: cover;">
              </div>

              <label for="image" class="col-form-label col-sm-3">
                <?= lang('Admin.image'); ?>
              </label>
              <div class="col-sm-9">
                <input onchange="previewImg();" name="image" class="img-input form-control <?= ($validation->hasError('image')) ? 'is-invalid' : ''; ?>" type="file">
                <div class="invalid-feedback">
                  <?= $validation->getError('image'); ?>
                </div>
              </div>
            </div>

            <div class="form-group row mt-4 justify-content-end">
              <div class="col-sm-2">
                <button type="submit" class="btn btn-primary">
                  <?= lang('Admin.add'); ?>
                </button>
                <a class="btn btn-warning" href="<?= base_url('/admin/category'); ?>">
                  <?= lang('Admin.cancel'); ?>
                </a>
              </div>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>