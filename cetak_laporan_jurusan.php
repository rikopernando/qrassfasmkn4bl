<?php session_start();

include 'header.php';
include 'db.php';
include 'sanitasi.php';
$tanggal = date('Y-m-d');

$jurusan = stringdoang($_GET['jurusan']);

$select = $db->query("SELECT * FROM perusahaan ");
$out = mysqli_fetch_array($select);

$select = $db->query("SELECT * FROM pelanggan WHERE jurusan = '$jurusan'");

$show_jurusan = $db->query("SELECT nama FROM jurusan WHERE id = '$jurusan'");
$out = mysqli_fetch_array($show_jurusan);
$nama_jurusan = $out['nama'];
 ?>
 <div class="container">

    <div class="row"><!--row1-->
        <div class="col-sm-2">
                <img src='save_picture/<?php echo $data1['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='80' height='80`'> 
        </div><!--penutup col foto-->

        <div class="col-sm-8">
                 <center> <h3> <b> <?php echo $data1['nama_perusahaan']; ?> </b> </h3> 
                 <p> <?php echo $data1['alamat_perusahaan']; ?><br>
                  No.Telp:<?php echo $data1['no_telp']; ?> </p> </center>
                 
        </div><!--penutup col nama perusahaan-alamat-&-notelp-->
        
    </div><!--penutup row1-->


    <center> <h4> <b> Saldo Tabungan (<?php echo $nama_jurusan ?>) </b> </h4> </center>

<br>	
<div class="table-responsive">
<span id="show_table"><!--span untuk table-->       
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
			
		?>
      </tbody>
     </table>
</span><!--akhir span untuk table-->
</div><!--end responsive-->
<br>

<?php 
// START hitungan jumlah uang penyetoran dan penarikan
$a = $db->query("SELECT SUM(jumlah) AS total_tabungan FROM detail_penyetoran WHERE jurusan = '$jurusan' ");
$as = mysqli_fetch_array($a);

$b = $db->query("SELECT SUM(jumlah) AS total_tabungan1 FROM detail_penarikan WHERE jurusan = '$jurusan' ");
$ab = mysqli_fetch_array($b);


 $hasil_next = $as['total_tabungan'] - $ab['total_tabungan1'];
 // END hitungan jumlah uang penyetoran dan penarikan

 ?>

<div class="row">
		<div class="col-sm-6">
		<table>
		<tbody>

       <tr><td width="50%"><font class="satu"> Tanggal</td> <td> :&nbsp;&nbsp;</td> <td><?php echo tanggal($tanggal);?></font> </td></tr> 

      <tr><td width="50%"><font class="satu">Total Saldo</font></td> <td> :&nbsp;</td> <td><font class="satu"><b>Rp. <?php echo rp($hasil_next) ?> </b></font></tr>

      <tr><td width="50%"><font class="satu"><i>Terbilang</i></font></td> <td> :&nbsp;</td> <td><font class="satu"><b><i><?php echo kekata($hasil_next); ?></i></b> </font> </tr>
     

  		</tbody>
		</table>
		
		</div>

		<div class="col-sm-6">
		</div>
</div>
<br>
<br>

	<div class="col-sm-2">
    </div> 

    <div class="col-sm-3">
    <font class="satu"><b>Penerima<br><br><br>
    <font class="satu">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</font></b>
    </font>
    </div>

    <div class="col-sm-4">
    </div> 

    <div class="col-sm-3">
    <font class="satu"><b>Petugas<br><br><br>
    	<font class="satu"><?php echo $_SESSION['nama']; ?></font></b>
    </font
    </div> 
	

 </div><!--penutup Countainer-->
     
 <script>
$(document).ready(function(){
  window.print();
});
</script>