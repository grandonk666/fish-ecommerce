<?= $this->extend('layouts/adminTemplate'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid p-0">
  <h1 class="display-6 mb-3"><?= $title; ?></h1>

  <?php if (in_groups('admin')) : ?>
    <div class="row justify-content-between d-print-none">
      <div class="col-md-6">
        <form action="<?= base_url('/admin/transaction/reciept') ?>" method="POST">
          <?= csrf_field(); ?>
          <input type="hidden" name="transaction_id" value="<?= $transaction['id']; ?>">

          <div class="input-group mb-3">
            <input type="text" class="form-control py-2" placeholder="Reciept Number" name="reciept_number" value="<?= old('reciept_number', $transaction['reciept_number']) ?>">
            <button class="btn btn-info" type="submit">
              <?php if ($transaction['reciept_number']) : ?>
                <?= lang('Admin.updateReciept'); ?>
              <?php else : ?>
                <?= lang('Admin.setReciept'); ?>
              <?php endif; ?>
            </button>
          </div>
        </form>
      </div>
    </div>
  <?php endif; ?>

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

  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <ul class="list-group list-group-flush">
          <li class="d-flex list-group-item py-3 justify-content-between">
            <strong><?= lang('Admin.serialNumber'); ?></strong>
            <span><?= $transaction['serial_number']; ?></span>
          </li>
          <li class="d-flex list-group-item py-3 justify-content-between">
            <strong><?= lang('Admin.transactionId'); ?></strong>
            <span><?= $transaction['transaction_id']; ?></span>
          </li>
          <li class="d-flex list-group-item py-3 justify-content-between">
            <strong><?= lang('Admin.customer'); ?></strong>
            <span><?= $transaction['user']->name; ?></span>
          </li>
          <li class="d-flex list-group-item py-3 justify-content-between">
            <strong><?= lang('Admin.totalItem'); ?></strong>
            <span><?= count($transaction['order']); ?></span>
          </li>
          <li class="d-flex list-group-item py-3 justify-content-between">
            <strong><?= lang('Admin.total'); ?></strong>
            <span>Rp <?= number_format($transaction['total'], '0', '', '.'); ?></span>
          </li>
          <li class="d-flex list-group-item py-3 justify-content-between">
            <strong><?= lang('Admin.type'); ?></strong>
            <span><?= $transaction['payment_type']; ?></span>
          </li>
          <li class="d-flex list-group-item py-3 justify-content-between">
            <strong><?= lang('Admin.paymentCode'); ?></strong>
            <span><?= $transaction['payment_code']; ?></span>
          </li>
          <li class="d-flex list-group-item py-3 justify-content-between">
            <strong><?= lang('Admin.status'); ?></strong>
            <p class="m-0"><span class="text-uppercase badge bg-<?= $badge; ?> text-light"><?= $transaction['status']; ?></span></p>
          </li>
        </ul>
      </div>
    </div>
    <div class="col-md-6">
      <?php if ($pesan != '') : ?>
        <div class="card">
          <div class="card-body">
            <div class="card-text">
              <p class="h3 mb-2"><?= $pesan; ?></p>
              <?php if ($transaction['reciept_number']) : ?>
                <p class="h4 text-muted mb-2">
                  <?= lang('Admin.thisIsReciept'); ?> : <?= $transaction['reciept_number']; ?>
                </p>
              <?php endif; ?>
              <?php if ($pdf != '') : ?>
                <a class="btn btn-primary mb-2" href="<?= $pdf; ?>">
                  <?= lang('Admin.downloadInstructions'); ?>
                </a>
              <?php endif; ?>
              <?php if ($bill != '') : ?>
                <p class="h4 text-muted mb-2">
                  <?= lang('Admin.getPaymentBill'); ?>
                </p>
                <a class="btn btn-primary mb-2" href="<?= base_url($bill) ?>">
                  <?= lang('Admin.downloadBill'); ?>
                </a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endif; ?>
      <div class="card">
        <div class="py-3">
          <div class="card-header my-0 py-0">
            <h4><?= lang('Admin.listItem'); ?></h4>
          </div>
          <div class="card-body my-0 py-0">
            <ul class="list-group list-group-flush my-0 py-0 px-4">
              <?php foreach ($transaction['order'] as $order) : ?>
                <li class="d-flex justify-content-between py-1">
                  <span><?= $order['name'] ?> <strong>x</strong> <?= $order['quantity'] ?></span>
                  <span>Rp <?= number_format($order['quantity'] * $order['price'], '0', '', '.') ?></span>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
        <div class="dropdown-divider px-4"></div>
        <div class="py-3">
          <div class="card-header my-0 py-0 d-flex justify-content-between">
            <h4><?= lang('Admin.total'); ?></h4>
            <span class="px-4">Rp <?= number_format($transaction['total'], '0', '', '.'); ?></span>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="py-3">
          <div class="card-header my-0 py-0">
            <h4><?= lang('Admin.deliveryDetail'); ?></h4>
          </div>
          <div class="card-body my-0 py-0">
            <ul class="list-group list-group-flush my-0 py-0 px-4">
              <li class="d-block py-1">
                <p class="mb-0 h5">
                  <?= lang('Admin.detailAddress'); ?>
                </p>
                <p class="text-muted mb-0"><?= $transaction['address'] ?></p>
              </li>
              <li class="d-block py-1">
                <p class="mb-0 h5">
                  <?= lang('Admin.city'); ?>
                </p>
                <p class="text-muted mb-0"><?= $transaction['city'] ?></p>
              </li>
              <li class="d-block py-1">
                <p class="mb-0 h5">
                  <?= lang('Admin.province'); ?>
                </p>
                <p class="text-muted mb-0"><?= $transaction['province'] ?></p>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>