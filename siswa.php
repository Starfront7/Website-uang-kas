<?php
session_start();
// tidak cek login lagi

include 'koneksi.php';

// handle delete
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM siswa WHERE id=$id");
    header('Location: siswa.php'); exit;
}

// add or edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $nis = mysqli_real_escape_string($koneksi, $_POST['nis']);
    $jk = mysqli_real_escape_string($koneksi, $_POST['jk']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    if (!empty($_POST['id'])) {
        $id = (int)$_POST['id'];
        mysqli_query($koneksi, "UPDATE siswa SET nama='$nama', nis='$nis', jk='$jk', alamat='$alamat' WHERE id=$id");
    } else {
        mysqli_query($koneksi, "INSERT INTO siswa (nama,nis,jk,alamat) VALUES ('$nama','$nis','$jk','$alamat')");
    }
    header('Location: siswa.php'); exit;
}

$res = mysqli_query($koneksi, "SELECT * FROM siswa ORDER BY nama");
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Data Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Uang Kas</a>
            <div class="d-flex">
                <a href="index.php" class="btn btn-sm btn-danger">Kembali</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h4>Data Siswa</h4>
        <div class="row">
            <div class="col-md-5">
                <div class="card mb-3">
                    <div class="card-body">
                        <form method="post">
                            <input type="hidden" name="id" id="fid">
                            <div class="mb-2"><label>Nama</label><input name="nama" id="fnama" class="form-control"
                                    required></div>
                            <div class="mb-2"><label>NIS</label><input name="nis" id="fnis" class="form-control"></div>
                            <div class="mb-2"><label>Jenis Kelamin</label>
                                <select name="jk" id="fjk" class="form-control">
                                    <option value="L">L</option>
                                    <option value="P">P</option>
                                </select>
                            </div>
                            <div class="mb-2"><label>Alamat</label><textarea name="alamat" id="falamat"
                                    class="form-control"></textarea></div>
                            <button class="btn btn-primary">Simpan</button>
                            <button type="button" onclick="resetForm()" class="btn btn-secondary">Reset</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>NIS</th>
                            <th>JK</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; while($r=mysqli_fetch_assoc($res)): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= htmlspecialchars($r['nama']) ?></td>
                            <td><?= htmlspecialchars($r['nis']) ?></td>
                            <td><?= $r['jk'] ?></td>
                            <td>
                                <button class="btn btn-sm btn-warning"
                                    onclick='edit(<?=json_encode($r)?>)'>Edit</button>
                                <a class="btn btn-sm btn-danger" href="?hapus=<?= $r['id'] ?>"
                                    onclick="return confirm('Yakin?')">Hapus</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
    function edit(r) {
        document.getElementById('fid').value = r.id;
        document.getElementById('fnama').value = r.nama;
        document.getElementById('fnis').value = r.nis;
        document.getElementById('fjk').value = r.jk;
        document.getElementById('falamat').value = r.alamat;
    }

    function resetForm() {
        document.getElementById('fid').value = '';
        document.getElementById('fnama').value = '';
        document.getElementById('fnis').value = '';
        document.getElementById('fjk').value = 'L';
        document.getElementById('falamat').value = '';
    }
    </script>

</body>

</html>