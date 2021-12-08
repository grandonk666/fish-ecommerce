<?= $this->extend('layouts/adminTemplate'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid p-0">
  <h1 class="h3 mb-3"><?= $title; ?></h1>

  <div class="row">
    <div class="col-12 col-lg-12 col-xxl-9">

      <div class="row justify-content-between d-print-none">
        <div class="col-md-2">
          <a href="#" onclick="window.print()" class="btn btn-success mb-2 d-block"><i data-feather="printer"></i><?= lang('Admin.print'); ?></a>
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
              <th class="d-none d-xl-table-cell d-print-table-cell"><?= lang('Admin.customer'); ?></th>
              <th class="d-none d-xl-table-cell d-print-table-cell"><?= lang('Admin.type'); ?></th>
              <th><?= lang('Admin.totalItem'); ?></th>
              <th><?= lang('Admin.total'); ?></th>
              <th><?= lang('Admin.status'); ?></th>
              <th class="d-print-none"><?= lang('Admin.action'); ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($transactions as $transaction) : ?>
              <tr>
                <td class="d-none d-xl-table-cell d-print-table-cell"><?= $transaction['user']->firstname; ?></td>
                <td class="d-none d-xl-table-cell d-print-table-cell"><?= $transaction['payment_type']; ?></td>
                <td><?= count($transaction['order']); ?></td>
                <td>Rp <?= number_format($transaction['total'], '0', '', '.'); ?></td>
                <td>
                  <span class="text-uppercase badge bg-<?= $transaction['badge']; ?>"><?= $transaction['status']; ?></span>
                </td>
                <td class="d-print-none">
                  <?php if (in_groups('admin')) : ?>
                    <a href="<?= base_url("/admin/transaction/" . $transaction['id']); ?>" class="btn btn-sm btn-outline-info"><?= lang('Admin.detail'); ?></a>
                  <?php else : ?>
                    <a href="<?= base_url("/profile/transaction/" . $transaction['id']); ?>" class="btn btn-sm btn-outline-info"><?= lang('Admin.detail'); ?></a>
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