<?php
session_start();
// tidak cek login lagi

include 'koneksi.php';

$from = isset($_GET['from']) ? $_GET['from'] : date('Y-m-01');
$to = isset($_GET['to']) ? $_GET['to'] : date('Y-m-d');

$q_in = mysqli_query($koneksi, "SELECT * FROM kas_masuk WHERE tanggal BETWEEN '$from' AND '$to' ORDER BY tanggal");
$q_out = mysqli_query($koneksi, "SELECT * FROM kas_keluar WHERE tanggal BETWEEN '$from' AND '$to' ORDER BY tanggal");
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan per Tanggal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h4>Laporan Kas per Tanggal</h4>
        <form class="row g-2 mb-3">
            <div class="col-auto"><input type="date" name="from" value="<?= $from ?>" class="form-control"></div>
            <div class="col-auto"><input type="date" name="to" value="<?= $to ?>" class="form-control"></div>
            <div class="col-auto"><button class="btn btn-primary">Filter</button></div>
            <div class="col-auto"><a class="btn btn-success"
                    href="export_csv.php?type=date&from=<?= $from ?>&to=<?= $to ?>">Export CSV</a></div>
        </form>

        <h5>Pemasukan</h5>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Siswa</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; while($r=mysqli_fetch_assoc($q_in)): ?>
                <?php $s = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT nama FROM siswa WHERE id=".(int)$r['siswa_id'])); ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= $r['tanggal'] ?></td>
                    <td><?= htmlspecialchars($s['nama'] ?? '-') ?></td>
                    <td><?= number_format($r['jumlah']) ?></td>
                    <td><?= htmlspecialchars($r['keterangan']) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h5>Pengeluaran</h5>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php $j=1; while($r=mysqli_fetch_assoc($q_out)): ?>
                <tr>
                    <td><?= $j++ ?></td>
                    <td><?= $r['tanggal'] ?></td>
                    <td><?= number_format($r['jumlah']) ?></td>
                    <td><?= htmlspecialchars($r['keterangan']) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>