<?php session_start();
include 'sanitasi.php';
include 'db.php';

$session_id = $_POST['session_id'];
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:s');

$tahun_terakhir = substr($tahun_sekarang, 2);

$tanggal = stringdoang($_POST['tanggal']);

        $keterangan = stringdoang($_POST['keterangan']);
        $dari_akun = stringdoang($_POST['dari_akun']);
        $ke_akun = stringdoang($_POST['ke_akun']);
        $jumlah = angkadoang($_POST['jumlah']);
        $user = $_SESSION['user_name'];

$select = $db->query("SELECT jurusan FROM pelanggan WHERE id = '$dari_akun'");
$out = mysqli_fetch_array($select);
$jurusan = $out['jurusan'];

	$perintah = $db->prepare("INSERT INTO tbs_penyetoran (session_id,keterangan,dari_akun,ke_akun, jumlah,tanggal,jam,user,jurusan) VALUES (?,?,?,?,?,?,?,?,?)");

	$perintah->bind_param("ssssissss",
	$session_id, $keterangan, $dari_akun, $ke_akun, $jumlah, $tanggal_sekarang, $jam_sekarang, $user, $jurusan);
        
        $perintah->execute();
        

if (!$perintah) {
   die('Query Error : '.$db->errno.
   ' - '.$db->error);
}
else {

}
    
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    ?>