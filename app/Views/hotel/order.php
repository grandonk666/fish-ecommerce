<?= $this->extend('layouts/userTemplate'); ?>

<?= $this->section('content'); ?>

<main id="main">
  <section class="intro-single">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-lg-8">
          <div class="title-single-box">
            <h1 class="title-single">Input your prsonal data</h1>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="contact">
    <div class="container">
      <div class="row">
        <div class="col-md-7">

          <div class="title-box-d section-t4">
            <h2 class="title-d intro-title"><?= $kamar['nama']; ?> Room</h2>
          </div>

          <form action="<?= base_url('/payment/' . $kamar['slug']); ?>" method="post" role="form">
            <?= csrf_field() ?>


            <div class="form-group mb-4">
              <label for="first-name" class="form-label">
                <h4 class="icon-title">First Name</h4>
              </label>
              <input type="text" name="first-name" class="form-control form-control-lg form-control-a <?= ($validation->hasError('first-name')) ? 'is-invalid' : ''; ?>" placeholder="Input your first name" required id="first-name" value="<?= old('first-name') ?? user()->firstname; ?>" />
              <div class="invalid-feedback">
                <?= $validation->getError('first-name'); ?>
              </div>
            </div>

            <div class="form-group mb-4">
              <label for="last-name" class="form-label">
                <h4 class="icon-title">Last Name</h4>
              </label>
              <input type="text" name="last-name" class="form-control form-control-lg form-control-a <?= ($validation->hasError('last-name')) ? 'is-invalid' : ''; ?>" placeholder="Input your last name" required id="last-name" value="<?= old('last-name') ?? user()->lastname; ?>" />
              <div class="invalid-feedback">
                <?= $validation->getError('last-name'); ?>
              </div>
            </div>

            <div class="form-group mb-4">
              <label for="email" class="form-label">
                <h4 class="icon-title">Email</h4>
              </label>
              <input type="email" name="email" class="form-control form-control-lg form-control-a <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" placeholder="Input your email" required id="email" value="<?= old('email') ?? user()->email; ?>" />
              <small class="form-text text-muted">We will send notification and payment detail to your email</small>
              <div class="invalid-feedback">
                <?= $validation->getError('email'); ?>
              </div>
            </div>

            <div class="form-group mb-4">
              <label for="phone" class="form-label">
                <h4 class="icon-title">Phone Number</h4>
              </label>
              <input type="phone" name="phone" class="form-control form-control-lg form-control-a <?= ($validation->hasError('phone')) ? 'is-invalid' : ''; ?>" placeholder="Input your phone number" required id="phone" value="<?= old('phone') ?? user()->phone; ?>" />
              <div class="invalid-feedback">
                <?= $validation->getError('phone'); ?>
              </div>
            </div>

            <div class="form-group mb-4">
              <label for="ruangan" class="form-label">
                <h4 class="icon-title">Select Available Rooms</h4>
              </label>
              <select class="form-control form-select form-control-a" name="ruangan" id="ruangan" required>
                <option selected disabled>Select Available Rooms</option>
                <?php foreach ($ruangan_tersedia as $ruangan) : ?>
                  <option value="<?= $ruangan['id']; ?>">Room No. <?= $ruangan['nomor_ruangan']; ?></option>
                <?php endforeach; ?>
              </select>
              <div class="invalid-feedback">
                <?= $validation->getError('kamar'); ?>
              </div>
            </div>

            <button type="submit" class="btn btn-b me-4">NEXT</button>
            <a href="<?= base_url('/rooms/' . $kamar['slug']) ?>" class="btn btn-a">CANCEL</a>
          </form>

        </div>
      </div>
    </div>
  </section>

</main>
<!-- End #main -->

<?= $this->endSection(); ?>