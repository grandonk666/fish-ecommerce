<?= $this->extend('layouts/userTemplate'); ?>

<?= $this->section('content'); ?>

<section class="ftco-section">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 mb-5 ftco-animate">
        <img src="<?= base_url('/images/product-images/' . $product['image']) ?>" class="img-fluid" alt="<?= $product['name']; ?>">
      </div>

      <div class="col-lg-6 product-details pl-md-5 ftco-animate">
        <h3><?= $product['name']; ?></h3>
        <p class="price">
          <span>Rp <?= number_format($product['price'], 0, ',', '.') ?></span>
        </p>

        <p>
          <?= $product['detail']; ?>
        </p>

        <div id="cart-section">

          <?php if ($product['in_cart']) : ?>
            <h5>Already In Cart</h5>
          <?php elseif (!$product['in_cart'] && $product['domestic_stock'] > 0) : ?>

            <form action="<?= base_url('/cart') ?>" method="POST" id="add-to-cart">
              <?= csrf_field(); ?>
              <input type="hidden" name="product_id" value="<?= $product['id']; ?>">

              <div class="row mt-4">
                <div class="input-group col-md-6 d-flex mb-3">
                  <span class="input-group-btn mr-2">
                    <button type="button" class="quantity-left-minus btn" data-type="minus" data-field="">
                      <i class="ion-ios-remove"></i>
                    </button>
                  </span>
                  <input type="text" id="quantity" value="1" name="quantity" class="form-control input-number" min="1" max="100">
                  <span class="input-group-btn ml-2">
                    <button type="button" class="quantity-right-plus btn" data-type="plus" data-field="">
                      <i class="ion-ios-add"></i>
                    </button>
                  </span>
                </div>
              </div>
              <p>
                <button type="submit" class="btn btn-black py-3 px-5">
                  Add to Cart
                </button>
              </p>
            </form>

          <?php else : ?>
            <h5>Out Of Stock</h5>
          <?php endif; ?>
        </div>
      </div>


    </div>
  </div>
</section>

<section class="ftco-section">
  <div class="container">
    <div class="row justify-content-center mb-3 pb-3">
      <div class="col-md-12 heading-section text-center ftco-animate">
        <span class="subheading">Latest Products</span>
        <h2 class="mb-4">Our Products</h2>
        <p>Solusi Menyediakan Hidangan Rumah Dalam Waktu Singkat</p>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">

      <?php foreach ($latestProducts as $product) : ?>
        <div class="col-md-6 col-lg-3 ftco-animate">
          <div class="product">
            <a href="<?= base_url('/product/' . $product['slug']) ?>" class="img-prod">
              <img class="img-fluid" src="<?= base_url('/images/product-images/' . $product['image']) ?>" alt="<?= $product['name']; ?>" style="min-height:260px;max-height:260px;width:100%;">
              <div class="overlay"></div>
            </a>

            <div class="text py-3 pb-4 px-3 text-center">
              <h3>
                <a href="<?= base_url('/product/' . $product['slug']) ?>"><?= $product['name']; ?></a>
              </h3>
              <div class="d-flex">
                <div class="pricing" style="text-align:center;">
                  <p class="price"><span>
                      Rp <?= number_format($product['price'], 0, ',', '.') ?></span>
                  </p>
                </div>
              </div>

              <?php if (!$product['in_cart']) : ?>
                <div class="bottom-area d-flex px-3" id="<?= 'product-' . $product['id']; ?>">
                  <div class="m-auto d-flex">
                    <form>
                      <button onclick="addToCart(<?= $product['id']; ?>);" type="button" class="buy-now d-flex justify-content-center align-items-center mx-1 ">
                        <span><i class="ion-ios-cart"></i> Add To Cart</span>
                        </a>
                    </form>
                  </div>
                </div>
              <?php endif; ?>

            </div>
          </div>
        </div>
      <?php endforeach; ?>

    </div>
  </div>
</section>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>

<script>
  function addToCart(product_id) {
    $.ajax({
      url: "<?= base_url('/cart') ?>",
      type: "POST",
      data: {
        product_id: product_id,
        quantity: 1
      }
    }).done(function(data) {
      refresh_count();
      if ($('#product-' + product_id)) {
        $('#product-' + product_id).remove()
      }
    });
  };

  var quantity = 0;
  $('.quantity-right-plus').click(function(e) {
    e.preventDefault();
    var quantity = parseInt($('#quantity').val());
    $('#quantity').val(quantity + 1);
  });

  $('.quantity-left-minus').click(function(e) {
    e.preventDefault();
    var quantity = parseInt($('#quantity').val());
    if (quantity > 0) {
      $('#quantity').val(quantity - 1);
    }
  });

  $('#add-to-cart').submit(function(e) {
    e.preventDefault();

    let product_id = $('[name=product_id]').val();
    let quantity = $('[name=quantity]').val();

    $.ajax({
      url: "<?php echo base_url('/cart') ?>",
      type: "POST",
      data: {
        product_id: product_id,
        quantity: quantity
      }
    }).done(function(data) {
      refresh_count();
      $('#cart-section').html('<h5>Already In Cart</h5>')
    });
  });
</script>

<?= $this->endSection(); ?>