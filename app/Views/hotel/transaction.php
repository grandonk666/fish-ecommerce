<?= $this->extend('layouts/userTemplate'); ?>

<?= $this->section('content'); ?>

<main id="main">

  <section class="intro-single">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-lg-8">
          <div class="title-single-box">
            <h1 class="title-single">Check Your Order Transaction</h1>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="contact">
    <div class="container">
      <div class="row">
        <div class="col-md-5">

          <div class="title-box-d">
            <h3 class="title-d">Input Your Order ID</h3>
          </div>

          <form action="" method="post" role="form">
            <?= csrf_field() ?>


            <div class="form-group mb-4">
              <label for="order_id" class="form-label">
                <h4 class="icon-title">Order ID</h4>
              </label>
              <input type="text" name="order_id" class="form-control form-control-lg form-control-a" placeholder="Input your Order ID" required id="order_id" />
            </div>

            <button type="submit" class="btn btn-b mb-5">CHECK</button>
          </form>

        </div>

        <div class="col-md-7">
          <?php if ($transaksi != null) : ?>
            <div class="property-summary">
              <div class="row">
                <div class="col-sm-12">
                  <div class="title-box-d">
                    <h3 class="title-d">Transaction Details</h3>
                  </div>
                </div>
              </div>
              <div class="summary-list">
                <ul class="list">
                  <li class="d-flex justify-content-between">
                    <strong>Customer Name</strong>
                    <span><?= $transaksi['customer_name']; ?></span>
                  </li>
                  <li class="d-flex justify-content-between">
                    <strong>Item Name</strong>
                    <span><?= $transaksi['item_name']; ?></span>
                  </li>
                  <li class="d-flex justify-content-between">
                    <strong>Total Amount</strong>
                    <span>IDR <?= number_format($transaksi['gross_amount'], '0', '', '.'); ?></span>
                  </li>
                  <li class="d-flex justify-content-between">
                    <strong>Status</strong>
                    <p class="m-0"><span class="badge bg-<?= $badge; ?> text-light"><?= $transaksi['transaction_status']; ?></span></p>
                  </li>
                  <li class="d-flex justify-content-between">
                    <strong>Payment Code / VA Number</strong>
                    <span><?= $transaksi['payment_code']; ?></span>
                  </li>
                </ul>
              </div>
            </div>
          <?php endif; ?>
          <?php if ($pesan != '') : ?>
            <div class="post-content color-text-a">
              <p class="mb-2"><?= $pesan; ?></p>
              <?php if ($pdf != '') : ?>
                <p class="mb-1">you can get step-by-step instruction here</p>
                <a class="btn btn-primary mt-1" href="<?= $pdf; ?>">Download Instruction</a>
              <?php endif; ?>
              <?php if ($bill != '') : ?>
                <p class="mb-1">or you can download your bill here</p>
                <a class="btn btn-primary mt-1" href="<?= base_url('/download/' . $bill) ?>">Download Bill</a>
              <?php endif; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>

</main>
<!-- End #main -->

<?= $this->endSection(); ?>