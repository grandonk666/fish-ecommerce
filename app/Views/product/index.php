<?= $this->extend('layouts/userTemplate'); ?>

<?= $this->section('content'); ?>

<div class="hero-wrap hero-bread" style="background-image: url(<?= base_url('/images/bg_3.jpg') ?>);">
  <div class="container-fluid" style="background-color: rgba(0, 0, 0, 0.2); padding: 15em 0;">
    <div class="row no-gutters slider-text align-items-center justify-content-center">
      <div class="col-md-10 ftco-animate text-center">
        <p class="breadcrumbs"><span class="mr-2"><a href="<?= base_url() ?>"><?= lang('Home.nav.home'); ?></a></span> <span><?= lang('Home.nav.products'); ?></span>
        </p>
        <h1 class="mb-0 display-3 text-light"><?= lang('Home.nav.products'); ?></h1>
      </div>
    </div>
  </div>
</div>

<section class="ftco-section">
  <div class="container">
    <div class="row">
      <?php foreach ($products as $product) : ?>
        <div class="col-md-6 col-lg-3 ftco-animate">
          <div class="product">
            <a href="<?= base_url('/product/' . $product['slug']) ?>" class="img-prod">
              <img class="img-fluid" src="<?= base_url('/images/product-images/' . $product['image']) ?>" alt="<?= $product['name']; ?>">
              <div class="overlay"></div>
            </a>
            <div class="text py-3 pb-4 px-3 text-center">
              <h3><a href="<?= base_url('/product/' . $product['slug']) ?>"><?= $product['name']; ?></a></h3>
              <div class="d-flex">
                <div class="pricing">
                  <p class="price">
                    <span class="price-sale">Rp
                      <?= number_format($product['price'], 0, ',', '.') ?></span>
                  </p>
                </div>
              </div>

              <?php if (!$product['in_cart'] && $product['domestic_stock'] > 0) : ?>
                <div class="bottom-area d-flex px-3" id="<?= 'product-' . $product['id']; ?>">
                  <div class="m-auto d-flex">
                    <form>
                      <button onclick="addToCart(<?= $product['id']; ?>);" type="button" class="buy-now d-flex justify-content-center align-items-center mx-1 ">
                        <span><i class="ion-ios-cart"></i><?= lang('Home.addCart'); ?></span>
                      </button>
                    </form>
                  </div>
                </div>
              <?php endif; ?>

              <?php if ($product['domestic_stock'] <= 0) : ?>
                <div class="bottom-area d-flex px-3">
                  <div class="m-auto d-flex">
                    <button type="button" class="buy-now d-flex justify-content-center align-items-center mx-1 text-primary" style="background-color: #fff !important;" disabled>
                      <span><?= lang('Home.outStock'); ?></span>
                    </button>
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
</script>

<?= $this->endSection(); ?>