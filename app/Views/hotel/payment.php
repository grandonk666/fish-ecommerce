<?= $this->extend('layouts/userTemplate'); ?>

<?= $this->section('content'); ?>

<main id="main">
  <section class="intro-single">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-lg-8">
          <div class="title-single-box">
            <h1 class="title-single">Confirm your order</h1>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="contact">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div class="property-summary">
            <div class="row">
              <div class="col-sm-12">
                <div class="title-box-d">
                  <h3 class="title-d">Room Detail</h3>
                </div>
              </div>
            </div>
            <div class="summary-list">
              <ul class="list">
                <li class="d-flex justify-content-between">
                  <strong>Name</strong>
                  <span><?= $kamar['nama']; ?></span>
                </li>
                <li class="d-flex justify-content-between">
                  <strong>Type</strong>
                  <span><?= $kamar['tipe']; ?></span>
                </li>
                <li class="d-flex justify-content-between">
                  <strong>Size</strong>
                  <span><?= $kamar['luas']; ?> m<sup>2</sup></span>
                </li>
                <li class="d-flex justify-content-between">
                  <strong>Capacity</strong>
                  <span><?= $kamar['kapasitas']; ?> people</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="property-summary">
            <div class="row">
              <div class="col-sm-12">
                <div class="title-box-d">
                  <h3 class="title-d">Order Detail</h3>
                </div>
              </div>
            </div>
            <div class="summary-list">
              <ul class="list">
                <li class="d-flex justify-content-between">
                  <strong>Room</strong>
                  <span><?= $item_details['name']; ?></span>
                </li>
                <li class="d-flex justify-content-between">
                  <strong>Room Price</strong>
                  <span>IDR <?= number_format($kamar['harga'], '0', '', '.'); ?></span>
                </li>
                <li class="d-flex justify-content-between">
                  <strong>Admin Fee</strong>
                  <span>IDR 5.000</span>
                </li>
                <li class="d-flex justify-content-between">
                  <strong>Total Price</strong>
                  <span>IDR <?= number_format($transaction_details['gross_amount'], '0', '', '.'); ?></span>
                </li>
                <li class="d-flex justify-content-between">
                  <strong>Name</strong>
                  <span><?= $customer_details['first_name'] . ' ' . $customer_details['last_name']; ?></span>
                </li>
                <li class="d-flex justify-content-between">
                  <strong>Email</strong>
                  <span><?= $customer_details['email']; ?></span>
                </li>
                <li class="d-flex justify-content-between">
                  <strong>Phone Number</strong>
                  <span><?= $customer_details['phone']; ?></span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-5">
          <form id="payment-form" method="post" action="<?= base_url('/hotel/finish') ?>">
            <input type="hidden" name="nama" id="nama" value="<?= $customer_details['first_name'] . ' ' . $customer_details['last_name']; ?>">
            <input type="hidden" name="item" id="item" value="<?= $item_details['name']; ?>">
            <input type="hidden" name="kamar_id" id="kamar_id" value="<?= $kamar['id']; ?>">
            <input type="hidden" name="ruangan_id" id="ruangan_id" value="<?= $ruangan['id']; ?>">
            <input type="hidden" name="result_type" id="result-type" value="">
            <input type="hidden" name="result_data" id="result-data" value="">
          </form>

          <button id="pay-button" class="btn btn-b me-4">PAY !</button>
          <a href="<?= base_url('/order/' . $kamar['slug']) ?>" class="btn btn-a">CANCEL</a>
        </div>
      </div>
    </div>
  </section>

</main>
<!-- End #main -->

<script defer src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-TnsCZjaEmG4TIouu"></script>
<script defer type="text/javascript">
  document.getElementById('pay-button').onclick = function() {
    // SnapToken acquired from previous step
    snap.pay('<?php echo $snapToken ?>', {
      // Optional
      onSuccess: function(result) {
        /* You may add your own js here, this is just example */
        document.getElementById('result-type').value = 'succsess';
        document.getElementById('result-data').value = JSON.stringify(result, null, 2);
        document.getElementById('payment-form').submit();
      },
      // Optional
      onPending: function(result) {
        /* You may add your own js here, this is just example */
        document.getElementById('result-type').value = 'pending';
        document.getElementById('result-data').value += JSON.stringify(result, null, 2);
        document.getElementById('payment-form').submit();
      },
      // Optional
      onError: function(result) {
        /* You may add your own js here, this is just example */
        document.getElementById('result-type').value = 'error';
        document.getElementById('result-data').value += JSON.stringify(result, null, 2);
        document.getElementById('payment-form').submit();
      }
    });
  };
</script>

<?= $this->endSection(); ?>