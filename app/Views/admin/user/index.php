<?= $this->extend('layouts/adminTemplate'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid p-0">
  <h1 class="h3 mb-3"><?= $title; ?></h1>

  <div class="row">
    <div class="col-12 col-lg-10 col-xxl-10">

      <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <div class="alert-message">
            <?= session()->getFlashdata('pesan'); ?>
          </div>
        </div>
      <?php endif; ?>


      <div class="card">
        <table class="table">
          <thead>
            <tr>
              <th style="width: 25%">Nama</th>
              <th style="width: 35%">Email</th>
              <th style="width: 10%">Role</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($users as $user) : ?>
              <tr>
                <td><?= $user->name; ?></td>
                <td>
                  <?= $user->email; ?>
                </td>
                <td>
                  <?php if ($user->id == user_id()) : ?>
                    <span class="text-uppercase badge bg-secondary">
                      Current User
                    </span>
                  <?php else : ?>
                    <span class="text-uppercase badge <?= ($user->getRoles()[0]['name'] == 'admin') ? 'bg-primary' : 'bg-success' ?>">
                      <?= $user->getRoles()[0]['name']; ?>
                    </span>
                  <?php endif; ?>
                </td>
                <td class="table-action">
                  <?php if ($user->id != user_id()) : ?>
                    <?php if ($user->getRoles()[0]['name'] == 'user') : ?>

                      <form action="<?= base_url("/admin/user/role/" . $user->id); ?>" method="post" class="d-none d-xl-inline">
                        <?= csrf_field(); ?>

                        <input type="hidden" name="role" value="admin">
                        <button class="btn btn-sm btn-info" type="submit">Set to Admin</button>
                      </form>

                    <?php else : ?>

                      <form action="<?= base_url("/admin/user/role/" . $user->id); ?>" method="post" class="d-none d-xl-inline">
                        <?= csrf_field(); ?>

                        <input type="hidden" name="role" value="user">
                        <button class="btn btn-sm btn-success" type="submit">Set to Regular User</button>
                      </form>

                    <?php endif; ?>
                  <?php endif; ?>

                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>