<?= $this->extend('layouts/adminTemplate'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid p-0">
  <h1 class="h3 mb-3"><?= $title; ?></h1>

  <div class="row">
    <div class="col-12 col-lg-12 col-xxl-9">
      <div class="row">
        <div class="col-md-3">
          <a href="<?= base_url('/admin/category/create') ?>" class="btn btn-primary mb-3 d-block"><i data-feather="plus"></i>Add Category</a>
        </div>
      </div>

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


      <div class="card">
        <table class="table">
          <thead>
            <tr>
              <th style="width: 40%">Name</th>
              <th style="width: 40%">Total Products</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($categories as $category) : ?>
              <tr>
                <td><?= $category['name']; ?></td>
                <td>
                  <strong><?= count($category['products']); ?></strong>
                </td>
                <td class="table-action">
                  <a href="<?= base_url("/admin/category/edit/" . $category['id']); ?>" class="btn btn-outline"><i class="align-middle" data-feather="edit-2"></i></a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>