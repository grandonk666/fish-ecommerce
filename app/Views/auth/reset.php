<?= $this->extend('layouts/userTemplate'); ?>

<?= $this->section('content'); ?>

<main id="main">
  <section class="intro-single">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-lg-8">
          <div class="title-single-box">
            <h1 class="title-single"><?= lang('Auth.resetYourPassword') ?></h1>
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

          <p><?= lang('Auth.enterCodeEmailPassword') ?></p>

          <form action="<?= route_to('reset-password') ?>" method="post" role="form" class="login-form">
            <?= csrf_field() ?>

            <div class="form-group mb-3">
              <label for="token" class="form-label">
                <h4 class="icon-title"><?= lang('Auth.token') ?></h4>
              </label>
              <input type="text" name="token" class="form-control form-control-lg form-control-a <?= ((session('errors.token'))) ? 'is-invalid' : '' ?>" value="<?= old('token', $token ?? '') ?>" required id="token" />
              <div class="invalid-feedback">
                <?= session('errors.token') ?>
              </div>
            </div>

            <div class="form-group mb-3">
              <label for="email" class="form-label">
                <h4 class="icon-title"><?= lang('Auth.email') ?></h4>
              </label>
              <input type="email" name="email" class="form-control form-control-lg form-control-a <?= ((session('errors.email'))) ? 'is-invalid' : '' ?>" value="<?= old('email') ?>" required id="email" />
              <div class="invalid-feedback">
                <?= session('errors.email') ?>
              </div>
            </div>


            <div class="form-group mb-3">
              <label for="password" class="form-label">
                <h4 class="icon-title"><?= lang('Auth.newPassword') ?></h4>
              </label>
              <input type="password" name="password" class="form-control form-control-lg form-control-a <?= ((session('errors.password'))) ? 'is-invalid' : '' ?>" required id="password" autocomplete="off" />
              <div class="invalid-feedback">
                <?= session('errors.password') ?>
              </div>
            </div>

            <div class="form-group mb-3">
              <label for="pass_confirm" class="form-label">
                <h4 class="icon-title"><?= lang('Auth.newPasswordRepeat') ?></h4>
              </label>
              <input type="password" name="pass_confirm" class="form-control form-control-lg form-control-a <?= ((session('errors.pass_confirm'))) ? 'is-invalid' : '' ?>" required id="pass_confirm" autocomplete="off" />
              <div class="invalid-feedback">
                <?= session('errors.pass_confirm') ?>
              </div>
            </div>

            <button type="submit" class="btn btn-a"><?= lang('Auth.resetPassword') ?></button>
          </form>

        </div>
      </div>
    </div>
  </section>

</main>
<!-- End #main -->

<?= $this->endSection(); ?>