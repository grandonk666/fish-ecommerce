<?= $this->extend('layouts/adminTemplate'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid p-0">

  <h1 class="h3 mb-3"><?= $title; ?></h1>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">

          <form action="<?= base_url('/admin/product/update/' . $product['id']); ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field(); ?>

            <div class="form-group row mb-3">
              <label for="name" class="col-form-label col-sm-3">
                <?= lang('Admin.name'); ?>
              </label>
              <div class="col-sm-9">
                <input type="text" class="form-control <?= ($validation->hasError('name')) ? 'is-invalid' : ''; ?>" id="name" name="name" value="<?= old('name', $product['name']); ?>">
                <div class="invalid-feedback">
                  <?= $validation->getError('name'); ?>
                </div>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label for="category" class="col-sm-3 col-form-label">
                <?= lang('Admin.category'); ?>
              </label>
              <div class="col-sm-9">
                <select class="form-select <?= ($validation->hasError('category')) ? 'is-invalid' : ''; ?>" name="category" id="category">
                  <option value=""><?= lang('Admin.selectCategory'); ?></option>
                  <?php foreach ($categories as $category) : ?>
                    <?php if (old('category', $product['category_id']) == $category['id']) : ?>
                      <option selected value="<?= $category['id']; ?>"><?= $category['name']; ?></option>
                    <?php else : ?>
                      <option value="<?= $category['id']; ?>"><?= $category['name']; ?></option>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">
                  <?= $validation->getError('category'); ?>
                </div>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label for="price" class="col-form-label col-sm-3">
                <?= lang('Admin.price'); ?>
              </label>
              <div class="col-sm-9">
                <input type="number" class="form-control <?= ($validation->hasError('price')) ? 'is-invalid' : ''; ?>" id="price" name="price" value="<?= old('price', $product['price']); ?>">
                <div class="invalid-feedback">
                  <?= $validation->getError('price'); ?>
                </div>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label for="domestic_stock" class="col-form-label col-sm-3">
                <?= lang('Admin.domesticStock'); ?>
              </label>
              <div class="col-sm-9">
                <div class="input-group">
                  <input type="number" class="form-control <?= ($validation->hasError('domestic_stock')) ? 'is-invalid' : ''; ?>" id="domestic_stock" name="domestic_stock" value="<?= old('domestic_stock', $product['domestic_stock']); ?>">
                  <span class="input-group-text">pcs</span>
                  <div class="invalid-feedback">
                    <?= $validation->getError('domestic_stock'); ?>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label for=international_stock" class="col-form-label col-sm-3">
                <?= lang('Admin.interStock'); ?>
              </label>
              <div class="col-sm-9">
                <div class="input-group">
                  <input type="number" class="form-control <?= ($validation->hasError('international_stock')) ? 'is-invalid' : ''; ?>" id="international_stock" name="international_stock" value="<?= old('international_stock', $product['international_stock']); ?>">
                  <span class="input-group-text">container</span>
                  <div class="invalid-feedback">
                    <?= $validation->getError('international_stock'); ?>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group row mb-3">
              <?php if ($product['image']) : ?>
                <div class="d-flex img-container justify-content-end">
                  <img src="<?= base_url('images/product-images/' . $product['image']) ?>" height="120" width="120" class="img-preview mb-2 border border-dark" style="object-fit: cover;">
                </div>
              <?php else : ?>
                <div class="d-none img-container justify-content-end">
                  <img height="120" width="120" class="img-preview mb-2 border border-dark" style="object-fit: cover;">
                </div>
              <?php endif; ?>

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

            <div class="form-group row mb-3">
              <label for="detail" class="col-form-label col-sm-3">Detail</label>
              <div class="col-sm-9">
                <textarea name="detail" class="form-control <?= ($validation->hasError('detail')) ? 'is-invalid' : ''; ?>" id="detail" rows="4"><?= old('detail', $product['detail']); ?></textarea>
                <div class="invalid-feedback">
                  <?= $validation->getError('detail'); ?>
                </div>
              </div>
            </div>

            <div class="form-group row mt-4 justify-content-end">
              <div class="col-sm-2">
                <button type="submit" class="btn btn-primary">
                  <?= lang('Admin.save'); ?>
                </button>
                <a class="btn btn-warning" href="<?= base_url('/admin/product'); ?>">
                  <?= lang('Admin.cancel'); ?>
                </a>
              </div>
            </div>
          </form>

        </div>
      </div>

      <div class="row">
        <div class="col-md-3">
          <form action="<?= base_url('/admin/product/' . $product['id']) ?>" method="post">
            <?= csrf_field(); ?>
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="btn btn-danger mb-3 d-block"><i data-feather="trash" class="mr-1"></i>Delete Product</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>