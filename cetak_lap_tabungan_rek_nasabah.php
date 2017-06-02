<?php session_start();

include 'header.php';
include 'sanitasi.php';
include 'db.php';

$dari_tgl = stringdoang($_GET['dari_tanggal']);
$sampai_tgl = stringdoang($_GET['sampai_tanggal']);
$no_rek = stringdoang($_GET['id_nasabah']);


$select_one = $db->query("SELECT tanggal,jumlah,kode, jam,waktu FROM detail_penyetoran WHERE tanggal >= '$dari_tgl' AND tanggal <= '$sampai_tgl' AND dari_akun = '$no_rek' UNION SELECT tanggal,jumlah,kode, jam,waktu FROM detail_penarikan WHERE tanggal >= '$dari_tgl' AND tanggal <= '$sampai_tgl' AND ke_akun = '$no_rek' ORDER BY waktu ASC ");

$query1 = $db->query("SELECT * FROM perusahaan ");
$next_cp = mysqli_fetch_array($query1);
    
$qwr = $db->query("SELECT p.kode_pelanggan,p.nama_pelanggan,j.nama FROM pelanggan p INNER JOIN jurusan j ON p.jurusan = j.id WHERE p.id = '$no_rek' ");
$asdfqw = mysqli_fetch_array($qwr);

$select = $db->query("SELECT SUM(jumlah) AS total_tabungan FROM detail_penyetoran WHERE dari_akun = '$no_rek' ");
$jumlah = mysqli_fetch_array($select);

$select1 = $db->query("SELECT SUM(jumlah) AS total_tabungan1 FROM detail_penarikan WHERE ke_akun = '$no_rek' ");
$jumlah1 = mysqli_fetch_array($select1);


 $total_saldo = $jumlah['total_tabungan'] - $jumlah1['total_tabungan1'];
 ?>
<style type="text/css">
/*unTUK mengatur ukuran font*/
   .satu {
   font-size: 15px;
   font: verdana;
   }
</style>


<div class="container">
    
    <div class="row"><!--row1-->
        <div class="col-sm-2">
                <img src='save_picture/<?php echo $next_cp['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='130' height='130`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-8">
                 <center> <h4> <b> <?php echo $next_cp['nama_perusahaan']; ?> </b> </h4> 
                 <p> <?php echo $next_cp['alamat_perusahaan']; ?><br>
                  No.Telp:<?php echo $next_cp['no_telp']; ?> </p> </center>
                 
        </div><!--penutup colsm5-->
        
    </div><!--penutup row1-->



    <center> <h4> <b> Laporan Saldo Tabungan</b> </h4> </center>
<br>

  <div class="row">
    <div class="col-sm-9">
        

 <table>
  <tbody>
      <tr><td width="25%"><font class="satu">No Rekening</font></td> <td> :&nbsp;</td> <td><font class="satu"><?php echo $asdfqw['kode_pelanggan']; ?></font> </tr>

      <tr><td  width="25%"><font class="satu">Nama Penabung</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo $asdfqw['nama_pelanggan']; ?> </font></td></tr>

      <tr><td  width="25%"><font class="satu">Jurusan</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo $asdfqw['nama']; ?> </font></td></tr>
         

  </tbody>
</table>


    </div>

   </div> <!--end row-->  




<style type="text/css">
  th,td{
    padding: 1px;
  }


.table1, .th, .td {
    border: 1px solid black;
    font-size: 15px;
    font: verdana;
}


</style>
<br><br>

<table id="tableuser" class="table table-bordered table-sm">
    <thead>
       
      <th> Tanggal </th>
      <th> Jam </th>
      <th> Kode </th>
      <th> Setoran </th>
      <th> Penarikan </th>
      <th> Saldo </th>
      
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
      


      while ($data1 = mysqli_fetch_array($select_one))
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
   <i><p> * Kode <br> 1.Penabungan <br> 2. Penarikan </p></i>

<br>

    <div class="row">
      <div class="col-sm-6">
              <font class="satu"><b>Nasabah <br><br><br><br> <font class="satu"><?php echo $_SESSION['nama_pelanggan']; ?></font></b></font> 
      </div>
         <div class="col-sm-3">



        </div> <!--/ col-sm-6-->


         <div class="col-sm-3">
        
          <label style="height: 25px; width:90%; font-size:20px;"> Total Saldo</label>
            <b><input type="text" style="height: 25px; width:90%; font-size:20px;" class="form-control" id="total_saldo" autocomplete="off" name="total_saldo" readonly="" value="<?php echo rp($total_saldo) ?>"></b>
        
        <i><b><font class="satu">Terbilang :</font></b> <?php echo kekata($total); ?> rupiah </i><br>

        </div> <!--/ col-sm-6-->
    </div>
    





</div> <!--/container-->


 <script>
$(document).ready(function(){
  window.print();
});
</script>



<?php include 'footer.php'; ?>