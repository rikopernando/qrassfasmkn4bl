<?php session_start();

    //memasukkan file db.php
    include 'sanitasi.php';
    include 'db.php';

$session_id = $_POST['session_id'];
$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:s');
$tahun_terakhir = substr($tahun_sekarang, 2);
$tanggal = stringdoang($_POST['tanggal']);
$waktu = $tanggal." ".$jam_sekarang;
//mengirim data sesuai dengan variabel denagn metode POST 
        $keterangan = stringdoang($_POST['keterangan']);
        $dari_akun = stringdoang($_POST['dari_akun']);
        $ke_akun = stringdoang($_POST['ke_akun']);
        $jumlah = angkadoang($_POST['jumlah']);
        $user = $_SESSION['user_name'];

$select = $db->query("SELECT jurusan FROM pelanggan WHERE id = '$ke_akun'");
$out = mysqli_fetch_array($select);
$jurusan = $out['jurusan'];

// buat prepared statements
$stmt = $db->prepare("INSERT INTO tbs_penarikan (session_id,keterangan,dari_akun,
      ke_akun,jumlah,tanggal,jam,user,jurusan) VALUES (?,?,?,?,?,?,?,?,?)");

// hubungkan "data" dengan prepared statements
$stmt->bind_param("ssssissss", 
$session_id, $keterangan, $dari_akun, $ke_akun, $jumlah, $tanggal, $jam_sekarang, $user, $jurusan);        
        
// siapkan "data" query
        

// jalankan query
        $stmt->execute();
        

        
if (!$stmt) {
   die('Query Error : '.$db->errno.
   ' - '.$db->error);
}


  //menampilkan semua data yang ada pada tabel tbs kas keluar dalam DB

    $perintah = $db->query("SELECT km.id, km.session_id, km.no_faktur, km.keterangan, km.ke_akun, km.dari_akun, km.jumlah, km.tanggal, km.jam, km.user, da.nama_pelanggan,da.kode_pelanggan,da.id AS id_pelanggan,daf.nama_daftar_akun FROM tbs_penarikan km INNER JOIN pelanggan da ON km.ke_akun = da.id INNER JOIN daftar_akun daf ON km.dari_akun = daf.kode_daftar_akun WHERE km.session_id = '$session_id' AND da.id = '$ke_akun' ");

      //menyimpan data sementara yang ada pada $perintah

     $data1 = mysqli_fetch_array($perintah);

  echo "<tr class='tr-id-".$data1['id']."' >
      <td>". $data1['nama_daftar_akun'] ."</td>
      <td data-dari-akun ='(". $data1['kode_pelanggan'] .") ". $data1['nama_pelanggan'] ."'>(". $data1['kode_pelanggan'] .") ". $data1['nama_pelanggan'] ."</td>

      <td class='edit-jumlah' data-id='".$data1['id']."'><span id='text-jumlah-".$data1['id']."'>". rp($data1['jumlah']) ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah']."' class='input-jumlah' data-id='".$data1['id']."' data-ke_akun='".$data1['ke_akun']."' autofocus='' data-jumlah='".$data1['jumlah']."'  onkeydown='return numbersonly(this, event);' onkeyup='javascript:tandaPemisahTitik(this);'> </td>

      <td>". $data1['tanggal'] ."</td>
      <td>". $data1['jam'] ."</td>
      <td>". $data1['keterangan'] ."</td>
      <td>". $data1['user'] ."</td>

      <td> <button class='btn btn-danger btn-sm btn-hapus-tbs' id='btn-hapus-".$data1['id']."' data-id='". $data1['id'] ."' data-jumlah='". $data1['jumlah'] ."' data-dari='". $data1['dari_akun'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button>  </td> 
      
      </tr>";
    
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    ?>
