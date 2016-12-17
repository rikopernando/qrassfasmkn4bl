<?php 
include 'db.php';
include 'sanitasi.php';
$jurusan = stringdoang($_POST['jurusan']);

// START hitungan jumlah uang penyetoran dan penarikan
$a = $db->query("SELECT SUM(jumlah) AS total_tabungan FROM detail_penyetoran WHERE jurusan = '$jurusan' ");
$as = mysqli_fetch_array($a);

$b = $db->query("SELECT SUM(jumlah) AS total_tabungan1 FROM detail_penarikan WHERE jurusan = '$jurusan' ");
$ab = mysqli_fetch_array($b);


 echo $hasil_next = $as['total_tabungan'] - $ab['total_tabungan1'];
 // END hitungan jumlah uang penyetoran dan penarikan


 ?>