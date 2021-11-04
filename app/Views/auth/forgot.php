<?= $this->extend('layouts/userTemplate'); ?>

<?= $this->section('content'); ?>

<main id="main">
  <section class="intro-single">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-lg-8">
          <div class="title-single-box">
            <h1 class="title-single"><?= lang('Auth.forgotPassword') ?></h1>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="contact">
    <div class="container">
      <div class="row">
        <div class="col-md-7">

          <?= view('Myth\Auth\Views\_message_block') ?>

          <p><?= lang('Auth.enterEmailForInstructions') ?></p>

          <form action="<?= route_to('forgot') ?>" method="post" role="form" class="login-form">
            <?= csrf_field() ?>

            <div class="form-group mb-3">
              <label for="email" class="form-label">
                <h4 class="icon-title"><?= lang('Auth.emailAddress') ?></h4>
              </label>
              <input type="email" name="email" class="form-control form-control-lg form-control-a <?= ((session('errors.email'))) ? 'is-invalid' : '' ?>" placeholder="<?= lang('Auth.email') ?>" required id="email" />
              <div class="invalid-feedback">
                <?= session('errors.email') ?>
              </div>
            </div>

            <button type="submit" class="btn btn-a"><?= lang('Auth.sendInstructions') ?></button>
          </form>

        </div>
      </div>
    </div>
  </section>

</main>
<!-- End #main -->

<?= $this->endSection(); ?>