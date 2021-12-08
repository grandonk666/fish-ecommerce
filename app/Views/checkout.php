<?= $this->extend('layouts/userTemplate'); ?>

<?= $this->section('content'); ?>

<div class="hero-wrap hero-bread" style="background-image: url(<?= base_url('/images/bg_2.jpg') ?>);">
  <div class="container-fluid" style="background-color: rgba(0, 0, 0, 0.2); padding: 15em 0;">
    <div class="row no-gutters slider-text align-items-center justify-content-center">
      <div class="col-md-10 ftco-animate text-center">
        <p class="breadcrumbs"><span class="mr-2"><a href="<?= base_url() ?>"><?= lang('Home.nav.home'); ?></a></span> <span><?= lang('Home.nav.checkout'); ?></span>
        </p>
        <h1 class="mb-0 display-3 text-light"><?= lang('Home.nav.checkout'); ?></h1>
      </div>
    </div>
  </div>
</div>

<section class="ftco-section">
  <div class="container">

    <div class="row justify-content-center">
      <div class="col-xl-7 ftco-animate">
        <h3 class="mb-4 billing-heading"><?= lang('Home.deliveryInfo'); ?></h3>

        <div class="row align-items-end">
          <div class="col-md-12">
            <div class="form-group" id="address-section">
              <label for="address"><?= lang('Home.detailAddress'); ?></label>
              <input type="text" name="address" required class="form-control" style="color:black !important" id="address" value="<?= old('address') ?>">
            </div>
          </div>

          <div class="w-100"></div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="province_list"><?= lang('Home.province'); ?></label>
              <select name="province_list" id="province_list" required class="form-control" style="color:black !important">
                <option value=""> -- <?= lang('Home.selectProvince'); ?> -- </option>
                <?php foreach ($listProvince as $province) : ?>
                  <option value="<?= $province['province_id'] ?>__<?= $province['province'] ?>">
                    <?= $province['province']; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="city_list"><?= lang('Home.city'); ?></label>
              <select required name="city_list" id="city_list" class="form-control" style="color:black !important">
                <option value=""> -- <?= lang('Home.selectCity'); ?> -- </option>
              </select>
            </div>
          </div>
          <div class="w-100"></div>
          <div class="col-md-12">
            <div class="form-group" id="postal-section">
              <label for="code"><?= lang('Home.postCode'); ?></label>
              <input type="text" name="code" required class="form-control" style="color:black !important" id="code" value="<?= old('code') ?>">
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-5">
        <div class="row mt-5 pt-3">

          <div class="col-md-12">
            <div class="form-group" id="delivery-section">
              <label for="delivery"><?= lang('Home.deliveryOpt'); ?></label>
              <select name="delivery" id="delivery" required class="form-control" style="color:black !important">
                <option value=""> -- <?= lang('Home.selectDeliveryOpt'); ?> -- </option>
              </select>
            </div>
          </div>

          <div class="col-md-12 d-flex mb-3">
            <div class="cart-detail cart-total p-3 p-md-4">
              <h3 class="billing-heading mb-4"><?= lang('Home.cartTotal'); ?></h3>

              <div id="checkout_detail">
                <p class="d-flex">
                  <span><?= lang('Home.subtotal'); ?></span>
                  <span><?= $subtotal; ?></span>
                </p>
              </div>
              <hr>
              <p class="d-flex total-price">
                <span><?= lang('Home.total'); ?></span>
                <span class="total"><?= $subtotal; ?></span>
              </p>

              <button class="btn btn-primary py-3 px-4" id="pay-btn" type="button">
                <?= lang('Home.placeOrder'); ?>
              </button>
            </div>
          </div>
        </div>
      </div> <!-- .col-md-8 -->
    </div>
  </div>
</section>

<form id="finish-form" action="<?= base_url('/checkout/finish') ?>" method="post" style="display: hidden;">
  <?= csrf_field(); ?>
  <input type="hidden" name="province">
  <input type="hidden" name="province_id">
  <input type="hidden" name="city">
  <input type="hidden" name="city_id">
  <input type="hidden" name="postal_code">
  <input type="hidden" name="delivery_address">
  <input type="hidden" name="delivery_cost">
  <input type="hidden" name="delivery_service">
  <input type="hidden" name="result_data">
  <input type="hidden" name="list_items">
</form>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-ZK2Q4mMwnOvnPZFO"></script>

