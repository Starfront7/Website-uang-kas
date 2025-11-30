<?php
session_start();
// tidak cek login lagi

include 'koneksi.php';

// totals
$masuk = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COALESCE(SUM(jumlah),0) AS total FROM kas_masuk"));
$keluar = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COALESCE(SUM(jumlah),0) AS total FROM kas_keluar"));
$saldo = $masuk['total'] - $keluar['total'];

?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Dashboard - Uang Kas Kelas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Uang Kas</a>
            <div class="d-flex">
                <a href="siswa.php" class="btn btn-sm btn-light me-2">Siswa</a>
                <a href="kas_masuk.php" class="btn btn-sm btn-light me-2">Kas Masuk</a>
                <a href="kas_keluar.php" class="btn btn-sm btn-light me-2">Kas Keluar</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h3>Dashboard</h3>
        <div class="row">
            <div class="col-md-4">
                <div class="card text-bg-success mb-3">
                    <div class="card-body">
                        <h5>Total Masuk</h5>
                        <h3>Rp <?= number_format($masuk['total']) ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-bg-danger mb-3">
                    <div class="card-body">
                        <h5>Total Keluar</h5>
                        <h3>Rp <?= number_format($keluar['total']) ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-bg-info mb-3">
                    <div class="card-body">
                        <h5>Saldo</h5>
                        <h3>Rp <?= number_format($saldo) ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h5>Grafik Masuk per Bulan</h5>
                <canvas id="chartMasuk"></canvas>
            </div>
        </div>

    </div>

    <script>
    fetch('grafik.php')
        .then(res => res.json())
        .then(data => {
            new Chart(document.getElementById('chartMasuk'), {
                type: 'bar',
                data: {
                    labels: data.bulan,
                    datasets: [{
                        label: 'Total Masuk',
                        data: data.total
                    }]
                }
            });
        });
    </script>

</body>

</html>