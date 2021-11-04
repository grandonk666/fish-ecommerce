<?= $this->extend('layouts/adminTemplate'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid p-0">

  <h1 class="h3 mb-3"><?= $title; ?></h1>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">

          <form action="<?= base_url('/admin/category/update/' . $category['id']); ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field(); ?>

            <div class="form-group row mb-3">
              <label for="name" class="col-form-label col-sm-3">Name</label>
              <div class="col-sm-9">
                <input type="text" class="form-control <?= ($validation->hasError('name')) ? 'is-invalid' : ''; ?>" id="name" name="name" value="<?= old('name', $category['name']); ?>">
                <div class="invalid-feedback">
                  <?= $validation->getError('name'); ?>
                </div>
              </div>
            </div>

            <div class="form-group row mb-3">
              <?php if ($category['image']) : ?>
                <div class="d-flex img-container justify-content-end">
                  <img src="<?= base_url('images/category-images/' . $category['image']) ?>" height="120" width="120" class="img-preview mb-2 border border-dark" style="object-fit: cover;">
                </div>
              <?php else : ?>
                <div class="d-none img-container justify-content-end">
                  <img height="120" width="120" class="img-preview mb-2 border border-dark" style="object-fit: cover;">
                </div>
              <?php endif; ?>

              <label for="image" class="col-form-label col-sm-3">Image</label>
              <div class="col-sm-9">
                <input onchange="previewImg();" name="image" class="img-input form-control <?= ($validation->hasError('image')) ? 'is-invalid' : ''; ?>" type="file">
                <div class="invalid-feedback">
                  <?= $validation->getError('image'); ?>
                </div>
              </div>
            </div>

            <div class="form-group row mt-4 justify-content-end">
              <div class="col-sm-2">
                <button type="submit" class="btn btn-primary">Update</button>
                <a class="btn btn-warning" href="<?= base_url('/admin/category'); ?>">Cancel</a>
              </div>
            </div>
          </form>

        </div>
      </div>

      <div class="row">
        <div class="col-md-3">
          <form action="<?= base_url('/admin/category/' . $category['id']) ?>" method="post">
            <?= csrf_field(); ?>
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="btn btn-danger mb-3 d-block"><i data-feather="trash" class="mr-1"></i>Delete Category</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>