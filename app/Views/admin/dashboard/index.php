<?= $this->extend('layouts/adminTemplate'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid p-0">
  <div class="row">
    <div class="col-md-5">
      <h1 class="h3 mb-3"><?= $title; ?></h1>
    </div>
  </div>

  <div class="row">
    <div class="col-xl-3 col-xxl-2 d-flex">
      <div class="w-100">
        <div class="row">
          <div class="col-md-3 col-xl-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title mb-2">Jumlah Kamar</h5>
                <h1 class="mb-0"><?= $total_kamar; ?></h1>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-xl-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title mb-2">Jumlah Ruangan</h5>
                <h1 class="mb-0"><?= $total_ruangan; ?></h1>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-xl-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title mb-2">Pendapatan</h5>
                <h1 class="mb-0">Rp <?= number_format($total_pendapatan, '0', '', '.'); ?></h1>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-xl-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title mb-2">Order</h5>
                <h1 class="mb-0"><?= $total_order; ?></h1>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-9 col-xxl-10">
      <div class="card flex-fill w-100 py-2">
        <div class="card-header">
          <h5 class="card-title mb-0">Transaksi</h5>
        </div>
        <div class="card-body">
          <div class="chart chart-lg">
            <canvas id="grafik-transaksi-line"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12 col-lg-8 d-flex">
      <div class="card flex-fill">
        <div class="card-header">
          <h5 class="card-title mb-0">Transaksi Terakhir</h5>
        </div>
        <table class="table table-hover my-0">
          <thead>
            <tr>
              <th>Nama Pesanan</th>
              <th class="d-none d-xl-table-cell">Nama Pemesan</th>
              <th class="d-none d-xl-table-cell">Total</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($transaksi_terakhir as $transaksi) : ?>
              <tr>
                <td><?= $transaksi['item_name']; ?></td>
                <td class="d-none d-xl-table-cell"><?= $transaksi['customer_name']; ?></td>
                <td class="d-none d-xl-table-cell"><?= $transaksi['gross_amount']; ?></td>
                <td>
                  <span class="badge bg-<?= $transaksi['badge']; ?>"><?= $transaksi['transaction_status']; ?></span>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
    <div class="col-12 col-lg-4 d-flex">
      <div class="card flex-fill w-100">
        <div class="card-header">

          <h5 class="card-title mb-0">Tipe Pembayaran</h5>
        </div>
        <div class="card-body d-flex">
          <div class="align-self-center w-100">
            <div class="py-3">
              <div class="chart chart-xs">
                <canvas id="tipe-grafik-pie"></canvas>
              </div>
            </div>

            <table class="table mb-0">
              <tbody>
                <?php $badge = ['primary', 'danger', 'success']; ?>
                <?php for ($i = 0; $i < count($tipe_grafik['tipe']); $i++) : ?>
                  <tr>
                    <td><?= $tipe_grafik['tipe'][$i]; ?></td>
                    <td class="text-right"><span class="badge bg-<?= $badge[$i]; ?>"><?= $tipe_grafik['total'][$i]; ?></span></td>
                  </tr>
                <?php endfor; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">

    <div class="col-12 col-lg-12 d-flex">
      <div class="card flex-fill w-100">
        <div class="card-header">

          <h5 class="card-title mb-0">Order Berdasarkan Kamar</h5>
        </div>
        <div class="card-body d-flex w-100">
          <div class="align-self-center chart chart-lg">
            <canvas id="kamar-grafik-bar"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>


<script defer>
  document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById("grafik-transaksi-line").getContext("2d");
    var gradient = ctx.createLinearGradient(0, 0, 0, 225);
    gradient.addColorStop(0, "rgba(215, 227, 244, 1)");
    gradient.addColorStop(1, "rgba(215, 227, 244, 0)");
    // Line chart
    new Chart(document.getElementById("grafik-transaksi-line"), {
      type: "line",
      data: {
        labels: <?= json_encode($trx_grafik['month']); ?>,
        datasets: [{
          label: "Transaction ($)",
          fill: true,
          // lineTension: 0,
          backgroundColor: gradient,
          borderColor: window.theme.primary,
          data: <?= json_encode($trx_grafik['total']); ?>
        }]
      },
      options: {
        maintainAspectRatio: false,
        legend: {
          display: false
        },
        tooltips: {
          intersect: false
        },
        hover: {
          intersect: true
        },
        plugins: {
          filler: {
            propagate: false
          }
        },
        scales: {
          xAxes: [{
            reverse: true,
            gridLines: {
              color: "rgba(0,0,0,0.0)"
            }
          }],
          yAxes: [{
            ticks: {
              stepSize: 1000,
              // beginAtZero: true
            },
            display: true,
            borderDash: [3, 3],
            gridLines: {
              color: "rgba(0,0,0,0.0)"
            }
          }]
        }
      }
    });
  });
</script>

<script defer>
  document.addEventListener("DOMContentLoaded", function() {
    // Pie chart
    new Chart(document.getElementById("tipe-grafik-pie"), {
      type: "pie",
      data: {
        labels: <?= json_encode($tipe_grafik['tipe']); ?>,
        datasets: [{
          data: <?= json_encode($tipe_grafik['total']); ?>,
          backgroundColor: [
            window.theme.primary,
            window.theme.danger,
            window.theme.success
          ],
          borderWidth: 5
        }]
      },
      options: {
        responsive: !window.MSInputMethodContext,
        maintainAspectRatio: false,
        legend: {
          display: false
        },
        cutoutPercentage: 75
      }
    });
  });
</script>

<script defer>
  document.addEventListener("DOMContentLoaded", function() {
    // Bar chart
    new Chart(document.getElementById("kamar-grafik-bar"), {
      type: "bar",
      data: {
        labels: <?= json_encode($kamar_grafik['kamar']); ?>,
        datasets: [{
          label: "This year",
          backgroundColor: window.theme.primary,
          borderColor: window.theme.primary,
          hoverBackgroundColor: window.theme.primary,
          hoverBorderColor: window.theme.primary,
          data: <?= json_encode($kamar_grafik['total']); ?>,
          barPercentage: .75,
          categoryPercentage: .5
        }]
      },
      options: {
        maintainAspectRatio: false,
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            gridLines: {
              display: false
            },
            stacked: false,
            ticks: {
              stepSize: 20
            }
          }],
          xAxes: [{
            stacked: false,
            gridLines: {
              color: "transparent"
            }
          }]
        }
      }
    });
  });
</script>

<?= $this->endSection(); ?>