<?php 
include 'db.php';
include 'sanitasi.php';

$jurusan = stringdoang($_POST['jurusan']);

$select = $db->query("SELECT nama FROM jurusan WHERE id = '$jurusan'");
$show = mysqli_fetch_array($select);

echo $nama = $show['nama'];
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 
        
        

?>