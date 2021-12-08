<?= $this->extend('layouts/userTemplate'); ?>

<?= $this->section('content'); ?>

<div class="hero-wrap hero-bread" style="background-image: url(<?= base_url('/images/bg_1.jpg') ?>);">
  <div class="container-fluid" style="background-color: rgba(0, 0, 0, 0.2); padding: 15em 0;">
    <div class="row no-gutters slider-text align-items-center justify-content-center">
      <div class="col-md-10 ftco-animate text-center">
        <p class="breadcrumbs"><span class="mr-2"><a href="<?= base_url() ?>"><?= lang('Home.nav.home'); ?></a></span> <span><?= lang('Home.nav.cart'); ?></span>
        </p>
        <h1 class="mb-0 display-3 text-light"><?= lang('Home.nav.cart'); ?></h1>
      </div>
    </div>
  </div>
</div>

<section class="ftco-section ftco-cart">
  <div class="container">
    <div class="row">
      <div class="col-md-12 ftco-animate">
        <div class="cart-list">
          <table class="table">
            <thead class="thead-primary">
              <tr class="text-center">
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th><?= lang('Home.productName'); ?></th>
                <th><?= lang('Home.price'); ?></th>
                <th><?= lang('Home.quantity'); ?></th>
                <th><?= lang('Home.total'); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php if ($cart) : ?>
                <?php foreach ($cart as $product) : ?>
                  <tr class="text-center">
                    <td class="product-remove">
                      <form action="<?= base_url('/cart/delete') ?>" method="POST">
                        <?= csrf_field(); ?>

                        <input type="hidden" name="rowid" value="<?= $product['rowid']; ?>">
                        <button type="submit" class="form-control" style="cursor: pointer;">
                          <span class="ion-ios-close"></span>
                        </button>
                      </form>
                    </td>

                    <td class="image-prod">
                      <div class="img" style="background-image:url(<?= base_url('/images/product-images/' . $product['options']['image']) ?>);">
                      </div>
                    </td>

                    <td class="product-name">
                      <h3><?= $product['name']; ?></h3>
                    </td>

                    <td class="price">Rp
                      <?= number_format($product['price'], 0, ',', '.') ?></td>

                    <td class="quantity">
                      <form action="<?= base_url('/cart/update') ?>" method="POST">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="rowid" value="<?= $product['rowid']; ?>">

                        <div class="input-group mb-3">
                          <input type="number" name="quantity" class="quantity form-control input-number" value="<?= $product['qty']; ?>" min="1" max="<?= $product['options']['domestic_stock']; ?>">
                        </div>
                        <button type="submit" class="btn btn-primary py-2"><?= lang('Home.save'); ?></button>
                      </form>
                    </td>

                    <td class="total">
                      Rp
                      <?= number_format($product['price'] * $product['qty'], 0, ',', '.') ?>
                    </td>
                  </tr><!-- END TR-->
                <?php endforeach; ?>

              <?php else : ?>
                <tr class="text-center">
                  <td class="product-name">
                    <h4><?= lang('Home.cartEmpty'); ?></h4>
                  </td>
                </tr>
              <?php endif; ?>

            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="row justify-content-end">
      <div class="col-lg-5 mt-5 cart-wrap ftco-animate">
        <div class="cart-total mb-3">
          <h3><?= lang('Home.cartTotal'); ?></h3>
          <p class="d-flex">
            <span><?= lang('Home.subtotal'); ?></span>
            <span class="text-right">
              Rp <?= number_format($subtotal, 0, ',', '.') ?>
            </span>
          </p>
          <hr>
          <p class="d-flex total-price">
            <span><?= lang('Home.total'); ?></span>
            <span class="text-right">
              Rp <?= number_format($subtotal, 0, ',', '.') ?>
            </span>
          </p>
        </div>
        <p class="text-center">
          <a href="<?= base_url('/checkout') ?>" class="btn btn-primary py-3 px-4">
            <?= lang('Home.proceedCheckout'); ?>
          </a>
        </p>
      </div>
    </div>
  </div>
</section>

<?= $this->endSection(); ?>