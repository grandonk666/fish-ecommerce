<?= $this->extend('layouts/adminTemplate'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid p-0">
  <h1 class="h3 mb-3"><?= $title; ?></h1>

  <div class="row">
    <div class="col-12 col-lg-9 col-xxl-9">

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
              <th style="width: 30%">Nama</th>
              <th style="width: 30%">Email</th>
              <th style="width: 10%">Role</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($user as $u) : ?>
              <tr>
                <td><?= $u->name; ?></td>
                <td>
                  <?= $u->email; ?>
                </td>
                <td>
                  <span class="badge <?= ($u->getRoles()[0]['name'] == 'admin') ? 'bg-primary' : 'bg-success' ?>">
                    <?= $u->getRoles()[0]['name']; ?>
                  </span>
                </td>
                <td class="table-action">
                  <a href="<?= base_url("/admin/user/" . $u->id); ?>" class="btn btn-outline"><i class="align-middle" data-feather="eye"></i></a>
                  <form action="<?= base_url("/admin/user/" . $u->id); ?>" method="post" class="d-inline">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button class="btn btn-outline" type="submit" onclick="return confirm('Anda yakin ?');"><i class="align-middle" data-feather="trash"></i></button>
                  </form>

                  <?php if ($u->getRoles()[0]['name'] == 'user') : ?>

                    <form action="<?= base_url("/admin/user/role/" . $u->id); ?>" method="post" class="d-none d-xl-inline">
                      <?= csrf_field(); ?>

                      <input type="hidden" name="role" value="admin">
                      <button class="btn btn-sm btn-info" type="submit">Set to Admin</button>
                    </form>

                  <?php else : ?>

                    <form action="<?= base_url("/admin/user/role/" . $u->id); ?>" method="post" class="d-none d-xl-inline">
                      <?= csrf_field(); ?>

                      <input type="hidden" name="role" value="user">
                      <button class="btn btn-sm btn-success" type="submit">Set to User</button>
                    </form>

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