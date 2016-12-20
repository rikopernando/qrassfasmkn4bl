<?php 
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=data_lap_tabungan_nasabah.xls");

include 'db.php';
include 'sanitasi.php';


$dari_tgl = stringdoang($_GET['dari_tanggal']);
$sampai_tgl = stringdoang($_GET['sampai_tanggal']);
$no_rek = stringdoang($_GET['id_nasabah']);


$select = $db->query("SELECT tanggal,jumlah,kode, jam,waktu FROM detail_penyetoran WHERE tanggal >= '$dari_tgl' AND tanggal <= '$sampai_tgl' AND dari_akun = '$no_rek' UNION SELECT tanggal,jumlah,kode, jam,waktu FROM detail_penarikan WHERE tanggal >= '$dari_tgl' AND tanggal <= '$sampai_tgl' AND ke_akun = '$no_rek' ORDER BY waktu ASC ");

$qwr = $db->query("SELECT p.kode_pelanggan,p.nama_pelanggan,j.nama FROM pelanggan p INNER JOIN jurusan j ON p.jurusan = j.id WHERE p.id = '$no_rek' ");
$asdfqw = mysqli_fetch_array($qwr);

 ?>


<div class="container">

<table style="color:blue;">
	<tbody>
		<tr><center><h3><b>Transaksi Tabungan</b></h3></center></tr>
		<tr><td><b>No Rekening</b></td> <td>=</td> <td><b><?php echo $asdfqw['kode_pelanggan']; ?></b></td> </tr>
		<tr><td><b>Nama Penabung</b></td> <td>=</td> <td><b><?php echo $asdfqw['nama_pelanggan'] ?></b></td> </tr>
		<tr><td><b>Jurusan</b></td> <td>=</td> <td><b><?php echo $asdfqw['nama']; ?></b></td> </tr>
	</tbody>
</table>
</b>
</h3>
    <table id="kartu_stok" class="table table-bordered">

        <!-- membuat nama kolom tabel -->
        <thead>

      <th style='background-color: #4CAF50; color:white'> Tanggal </th>
      <th style='background-color: #4CAF50; color:white'> Jam </th>
      <th style='background-color: #4CAF50; color:white'> Kode </th>
      <th style='background-color: #4CAF50; color:white'> Setoran </th>
      <th style='background-color: #4CAF50; color:white'> Penarikan </th>
      <th style='background-color: #4CAF50; color:white'> Saldo</th>

</thead>
<tbody>

<?php 

$qweasf = $db->query("SELECT SUM(jumlah) AS total_tabungan FROM detail_penyetoran WHERE dari_akun = '$no_rek' AND waktu <= '$dari_tgl'  ");
$ghjui = mysqli_fetch_array($qweasf);

$loip = $db->query("SELECT SUM(jumlah) AS total_tabungan1 FROM detail_penarikan WHERE ke_akun = '$no_rek' AND waktu <= '$dari_tgl' ");
$ccc = mysqli_fetch_array($loip);

// akhir hitungan saldo awal

 $total_saldo_awal = $ghjui['total_tabungan'] - $ccc['total_tabungan1'];
//untuk menentukan saldo awal 
        //menampilkan data
      echo "<tr>
      <td></td>
      <td></td>
      <td><p style='color:red'>SALDO AWAL</p>   </td>
      <td></td>
      <td></td>
     <td><p style='color:red'>".$total_saldo_awal."</p></td>
     </tr>";

while($data1 = mysqli_fetch_array($select))
	{

        $asdas = $db->query("SELECT SUM(jumlah) AS total_tabungan FROM detail_penyetoran WHERE dari_akun = '$no_rek' AND waktu <= '$data1[waktu]' ");
$fasf = mysqli_fetch_array($asdas);

$qweqw = $db->query("SELECT SUM(jumlah) AS total_tabungan1 FROM detail_penarikan WHERE ke_akun = '$no_rek' AND waktu <= '$data1[waktu]' ");
$asd = mysqli_fetch_array($qweqw);


    
 $total = $fasf['total_tabungan'] - $asd['total_tabungan1'];

        //menampilkan data
      echo "<tr>
      <td>". $data1['tanggal'] ."</td>
      <td>". $data1['jam'] ."</td>
      <td>". $data1['kode'] ."</td>";      
    if ($data1["kode"] == 1) {
    echo"<td>". rp($data1["jumlah"])." </td>
        <td></td>";

    }
    else
    {

    echo"<td></td>
    <td>". rp($data1["jumlah"])." </td>";

    }
     echo"<td>".rp($total)."</td>";
      echo "</tr>";
      }
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 
?>
        </tbody>
    </table>      

</div> <!--Closed Container-->



