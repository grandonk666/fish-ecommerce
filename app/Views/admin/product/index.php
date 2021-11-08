<?= $this->extend('layouts/adminTemplate'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid p-0">
  <h1 class="h3 mb-3"><?= $title; ?></h1>

  <div class="row">
    <div class="col-12 col-lg-12 col-xxl-9">
      <div class="row">
        <div class="col-md-3">
          <a href="<?= base_url('/admin/product/create') ?>" class="btn btn-primary mb-3 d-block"><i data-feather="plus"></i>Add Product</a>
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
              <th>Name</th>
              <th>Category</th>
              <th>Domestic Stock</th>
              <th>International Stock</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($products as $product) : ?>
              <tr>
                <td><?= $product['name']; ?></td>
                <td>
                  <strong><?= $product['category']['name']; ?></strong>
                </td>
                <td><?= $product['domestic_stock'] > 0 ? $product['domestic_stock'] . ' pcs' : 'out of stock'; ?></td>
                <td><?= $product['international_stock'] > 0 ? $product['international_stock'] . ' container' : 'out of stock'; ?></td>
                <td class="table-action">
                  <a href="<?= base_url("/admin/product/edit/" . $product['id']); ?>" class="btn btn-outline"><i class="align-middle" data-feather="edit-2"></i></a>
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