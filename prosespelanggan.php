<?php 
    //memasukkan file db.php
    
    include 'db.php';
    include 'sanitasi.php';
    //mengirim data sesuai variabel dengan menggunakan metode POST




$perintah = $db->prepare("INSERT INTO pelanggan (kode_pelanggan, nama_pelanggan, no_telp, e_mail, tgl_lahir, wilayah, level_harga,jurusan) VALUES (?,?,?,?,?,?,?,?)");

$perintah->bind_param("ssssssss",
$kode_pelanggan, $nama_pelanggan, $no_telp, $e_mail, $tgl_lahir, $wilayah, $level_harga, $jurusan);
        
        $kode_pelanggan = stringdoang($_POST['kode_pelanggan']);
        $nama_pelanggan = stringdoang($_POST['nama_pelanggan']);
        $level_harga = stringdoang($_POST['level_harga']);
        $tgl_lahir = stringdoang($_POST['tgl_lahir']);
        $no_telp = stringdoang($_POST['no_telp']);
        $e_mail = stringdoang($_POST['e_mail']);
        $wilayah = stringdoang($_POST['wilayah']);
        $jurusan = stringdoang($_POST['jurusan']);

    $perintah->execute();



    
if (!$perintah) 
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