<script>
  $(document).ready(function() {
    $('#pay-btn').click(function(e) {
      e.preventDefault();

      let deliveryCost = $('input[name="delivery_cost"]').val()
      let deliveryService = $('input[name="delivery_service"]').val()
      let deliveryAddress = $('input[name="address"]').val()
      let city = $('input[name="city"]').val()
      let code = $('input[name="code"]').val()

      if (!deliveryAddress) {
        $('input[name="address"]').addClass('is-invalid')
        $('#address-section').append(
          `<div class="invalid-feedback">
              Input the Delivery Address Detail
            </div>`
        )
        return
      }

      if (!code) {
        $('input[name="code"]').addClass('is-invalid')
        $('#postal-section').append(
          `<div class="invalid-feedback">
              Input the Postal Code
            </div>`
        )
        return
      }

      if (!deliveryCost) {
        $('select[name="delivery"]').addClass('is-invalid')
        $('#delivery-section').append(
          `<div class="invalid-feedback">
              Select an Option
            </div>`
        )
        return
      }

      $('#pay-btn').prop('disabled', true);
      $('#pay-btn').html(
        `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
          Processing`
      )

      $.ajax({
        url: `/checkout/token?delivery_cost=${deliveryCost}&delivery_service=${deliveryService}&city=${city}`,
        type: "POST",
        data: {
          delivery_cost: deliveryCost,
          delivery_service: deliveryService,
          city: city,
          delivery_address: deliveryAddress,
          postal_code: code
        },
        dataType: "json",
        success: function(response) {
          console.log(response)
          snap.pay(response.token, {
            onSuccess: function(result) {
              $('input[name="result_data"]').val(JSON
                .stringify(result, null, 2))
              $('input[name="delivery_address"]').val(deliveryAddress)
              $('input[name="postal_code"]').val(code)
              $('input[name="list_items"]').val(response.list_items)
              $('#finish-form').submit()
            },
            onPending: function(result) {
              $('input[name="result_data"]').val(JSON
                .stringify(result, null, 2))
              $('input[name="delivery_address"]').val(deliveryAddress)
              $('input[name="postal_code"]').val(code)
              $('input[name="list_items"]').val(JSON
                .stringify(response.list_items, null, 2))
              $('#finish-form').submit()
            },
            onError: function(result) {
              $('input[name="result_data"]').val(JSON
                .stringify(result, null, 2))
              $('input[name="delivery_address"]').val(deliveryAddress)
              $('input[name="postal_code"]').val(code)
              $('input[name="list_items"]').val(response.list_items)
              $('#finish-form').submit()
            }
          });
        },
        error: function(response) {
          console.log(response)
        },
      });

    })
  })
</script>

<script>
  $('select[name="province_list"]').on('change', function() {
    let provinceValues = $(this).val().split("__")
    $('input[name="province"]').val(provinceValues[1])
    $('input[name="province_id"]').val(provinceValues[0])
    let provinceId = provinceValues[0]
    if (provinceId) {
      $.ajax({
        url: '/checkout/cities?province_id=' + provinceId,
        type: "GET",
        dataType: "json",
        success: function(response) {
          $('select[name="city_list"]').empty();
          $('select[name="city_list"]').append(
            '<option value=""> -- Select City -- </option>');

          $.each(response, function(key, value) {
            $('select[name="city_list"]').append(
              `<option value="${value.city_id}__${value.type} ${value.city_name}">
                   ${value.type} ${value.city_name} 
                  </option>`
            );
          });
        },
      });
    } else {
      $('select[name="city_list"]').append(
        '<option value=""> -- Select City -- </option>');
    }
  });

  $('select[name="city_list"]').on('change', function() {
    let cityValues = $(this).val().split("__")
    console.log(cityValues)
    $('input[name="city"]').val(cityValues[1])
    $('input[name="city_id"]').val(cityValues[0])
    let cityId = cityValues[0]
    if (cityId) {
      $.ajax({
        url: '/checkout/costs?city_id=' + cityId,
        type: "GET",
        dataType: "json",
        success: function(response) {
          $('select[name="delivery"]').empty();
          $('select[name="delivery"]').append(
            '<option value=""> -- Select Delivery Option -- </option>');

          $.each(response, function(key, value) {
            $('select[name="delivery"]').append(
              `<option value="${value.cost[0].value}__${value.service}">
                   JNE ${value.service} 
                  </option>`
            );
          });
        },
      });
    } else {
      $('select[name="delivery"]').append(
        '<option value=""> -- Select Delivery Option -- </option>');
    }
  });

  $('select[name="delivery"]').on('change', function() {
    let deliveryValues = $(this).val().split('__')
    let deliveryCost = deliveryValues[0]
    let deliveryService = deliveryValues[1]

    if ($('#delivery_cost')) {
      $('#delivery_cost').remove()
    }

    $('#checkout_detail').append(
      `<p class="d-flex" id="delivery_cost">
          <span>Delivery</span>
          <span>${deliveryCost}</span>
        </p>`
    )

    $('input[name="delivery_cost"]').val(deliveryCost)
    $('input[name="delivery_service"]').val(`JNE ${deliveryService}`)
    let subtotal = parseInt($('span.total').text())
    let delivery = parseInt(deliveryCost)
    $('span.total').text(`${subtotal + delivery}`)
  })
</script>

<?= $this->endSection(); ?>