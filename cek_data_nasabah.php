<?php session_start();

include 'db.php';
include 'sanitasi.php';

 $id = angkadoang($_GET['id']);
 

 $query = $db->query("SELECT p.kode_pelanggan,p.nama_pelanggan,p.jurusan,j.nama FROM pelanggan p INNER JOIN jurusan j ON p.jurusan = j.id WHERE p.id = '$id' ");
 $data = mysqli_fetch_array($query);


 echo json_encode($data);



        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
  ?>


