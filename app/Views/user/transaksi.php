<?= $this->extend('layouts/adminTemplate'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid p-0">
  <h1 class="h3 mb-3"><?= $title; ?></h1>

  <div class="row">
    <div class="col-12 col-lg-12 col-xxl-9">

      <div class="row justify-content-between d-print-none">
        <div class="col-md-6">
          <div class="row justify-content-between">
            <div class="col-8">
              <form action="" method="post">
                <div class="input-group mb-3">
                  <input type="text" name="keyword" class="form-control" placeholder="Enter Keyword">
                  <button class="btn btn-outline-primary" type="submit">Search</button>
                </div>
              </form>
            </div>
            <div class="col-4">
              <a href="<?= base_url('/profile/transaksi'); ?>" class="btn btn-outline-secondary d-block">Tampilkan Semua</a>
            </div>
          </div>
        </div>
        <div class="col-md-2">
          <a href="#" onclick="window.print()" class="btn btn-success mb-2 d-block"><i data-feather="printer"></i>Print</a>
        </div>
      </div>

      <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <div class="alert-message">
            <?= session()->getFlashdata('pesan'); ?>
          </div>
        </div>
      <?php endif; ?>


      <div class="card">
        <table class="table">
          <thead>
            <tr>
              <th class="d-none d-xl-table-cell d-print-table-cell">Order ID</th>
              <th class="d-none d-print-table-cell">Nama Pemesan</th>
              <th>Nama Pesanan</th>
              <th class="d-none d-xl-table-cell d-print-table-cell">Tipe</th>
              <th>Total</th>
              <th class="d-print-none d-none d-xl-table-cell">Kode Pembayaran
                / VA_Number</th>
              <th>Status</th>
              <th class="d-print-none">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($transaksi as $t) : ?>
              <tr>
                <td class="d-none d-xl-table-cell d-print-table-cell"><?= $t['order_id']; ?></td>
                <td class="d-none d-print-table-cell"><?= $t['customer_name']; ?></td>
                <td><?= $t['item_name']; ?></td>
                <td class="d-none d-xl-table-cell d-print-table-cell"><?= $t['payment_type']; ?></td>
                <td>Rp <?= number_format($t['gross_amount'], '0', '', '.'); ?></td>
                <td class="d-print-none d-none d-xl-table-cell"><?= $t['payment_code']; ?></td>
                <td>
                  <span class="badge bg-<?= $t['badge']; ?>"><?= $t['transaction_status']; ?></span>
                </td>
                <td class="d-print-none">
                  <a href="<?= base_url("/profile/order/" . $t['id']); ?>" class="btn btn-sm btn-outline-info">Detail</a>
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