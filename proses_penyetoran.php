<?php session_start();

include 'sanitasi.php';
include 'db.php';
    
$session_id = $_POST['session_id'];

$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:s');
$tahun_terakhir = substr($tahun_sekarang, 2);
$waktu = date('Y-m-d H:i:s');


//mengecek jumlah karakter dari bulan sekarang
$cek_jumlah_bulan = strlen($bulan_sekarang);

//jika jumlah karakter dari bulannya sama dengan 1 maka di tambah 0 di depannya
if ($cek_jumlah_bulan == 1) {
  # code...
  $data_bulan_terakhir = "0".$bulan_sekarang;
 }
 else
 {
  $data_bulan_terakhir = $bulan_sekarang;

 }

//ambil bulan dari tanggal penjualan terakhir

 $bulan_terakhir = $db->query("SELECT MONTH(tanggal) as bulan FROM penyetoran ORDER BY id DESC LIMIT 1");
 $v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);

//ambil nomor  dari penjualan terakhir
$no_terakhir = $db->query("SELECT no_faktur FROM penyetoran ORDER BY id DESC LIMIT 1");
 $v_no_terakhir = mysqli_fetch_array($no_terakhir);
$ambil_nomor = substr($v_no_terakhir['no_faktur'],0,-8);

/*jika bulan terakhir dari penjualan tidak sama dengan bulan sekarang, 
maka nomor nya kembali mulai dari 1 ,
jika tidak maka nomor terakhir ditambah dengan 1
 
 */
 if ($v_bulan_terakhir['bulan'] != $bulan_sekarang) {
  # code...
echo $no_faktur = "1/INP/".$data_bulan_terakhir."/".$tahun_terakhir;

 }

 else
 {

$nomor = 1 + $ambil_nomor ;

echo $no_faktur = $nomor."/INP/".$data_bulan_terakhir."/".$tahun_terakhir;


 }

    $perintah = $db->prepare("INSERT INTO penyetoran (no_faktur,keterangan,ke_akun,jumlah,tanggal,jam,user) VALUES (?,?,?,?,?,?,?)");

    $perintah->bind_param("sssisss",
        $no_faktur, $keterangan, $ke_akun , $jumlah, $tanggal_sekarang, $jam_sekarang, $user);

    $keterangan = stringdoang($_POST['keterangan']);
    $ke_akun = stringdoang($_POST['ke_akun']);
    $jumlah = angkadoang($_POST['jumlah']);  
    $user = $_SESSION['user_name'];

    $perintah->execute();



    $query = $db->prepare("UPDATE kas SET jumlah = jumlah + ? WHERE nama = ?");
    
    $query->bind_param("is", 
    $jumlah, $ke_akun);

    $jumlah = angkadoang($_POST['jumlah']);
    $ke_akun = stringdoang($_POST['ke_akun']);
    
    $query->execute();

if (!$perintah) {
   die('Query Error : '.$db->errno.
   ' - '.$db->error);
}
else {


}

    $query1 = $db->query("SELECT * FROM tbs_penyetoran WHERE session_id = '$session_id'");

    while ($data=mysqli_fetch_array($query1)) {

    $query2 = $db->query("INSERT INTO detail_penyetoran (no_faktur,keterangan,dari_akun,ke_akun,jumlah,tanggal,jam,user,waktu ) VALUES ('$no_faktur','$data[keterangan]','$data[dari_akun]','$data[ke_akun]','$data[jumlah]','$data[tanggal]','$data[jam]','$data[user]','$waktu')");
    
    }


    $query3 = $db->query("DELETE FROM tbs_penyetoran WHERE session_id = '$session_id'");
 

 //Untuk Memutuskan Koneksi Ke Database
 mysqli_close($db);   

    ?>