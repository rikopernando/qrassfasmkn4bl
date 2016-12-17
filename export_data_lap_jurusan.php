<?php 
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=data_tabungan_jurusan.xls");

include 'db.php';
include 'sanitasi.php';

$jurusan = stringdoang($_GET['jurusan']);

$select = $db->query("SELECT * FROM pelanggan WHERE jurusan = '$jurusan'");

$show_jurusan = $db->query("SELECT nama FROM jurusan WHERE id = '$jurusan'");
$out = mysqli_fetch_array($show_jurusan);
$nama_jurusan = $out['nama'];
 ?>


<div class="container">
 	
<div class="table-responsive">
<span id="show_table"><!--span untuk table-->  
<h3>Data Tabungan Jurusan (<?php echo $nama_jurusan ?>)</h3>

    <table id="table_hasil" class="table table-bordered">
      <thead>
      <th style='background-color: #4CAF50; color:white'> <center>No</center> </th>
      <th style='background-color: #4CAF50; color:white'> No Rekening </th>
      <th style='background-color: #4CAF50; color:white'> Nama Nasabah</th>
      <th style='background-color: #4CAF50; color:white'> Jurusan </th>
      <th style='background-color: #4CAF50; color:white'> Saldo </th>
            
       </thead>

        <tbody>
            <?php
$no_urut = 0;
			//menyimpan data sementara yang ada pada $query
			while ($data = mysqli_fetch_array($select))
			{
				//menampilkan data
		$select_jurusan = $db->query("SELECT nama FROM jurusan WHERE id = '$data[jurusan]'");
        $taked = mysqli_fetch_array($select_jurusan);


// START hitungan jumlah uang penyetoran dan penarikan
$select_setoran = $db->query("SELECT SUM(jumlah) AS total_tabungan FROM detail_penyetoran WHERE dari_akun = '$data[id]' ");
$jumlah_setor = mysqli_fetch_array($select_setoran);

$select_penarikan = $db->query("SELECT SUM(jumlah) AS total_tabungan1 FROM detail_penarikan WHERE ke_akun = '$data[id]' ");
$jumlah_tarik = mysqli_fetch_array($select_penarikan);


 $total = $jumlah_setor['total_tabungan'] - $jumlah_tarik['total_tabungan1'];
 // END hitungan jumlah uang penyetoran dan penarikan
 $no_urut ++;
			echo "<tr>
			<td class='table1' align='center'>".$no_urut."</td>
			<td>". $data['kode_pelanggan'] ."</td>
			<td>". $data['nama_pelanggan'] ."</td>
			<td>". $taked['nama'] ."</td>
			<td>".rp($total)."</td>";


			echo "</tr>";

	
} // and while

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
			
		?>
      </tbody>
     </table>
</span><!--akhir span untuk table-->
</div><!--end responsive-->
<br>

<?php 
include 'db.php';
// START hitungan jumlah uang penyetoran dan penarikan
$a = $db->query("SELECT SUM(jumlah) AS total_tabungan FROM detail_penyetoran WHERE jurusan = '$jurusan' ");
$as = mysqli_fetch_array($a);

$b = $db->query("SELECT SUM(jumlah) AS total_tabungan1 FROM detail_penarikan WHERE jurusan = '$jurusan' ");
$ab = mysqli_fetch_array($b);

 $hasil_next = $as['total_tabungan'] - $ab['total_tabungan1'];
 // END hitungan jumlah uang penyetoran dan penarikan
 ?>

<h4><b>Total Saldo Rp. <?php echo rp($hasil_next) ?></b></h4>


</div><!--container end-->