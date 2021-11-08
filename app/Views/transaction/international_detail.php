<?= $this->extend('layouts/adminTemplate'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid p-0">
  <h1 class="display-6 mb-3"><?= $title; ?></h1>

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

  <?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <div class="alert-message">
        <?= session()->getFlashdata('error'); ?>
      </div>
    </div>
  <?php endif; ?>

  <?php if (in_groups('admin')) : ?>
    <div class="row justify-content-between d-print-none">

      <div class="col-md-6">
        <form action="<?= base_url('/admin/international/invoice') ?>" method="POST" class="mb-3" enctype="multipart/form-data">
          <?= csrf_field(); ?>
          <input type="hidden" name="transaction_id" value="<?= $transaction['id']; ?>">

          <div class="input-group">
            <input name="invoice" id="invoice" type="file" class="form-control <?= ($validation->hasError('invoice')) ? 'is-invalid' : ''; ?>">
            <button class="btn btn-success" type="submit">Upload Invoice</button>
            <div class="invalid-feedback">
              <?= $validation->getError('invoice'); ?>
            </div>
          </div>
          <span>You are approve the order if you upload the invoice</span>
        </form>
      </div>

      <div class="col-md-6">
        <form action="<?= base_url('/admin/international/reciept') ?>" method="POST" class="mb-3" enctype="multipart/form-data">
          <?= csrf_field(); ?>
          <input type="hidden" name="transaction_id" value="<?= $transaction['id']; ?>">

          <div class="input-group">
            <input name="reciept" id="reciept" type="file" class="form-control <?= ($validation->hasError('reciept')) ? 'is-invalid' : ''; ?>">
            <button class="btn btn-warning" type="submit">Upload Reciept</button>
            <div class="invalid-feedback">
              <?= $validation->getError('reciept'); ?>
            </div>
          </div>
          <span>Make sure to check te payment before you upload the reciept</span>
        </form>
      </div>

    </div>
  <?php endif; ?>

  <div class="row justify-content-between d-print-none">
    <div class="col-md-6">

      <form action="<?= base_url('international/payment') ?>" method="POST" class="mb-3" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <input type="hidden" name="transaction_id" value="<?= $transaction['id']; ?>">

        <div class="input-group">
          <input name="payment" id="payment" type="file" class="form-control <?= ($validation->hasError('payment')) ? 'is-invalid' : ''; ?>">
          <button class="btn btn-info" type="submit">Upload Payment Bill</button>
          <div class="invalid-feedback">
            <?= $validation->getError('payment'); ?>
          </div>
        </div>
      </form>

    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <ul class="list-group list-group-flush">
          <li class="d-flex list-group-item py-3 justify-content-between">
            <strong>Customer Name</strong>
            <span><?= $transaction['user']->name; ?></span>
          </li>
          <li class="d-flex list-group-item py-3 justify-content-between">
            <strong>Company Name</strong>
            <span><?= $transaction['company_name']; ?></span>
          </li>
          <li class="d-flex list-group-item py-3 justify-content-between">
            <strong>Address</strong>
            <span><?= $transaction['address']; ?></span>
          </li>
          <li class="d-flex list-group-item py-3 justify-content-between">
            <strong>Item Name</strong>
            <span>1 container of <strong><?= $transaction['product']['name'] ?></strong></span>
          </li>
          <li class="d-flex list-group-item py-3 justify-content-between">
            <strong>Status</strong>
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
              <?php if ($pdf != '') : ?>
                <p class="h4 text-muted mb-2">You can get step by step payment here</p>
                <a class="btn btn-primary mb-2" href="<?= $pdf; ?>">Download Instructions</a>
              <?php endif; ?>
              <?php if ($bill != '') : ?>
                <p class="h4 text-muted mb-2">You can get your payment bill here</p>
                <a class="btn btn-primary mb-2" href="<?= base_url($bill) ?>">Download Bill</a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <div class="card">
        <ul class="list-group list-group-flush">

          <?php if ($transaction['invoice']) : ?>
            <li class="d-flex list-group-item py-3 justify-content-between">
              <strong>Invoice</strong>
              <a target="_blank" href="<?= base_url('/invoice/' . $transaction['invoice']) ?>" class="btn btn-info">Open</a>
            </li>
          <?php endif; ?>
          <?php if ($transaction['payment']) : ?>
            <li class="d-flex list-group-item py-3 justify-content-between">
              <strong>Payment Bill</strong>
              <a target="_blank" href="<?= base_url('/payment/' . $transaction['payment']) ?>" class="btn btn-info">Open</a>
            </li>
          <?php endif; ?>
          <?php if ($transaction['shipping_reciept']) : ?>
            <li class="d-flex list-group-item py-3 justify-content-between">
              <strong>Shiiping Reciept</strong>
              <a target="_blank" href="<?= base_url('/reciept/' . $transaction['shipping_reciept']) ?>" class="btn btn-info">Open</a>
            </li>
          <?php endif; ?>

        </ul>
      </div>

    </div>
  </div>
</div>

<?= $this->endSection(); ?>