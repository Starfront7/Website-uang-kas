<?php
session_start();
// tidak cek login lagi

include 'koneksi.php';

$siswa_id = isset($_GET['siswa_id']) ? (int)$_GET['siswa_id'] : 0;
$res_siswa = mysqli_query($koneksi, "SELECT * FROM siswa ORDER BY nama");
$data = [];
if ($siswa_id) {
    $q = mysqli_query($koneksi, "SELECT k.*, s.nama FROM kas_masuk k LEFT JOIN siswa s ON k.siswa_id=s.id WHERE s.id=$siswa_id ORDER BY k.tanggal DESC");
    while($r=mysqli_fetch_assoc($q)) $data[] = $r;
}
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan per Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h4>Laporan Pembayaran per Siswa</h4>
        <form class="row g-2 mb-3">
            <div class="col-auto">
                <select name="siswa_id" class="form-control" onchange="this.form.submit()">
                    <option value="">-- Pilih Siswa --</option>
                    <?php while($s=mysqli_fetch_assoc($res_siswa)): ?>
                    <option value="<?= $s['id'] ?>" <?= ($s['id']==$siswa_id)?'selected':'' ?>>
                        <?= htmlspecialchars($s['nama']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-auto"><a class="btn btn-secondary" href="laporan_siswa.php">Reset</a></div>
            <div class="col-auto"><a class="btn btn-success"
                    href="export_csv.php?type=siswa&siswa_id=<?= $siswa_id ?>">Export CSV</a></div>
        </form>

        <?php if ($siswa_id): ?>
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
                <?php $i=1; foreach($data as $r): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= $r['tanggal'] ?></td>
                    <td><?= number_format($r['jumlah']) ?></td>
                    <td><?= htmlspecialchars($r['keterangan']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="alert alert-info">Pilih siswa untuk melihat laporan.</div>
        <?php endif; ?>
    </div>
</body>

</html>