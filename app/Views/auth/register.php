<?= $this->extend('layouts/userTemplate'); ?>

<?= $this->section('content'); ?>

<main id="main">
  <section class="intro-single">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-lg-8">
          <div class="title-single-box">
            <h1 class="title-single"><?= lang('Auth.register') ?></h1>
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

          <form action="<?= route_to('register') ?>" method="post" role="form" class="login-form">
            <?= csrf_field() ?>

            <div class="form-group mb-3">
              <label for="login" class="form-label">
                <h4 class="icon-title"><?= lang('Auth.email') ?></h4>
              </label>
              <input type="email" name="email" class="form-control form-control-lg form-control-a <?= ((session('errors.email'))) ? 'is-invalid' : '' ?>" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" required id="login" />
              <small id="emailHelp" class="form-text text-muted"><?= lang('Auth.weNeverShare') ?></small>
            </div>

            <div class="form-group mb-3">
              <label for="username" class="form-label">
                <h4 class="icon-title"><?= lang('Auth.username') ?></h4>
              </label>
              <input type="text" name="username" class="form-control form-control-lg form-control-a <?= ((session('errors.username'))) ? 'is-invalid' : '' ?>" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>" required id="username" />
            </div>


            <div class="form-group mb-3">
              <label for="password" class="form-label">
                <h4 class="icon-title"><?= lang('Auth.password') ?></h4>
              </label>
              <input type="password" name="password" class="form-control form-control-lg form-control-a <?= ((session('errors.password'))) ? 'is-invalid' : '' ?>" placeholder="<?= lang('Auth.password') ?>" required id="password" autocomplete="off" />
            </div>

            <div class="form-group mb-3">
              <label for="pass_confirm" class="form-label">
                <h4 class="icon-title"><?= lang('Auth.repeatPassword') ?></h4>
              </label>
              <input type="password" name="pass_confirm" class="form-control form-control-lg form-control-a <?= ((session('errors.pass_confirm'))) ? 'is-invalid' : '' ?>" placeholder="<?= lang('Auth.repeatPassword') ?>" required id="pass_confirm" autocomplete="off" />
            </div>

            <button type="submit" class="btn btn-a"><?= lang('Auth.register') ?></button>
          </form>

          <div class="text-center">
            <p><?= lang('Auth.alreadyRegistered') ?> <a class="link-three" href="<?= route_to('login') ?>"><?= lang('Auth.signIn') ?></a></p>
          </div>

        </div>
      </div>
    </div>
  </section>

</main>
<!-- End #main -->

<?= $this->endSection(); ?>