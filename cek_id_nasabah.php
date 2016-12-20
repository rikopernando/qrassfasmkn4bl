<?php 
include 'sanitasi.php';
include 'db.php';

$no_rek = stringdoang($_POST['no_rek']);

$query = $db->query("SELECT id FROM pelanggan WHERE kode_pelanggan = '$no_rek'");
$jumlah = mysqli_fetch_array($query);

echo$jumlah['id']; 
        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
 ?>

