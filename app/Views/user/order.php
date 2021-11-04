<?= $this->extend('layouts/adminTemplate'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid p-0">
  <h1 class="display-6 mb-3"><?= $title; ?></h1>

  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <ul class="list-group list-group-flush">
          <li class="d-flex list-group-item py-3 justify-content-between">
            <strong>Order ID</strong>
            <span><?= $transaksi['order_id']; ?></span>
          </li>
          <li class="d-flex list-group-item py-3 justify-content-between">
            <strong>Nama Customer</strong>
            <span><?= $transaksi['customer_name']; ?></span>
          </li>
          <li class="d-flex list-group-item py-3 justify-content-between">
            <strong>Nama Item</strong>
            <span><?= $transaksi['item_name']; ?></span>
          </li>
          <li class="d-flex list-group-item py-3 justify-content-between">
            <strong>Total Harga</strong>
            <span>IDR <?= number_format($transaksi['gross_amount'], '0', '', '.'); ?></span>
          </li>
          <li class="d-flex list-group-item py-3 justify-content-between">
            <strong>Tipe Pembayaran</strong>
            <span><?= $transaksi['payment_type']; ?></span>
          </li>
          <li class="d-flex list-group-item py-3 justify-content-between">
            <strong>Kode Pembayaran / VA Number</strong>
            <span><?= $transaksi['payment_code']; ?></span>
          </li>
          <li class="d-flex list-group-item py-3 justify-content-between">
            <strong>Status</strong>
            <p class="m-0"><span class="badge bg-<?= $badge; ?> text-light"><?= $transaksi['transaction_status']; ?></span></p>
          </li>
        </ul>
      </div>
      <a class="btn btn-sm btn-secondary text-decoration-none" href="<?= base_url('/profile/transaksi'); ?>">Kembali ke daftar</a>
    </div>
    <?php if ($pesan != '') : ?>
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <div class="card-text">
              <p class="h2 mb-2"><?= $pesan; ?></p>
              <?php if ($pdf != '') : ?>
                <p class="h4 text-muted mb-2">Anda bisa mendapatkan petunjuk pembayaran melalui tombol dibawah</p>
                <a class="btn btn-primary mb-2" href="<?= $pdf; ?>">Download Instruksi</a>
              <?php endif; ?>
              <?php if ($bill != '') : ?>
                <p class="h4 text-muted mb-2">atau Anda bisa mendapatkan nota bukti pembayaran melalui tombol dibawah</p>
                <a class="btn btn-primary mb-2" href="<?= base_url('/download/' . $bill) ?>">Download Nota</a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>

<?= $this->endSection(); ?>