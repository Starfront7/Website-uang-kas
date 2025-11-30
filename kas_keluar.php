<?php
session_start();
include 'koneksi.php';

// delete
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM kas_keluar WHERE id=$id");
    header('Location: kas_keluar.php'); exit;
}

// add
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = mysqli_real_escape_string($koneksi, $_POST['tanggal']);
    $jumlah = (int)$_POST['jumlah'];
    $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);
    mysqli_query($koneksi, "INSERT INTO kas_keluar (tanggal,jumlah,keterangan) VALUES ('$tanggal',$jumlah,'$keterangan')");
    header('Location: kas_keluar.php'); exit;
}

$res = mysqli_query($koneksi, "SELECT * FROM kas_keluar ORDER BY tanggal DESC");
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Kas Keluar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Uang Kas</a>
            <div class="d-flex">
                <a href="index.php" class="btn btn-sm btn-danger">kembali</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h4>Kas Keluar</h4>
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <form method="post">
                            <div class="mb-2"><label>Tanggal</label><input type="date" name="tanggal"
                                    class="form-control" required></div>
                            <div class="mb-2"><label>Jumlah</label><input type="number" name="jumlah"
                                    class="form-control" required></div>
                            <div class="mb-2"><label>Keterangan</label><input name="keterangan" class="form-control">
                            </div>
                            <button class="btn btn-primary">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; while($r=mysqli_fetch_assoc($res)): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $r['tanggal'] ?></td>
                            <td><?= number_format($r['jumlah']) ?></td>
                            <td><?= htmlspecialchars($r['keterangan']) ?></td>
                            <td><a class="btn btn-sm btn-danger" href="?hapus=<?= $r['id'] ?>"
                                    onclick="return confirm('Yakin?')">Hapus</a></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>