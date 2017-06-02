<?php
include 'sanitasi.php';
include 'db.php';


$username = stringdoang($_POST['username']);
$password_baru = enkripsi($_POST['password_baru']);



$query = $db->prepare("UPDATE pelanggan SET password = ? WHERE nama_pelanggan = ?");

$query->bind_param("ss",
	$password_baru, $username);

$query->execute();



    if (!$query) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else 
    {
    echo "sukses";
    }

        //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

?>