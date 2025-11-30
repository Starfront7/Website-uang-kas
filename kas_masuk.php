<?php
session_start();
// tidak cek login lagi

include 'koneksi.php';

// delete
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM kas_masuk WHERE id=$id");
    header('Location: kas_masuk.php'); exit;
}

// add
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $siswa_id = (int)$_POST['siswa_id'];
    $tanggal = mysqli_real_escape_string($koneksi, $_POST['tanggal']);
    $jumlah = (int)$_POST['jumlah'];
    $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);
    mysqli_query($koneksi, "INSERT INTO kas_masuk (siswa_id,tanggal,jumlah,keterangan) VALUES ($siswa_id,'$tanggal',$jumlah,'$keterangan')");
    header('Location: kas_masuk.php'); exit;
}

$siswa_res = mysqli_query($koneksi, "SELECT * FROM siswa ORDER BY nama");
$res = mysqli_query($koneksi, "SELECT m.*, s.nama FROM kas_masuk m LEFT JOIN siswa s ON m.siswa_id=s.id ORDER BY m.tanggal DESC");
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Kas Masuk</title>
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
        <h4>Kas Masuk</h4>
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <form method="post">
                            <div class="mb-2"><label>Siswa</label>
                                <select name="siswa_id" class="form-control" required>
                                    <option value="">-- pilih --</option>
                                    <?php while($s=mysqli_fetch_assoc($siswa_res)): ?>
                                    <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['nama']) ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
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
                            <th>Nama</th>
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
                            <td><?= htmlspecialchars($r['nama']) ?></td>
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