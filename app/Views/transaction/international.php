<?= $this->extend('layouts/adminTemplate'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid p-0">
  <h1 class="h3 mb-3"><?= $title; ?></h1>

  <div class="row">
    <div class="col-12 col-lg-12 col-xxl-9">

      <div class="row justify-content-between d-print-none">
        <div class="col-md-2">
          <a href="#" onclick="window.print()" class="btn btn-success mb-2 d-block"><i data-feather="printer"></i>Print</a>
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
              <th class="d-none d-xl-table-cell d-print-table-cell">Customer</th>
              <th class="d-none d-xl-table-cell d-print-table-cell">Product</th>
              <th>Status</th>
              <th class="d-print-none">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($transactions as $transaction) : ?>
              <tr>
                <td class="d-none d-xl-table-cell d-print-table-cell"><?= $transaction['user']->name; ?></td>
                <td class="d-none d-xl-table-cell d-print-table-cell"><?= $transaction['product']['name']; ?></td>
                <td>
                  <span class="text-uppercase badge bg-<?= $transaction['badge']; ?>"><?= $transaction['status']; ?></span>
                </td>
                <td class="d-print-none">
                  <?php if (in_groups('admin')) : ?>
                    <a href="<?= base_url("/admin/international/" . $transaction['id']); ?>" class="btn btn-sm btn-outline-info">Detail</a>
                  <?php else : ?>
                    <a href="<?= base_url("/profile/international/" . $transaction['id']); ?>" class="btn btn-sm btn-outline-info">Detail</a>
                  <?php endif; ?>
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