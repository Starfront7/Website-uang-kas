<?php
session_start();
// tidak cek login lagi

include 'koneksi.php';

$type = isset($_GET['type']) ? $_GET['type'] : '';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=laporan_'.($type?:'export').'_'.date('Ymd').'.csv');

$out = fopen('php://output', 'w');
if ($type=='siswa' && isset($_GET['siswa_id'])) {
    $siswa_id = (int)$_GET['siswa_id'];
    fputcsv($out, ['Tanggal','Jumlah','Keterangan']);
    $q = mysqli_query($koneksi, "SELECT tanggal,jumlah,keterangan FROM kas_masuk WHERE siswa_id=$siswa_id ORDER BY tanggal");
    while($r=mysqli_fetch_assoc($q)) fputcsv($out, [$r['tanggal'],$r['jumlah'],$r['keterangan']]);
} elseif ($type=='date' && isset($_GET['from']) && isset($_GET['to'])) {
    $from = $_GET['from']; $to = $_GET['to'];
    fputcsv($out, ['Tipe','Tanggal','Nama','Jumlah','Keterangan']);
    $qin = mysqli_query($koneksi, "SELECT k.tanggal,s.nama,k.jumlah,k.keterangan FROM kas_masuk k LEFT JOIN siswa s ON k.siswa_id=s.id WHERE k.tanggal BETWEEN '$from' AND '$to' ORDER BY k.tanggal");
    while($r=mysqli_fetch_assoc($qin)) fputcsv($out, ['Masuk',$r['tanggal'],$r['nama'],$r['jumlah'],$r['keterangan']]);
    $qout = mysqli_query($koneksi, "SELECT tanggal,jumlah,keterangan FROM kas_keluar WHERE tanggal BETWEEN '$from' AND '$to' ORDER BY tanggal");
    while($r=mysqli_fetch_assoc($qout)) fputcsv($out, ['Keluar',$r['tanggal'],'-',$r['jumlah'],$r['keterangan']]);
} else {
    // default: export semua pemasukan
    fputcsv($out, ['Tanggal','Nama','Jumlah','Keterangan']);
    $q = mysqli_query($koneksi, "SELECT k.tanggal,s.nama,k.jumlah,k.keterangan FROM kas_masuk k LEFT JOIN siswa s ON k.siswa_id=s.id ORDER BY k.tanggal");
    while($r=mysqli_fetch_assoc($q)) fputcsv($out, [$r['tanggal'],$r['nama'],$r['jumlah'],$r['keterangan']]);
}
fclose($out);
exit;