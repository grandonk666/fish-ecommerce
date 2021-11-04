<?= $this->extend('layouts/userTemplate'); ?>

<?= $this->section('content'); ?>

<main id="main">
  <section class="intro-single">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-lg-8">
          <div class="title-single-box">
            <h1 class="title-single"><?= lang('Auth.loginTitle') ?></h1>
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

          <form action="<?= route_to('login') ?>" method="post" role="form" class="login-form">
            <?= csrf_field() ?>

            <?php if ($config->validFields === ['email']) : ?>
              <div class="form-group mb-3">
                <label for="login" class="form-label">
                  <h4 class="icon-title"><?= lang('Auth.email') ?></h4>
                </label>
                <input type="email" name="login" class="form-control form-control-lg form-control-a <?= ((session('errors.login'))) ? 'is-invalid' : '' ?>" placeholder="<?= lang('Auth.email') ?>" required id="login" />
                <div class="invalid-feedback">
                  <?= session('errors.login') ?>
                </div>
              </div>

            <?php else : ?>
              <div class="form-group mb-3">
                <label for="login" class="form-label">
                  <h4 class="icon-title"><?= lang('Auth.emailOrUsername') ?></h4>
                </label>
                <input type="text" name="login" class="form-control form-control-lg form-control-a <?= ((session('errors.login'))) ? 'is-invalid' : '' ?>" placeholder="<?= lang('Auth.emailOrUsername') ?>" required id="login" />
                <div class="invalid-feedback">
                  <?= session('errors.login') ?>
                </div>
              </div>

            <?php endif; ?>

            <div class="form-group mb-3">
              <label for="password" class="form-label">
                <h4 class="icon-title"><?= lang('Auth.password') ?></h4>
              </label>
              <input type="password" name="password" class="form-control form-control-lg form-control-a <?= ((session('errors.password'))) ? 'is-invalid' : '' ?>" placeholder="<?= lang('Auth.password') ?>" required id="password" />
              <div class="invalid-feedback">
                <?= session('errors.password') ?>
              </div>
            </div>

            <?php if ($config->allowRemembering) : ?>
              <div class="form-group">
                <input type="checkbox" class="form-check-input" id="remember" <?= (old('remember')) ? 'checked' : '' ?> name="remember">
                <label class="form-check-label" for="remember">Remember
                  Me</label>
              </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-a"><?= lang('Auth.loginAction') ?></button>
          </form>

          <?php if ($config->activeResetter) : ?>
            <div class="text-center">
              <a class="link-three" href="<?= route_to('forgot') ?>"><?= lang('Auth.forgotYourPassword') ?></a>
            </div>
          <?php endif; ?>

          <?php if ($config->allowRegistration) : ?>
            <div class="text-center">
              <a class="link-three" href="<?= route_to('register') ?>"><?= lang('Auth.needAnAccount') ?></a>
            </div>
          <?php endif; ?>

        </div>
      </div>
    </div>
  </section>

</main>
<!-- End #main -->

<?= $this->endSection(); ?>