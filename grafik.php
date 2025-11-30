<?php
include 'koneksi.php';
$q = mysqli_query($koneksi,
  "SELECT DATE_FORMAT(tanggal, '%Y-%m') AS bulan, COALESCE(SUM(jumlah),0) AS total
   FROM kas_masuk
   GROUP BY YEAR(tanggal), MONTH(tanggal)
   ORDER BY bulan"
);
$bulan=[]; $total=[];
while($r=mysqli_fetch_assoc($q)){
  $bulan[] = $r['bulan'];
  $total[] = (int)$r['total'];
}
echo json_encode(['bulan'=>$bulan,'total'=>$total]);
?>