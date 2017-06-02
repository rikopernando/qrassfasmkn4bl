<?php include 'session_login.php';


// memsukan file session login, header,navbar dan db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


//menampilkan seluruh data yang ada pada tabel pelanggan
$query = $db->query("SELECT * FROM pelanggan");

 ?>

<div class="container"> <!-- start of container -->
<h3><b>DATA NASABAH</b></h3> <hr>
<!-- Trigger the modal with a button -->

<?php 

include 'db.php';

$pilih_akses_pelanggan = $db->query("SELECT pelanggan_tambah FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND pelanggan_tambah = '1'");
$pelanggan = mysqli_num_rows($pilih_akses_pelanggan);


    if ($pelanggan > 0){

    	echo '<button type="button" class="btn btn-info " data-toggle="modal" data-target="#myModal"> <i class="fa fa-plus"> </i> Nasabah</button>';

    }

 ?>

<br>
<br>


<!-- Modal tambah data -->
<div id="myModal" class="modal fade" role="dialog">
  	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Tambah Data Pelanggan</h4>
      </div>
    <div class="modal-body">
<form role="form">
		<div class="form-group">
					
					<label> No Rekening </label><br>
					<input type="text" name="kode_pelanggan" id="kode_pelanggan" class="form-control" autocomplete="off" required="" >
					

					<label> Nama Nasabah </label><br>
					<input type="text" name="nama" id="nama_pelanggan" class="form-control" autocomplete="off" required="" >

					<label> Tanggal Lahir </label><br>
					<input type="text" name="tgl_lahir" id="tgl_lahir" class="form-control" autocomplete="off" required="" >

					<label> Nomor Telp </label><br>
					<input type="text" name="nomor" id="nomor" class="form-control" autocomplete="off" required="" >
					

					<label> E Mail </label><br>
					<input type="text" name="email" id="email" class="form-control" autocomplete="off" required="" >
					

					<label> Wilayah </label><br>
					<input type="text" name="wilayah" id="wilayah" class="form-control" autocomplete="off" required="" >

					<label> Kelas </label><br>
					<select type="text" name="level_harga" id="level_harga" class="form-control" required="" >
					<option value="">--SILAKAN PILIH--</option>
					<option>Kelas X</option>
					<option>Kelas XI</option>
					<option>Kelas XII</option>
					</select>

				
				<label> Jurusan </label><br>
				<select  type="text" name="jurusan" id="jurusan" class="form-control"
				required="">
				<option value="Tidak Ada">Tidak Ada</option>
          			<?php 
          			 $jurme = $db->query("SELECT id,nama FROM jurusan");
          			 while($outin = mysqli_fetch_array($jurme))
          			 {
          			 echo "<option value='".$outin['id']."'>".$outin['nama'] ."</option>";
          			 }
          			?>
          		</select>
          		

					<br>
					<button type="submit" id="submit_tambah" class="btn btn-success">Submit</button>

		</div>
</form>

				
					<div class="alert alert-success" style="display:none">
					<strong>Berhasil!</strong> Data berhasil Di Tambah
					</div>

 	</div><!-- end of modal body -->

					<div class ="modal-footer">
					<button type ="button"  class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
	</div>
	</div>

</div><!-- end of modal buat data  -->


<!-- modal import-->
<div id="my_Modal" class="modal fade" role="dialog">
  <div class="modal-dialog">



    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Import Data Excell</h4>
      </div>

      <div class="modal-body">
   
   
   <form enctype="multipart/form-data" action="proses_import_pelanggan.php?" method="post" >
    <div class="form-group">
        <label> Import Data Excell</label>
        <input type="file" id="file_import" name="import_excell" required=""> 
        <br>
        <br>

        <!-- membuat tombol submit -->
        
         
    </div>
   <button type="submit" name="submit" value="submit" class="btn btn-info">Import</button>
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

    <div class="modal-footer">

    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

    </div>
    </div>

  </div>
</div>

<!--end modal import-->



  <!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">



    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmasi Hapus Data Nasabah</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nama Nasabah :</label>
     <input type="text" id="data_pelanggan" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_hapus"> <span class='glyphicon glyphicon-ok-sign'> </span>Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"> <span class='glyphicon glyphicon-remove-sign'> </span>Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->


<!-- Modal edit data -->
<div id="modal_edit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Data Nasabah</h4>
      </div>
      <div class="modal-body">
  <form role="form">
					<div class="form-group">
					<label> No Rekening </label><br>
					<input type="text" name="kode_edit" id="edit_kode" class="form-control" autocomplete="off" required="" >
						
					<label> Nama Nasabah </label><br>
					<input type="text" name="nama_edit" id="edit_nama" class="form-control" autocomplete="off" required="" >

					<label> Tanggal Lahir </label><br>
					<input type="text" name="tgl_lahir" id="edit_tgl_lahir" class="form-control" autocomplete="off" required="" >

					<label> Nomor Telp </label><br>
					<input type="text" name="nomor" id="edit_nomor" class="form-control" autocomplete="off" required="" >					

					<label> E Mail </label><br>
					<input type="text" name="email" id="edit_email" class="form-control" autocomplete="off" required="" >
					

					<label> Wilayah </label><br>
					<input type="text" name="wilayah" id="edit_wilayah" class="form-control" autocomplete="off" required="" >

					<label> Kelas </label><br>
					<select type="text" name="edit_level_harga" id="edit_level_harga" class="form-control" required="" >
					<option>Kelas X</option>
					<option>Kelas XI</option>
					<option>Kelas XII</option>
					</select>
					

				<label> Jurusan </label><br>
				<select  type="text" name="edit_jurusan" id="edit_jurusan" class="form-control"
				required="">
				<option value="Tidak Ada">Tidak Ada</option>
          			<?php 
          			 $jurme = $db->query("SELECT id,nama FROM jurusan");
          			 while($outin = mysqli_fetch_array($jurme))
          			 {
          			 echo "<option value='".$outin['id']."'>".$outin['nama'] ."</option>";
          			 }
          			?>
          		</select>

    			<input type="hidden" class="form-control" id="id_edit">
    
   </div>
   					<button type="submit" id="submit_edit" class="btn btn-success">Submit</button>
   					</div>
  </form>
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data Berhasil Di Edit
  </div>
 

    
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div><!-- end of modal edit data  -->


<style>

tr:nth-child(even){background-color: #f2f2f2}


</style>


<div class="table-responsive"><!-- membuat agar ada garis pada tabel, disetiap kolom -->
<span id="table_baru">
<table id="tableuser" class="table table-bordered table-sm">
		<thead>
			
			<th style='background-color: #4CAF50; color: white'> No Rekening </th>
			<th style='background-color: #4CAF50; color: white'> Nama Nasabah </th>
			<th style='background-color: #4CAF50; color: white'> Kelas </th>
			<th style='background-color: #4CAF50; color: white'> Tgl. Lahir </th>
			<th style='background-color: #4CAF50; color: white'> Nomor Telp </th>
			<th style='background-color: #4CAF50; color: white'> E-mail </th>
			<th style='background-color: #4CAF50; color: white'> Wilayah</th>
			<th style='background-color: #4CAF50; color: white'> Jurusan</th>
			<th style='background-color: #4CAF50; color: white'> Saldo</th>
<?php 

include 'db.php';

$pilih_akses_pelanggan_hapus = $db->query("SELECT pelanggan_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND pelanggan_hapus = '1'");
$pelanggan_hapus = mysqli_num_rows($pilih_akses_pelanggan_hapus);


    if ($pelanggan_hapus > 0){

			echo "<th style='background-color: #4CAF50; color: white'> Hapus </th>";

		}
?>


<?php 
include 'db.php';

$pilih_akses_pelanggan_edit = $db->query("SELECT pelanggan_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND pelanggan_edit = '1'");
$pelanggan_edit = mysqli_num_rows($pilih_akses_pelanggan_edit);


    if ($pelanggan_edit > 0){
    	echo "<th style='background-color: #4CAF50; color: white'> Edit </th>";
    }

 ?>
			
			
		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $query
			while ($data = mysqli_fetch_array($query))
			{
				//menampilkan data
		$select_jurusan = $db->query("SELECT nama FROM jurusan WHERE id = '$data[jurusan]'");
        $taked = mysqli_fetch_array($select_jurusan);

$select = $db->query("SELECT SUM(jumlah) AS total_tabungan FROM detail_penyetoran WHERE dari_akun = '$data[id]' ");
$jumlah = mysqli_fetch_array($select);

$select1 = $db->query("SELECT SUM(jumlah) AS total_tabungan1 FROM detail_penarikan WHERE ke_akun = '$data[id]' ");
$jumlah1 = mysqli_fetch_array($select1);


 $total = $jumlah['total_tabungan'] - $jumlah1['total_tabungan1'];
			echo "<tr>
			
			<td>". $data['kode_pelanggan'] ."</td>
			<td>". $data['nama_pelanggan'] ."</td>
			<td>". $data['level_harga'] ."</td>
			<td>". tanggal($data['tgl_lahir']) ."</td>
			<td>". $data['no_telp'] ."</td>
			<td>". $data['e_mail'] ."</td>
			<td>". $data['wilayah'] ."</td>
			<td>". $taked['nama'] ."</td>
			<td>".rp($total)."</td>";
			


include 'db.php';

$pilih_akses_pelanggan_hapus = $db->query("SELECT pelanggan_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND pelanggan_hapus = '1'");
$pelanggan_hapus = mysqli_num_rows($pilih_akses_pelanggan_hapus);


    if ($pelanggan_hapus > 0){


			echo "<td> <button class='btn btn-danger btn-hapus' data-id='". $data['id'] ."' data-pelanggan='". $data['nama_pelanggan'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";

		}

include 'db.php';

$pilih_akses_pelanggan_edit = $db->query("SELECT pelanggan_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND pelanggan_edit = '1'");
$pelanggan_edit = mysqli_num_rows($pilih_akses_pelanggan_edit);


    if ($pelanggan_edit > 0){
			echo "<td> <button class='btn btn-info btn-edit' data-pelanggan='". $data['nama_pelanggan'] ."' data-kode='". $data['kode_pelanggan'] ."' data-tanggal='". $data['tgl_lahir'] ."' data-nomor='". $data['no_telp'] ."' data-email='". $data['e_mail'] ."' data-wilayah='". $data['wilayah'] ."' data-level-harga='". $data['level_harga'] ."' data-jurusan='". $data['jurusan'] ."' data-id='". $data['id'] ."'> <span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>";
		}

			echo"</tr>";
			}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
			
		?>
		</tbody>

	</table>
	</span>

</div>


   <i><p style="color:red;"> * Note :Untuk Login dengan nasabah</p><p>- Username : No Rekening <br>- Password : 1234 </p></i>


</div> <!--end of container-->


	<script>
	$(function() {
	$( "#tgl_lahir" ).pickadate({ selectYears: 80, format: 'yyyy-mm-dd'});
	});
	</script>

		<script>
	$(function() {
	$( "#edit_tgl_lahir" ).pickadate({ selectYears: 80, format: 'yyyy-mm-dd'});
	});
	</script>



<script>
//untuk menampilkan data tabel
$(document).ready(function(){
    $('.table').DataTable();
});

</script>

<script type="text/javascript">

               $(document).ready(function(){
               $("#kode_pelanggan").blur(function(){
               var kode_pelanggan = $("#kode_pelanggan").val();

              $.post('cek_kode_pelanggan.php',{kode_pelanggan:$(this).val()}, function(data){
                
                if(data == 1){

                    alert ("Kode Pelanggan Sudah Ada");
                    $("#kode_pelanggan").val('');
                    $("#kode_pelanggan").focus();
                }
                else {
                    
                }
              });
                
               });
               });

</script>



        <script type="text/javascript">
                             
								$(document).ready(function(){

					//fungsi untuk menambahkan data
								$("#submit_tambah").click(function(){


								var kode_pelanggan = $("#kode_pelanggan").val();
								var nama_pelanggan = $("#nama_pelanggan").val();
								var level_harga = $("#level_harga").val();
								var no_telp = $("#nomor").val();
								var e_mail = $("#email").val();
								var tgl_lahir = $("#tgl_lahir").val();
								var wilayah = $("#wilayah").val();	
								var jurusan = $("#jurusan").val();	

								if (kode_pelanggan == "") {

									alert("Kode Pelanggan Harus Diisi");
								}

								else if (nama_pelanggan == "") {

									alert("Nama Pelanggan Harus Diisi");
								}

								else if (wilayah == "") {

									alert("Wilayah Harus Diisi");
								}
								else if (jurusan == "") {

									alert("jurusan Harus Diisi");
								}


								else if (level_harga == "") {

									alert("Level Harga Harus Dipilih");
								}
								else {								
									$.post('prosespelanggan.php', {jurusan:jurusan,kode_pelanggan:kode_pelanggan,nama_pelanggan:nama_pelanggan,level_harga:level_harga,no_telp:no_telp,e_mail:e_mail,tgl_lahir:tgl_lahir,wilayah:wilayah}, function(data){
								
								if (data != "") {
								$("#kode_pelanggan").val('');
								$("#nama_pelanggan").val('');
								$("#level_harga").val('');
								$("#tgl_lahir").val('');
								$("#nomor").val('');
								$("#email").val('');
								$("#wilayah").val('');
								
								
								
								$(".alert").show('fast');
								$("#table_baru").load('tabel-pelanggan.php');
								
								setTimeout(tutupalert, 2000);
								$(".modal").modal("hide");
								}
								
								
								});

							}



								function tutupmodal() {
								
								}		
								
								});
								
					// end fungsi tambah 

					//fungsi hapus data 
								  $(document).on('click', '.btn-hapus', function (e) {
								var nama_pelanggan = $(this).attr("data-pelanggan");
								var id = $(this).attr("data-id");
								$("#data_pelanggan").val(nama_pelanggan);
								$("#id_hapus").val(id);
								$("#modal_hapus").modal('show');
								
								
								});
								
								
								$("#btn_jadi_hapus").click(function(){
								
								var id = $("#id_hapus").val();
								
								$.post("hapus_pelanggan.php",{id:id},function(data){
								if (data == "sukses") {
								$("#table_baru").load('tabel-pelanggan.php');
								$("#modal_hapus").modal('hide');
								
								}
								
								
								});
								
								});
					// end fungsi hapus data

				    //fungsi edit data 
							  $(document).on('click', '.btn-edit', function (e) {
								
								$("#modal_edit").modal('show');
								var nama = $(this).attr("data-pelanggan");
								var kode = $(this).attr("data-kode");
								var tanggal   = $(this).attr("data-tanggal");
								var nomor = $(this).attr("data-nomor");
								var email   = $(this).attr("data-email");
								var wilayah = $(this).attr("data-wilayah");
								var level_harga = $(this).attr("data-level-harga");
								var id   = $(this).attr("data-id");
								var jurusan = $(this).attr("data-jurusan");

								$("#edit_nama").val(nama);
								$("#edit_kode").val(kode);
								$("#edit_tgl_lahir").val(tanggal);
								$("#edit_nomor").val(nomor);
								$("#edit_email").val(email);
								$("#edit_wilayah").val(wilayah);
								$("#edit_level_harga").val(level_harga);
								$("#id_edit").val(id);
								$("#edit_jurusan").val(jurusan);
								
								
								});
								
								$("#submit_edit").click(function(){
								var nama = $("#edit_nama").val();
								var kode = $("#edit_kode").val();
								var nomor = $("#edit_nomor").val();
								var tanggal = $("#edit_tgl_lahir").val();
								var email = $("#edit_email").val();
								var wilayah = $("#edit_wilayah").val();
								var level_harga = $("#edit_level_harga").val();
								var jurusan = $("#edit_jurusan").val();
								var id   = $("#id_edit").val();

								if (nama == ""){
									alert("Nama Harus Diisi");
								}
								else if (kode == ""){
									alert("Kode Pelangggan Harus Diisi");
								}
								else if (nomor == ""){
									alert("Nomor Telpon Harus Diisi");
								}
								else if (tanggal == ""){
									alert("Tanggal Harus Diisi");
								}
								else if (wilayah == ""){
									alert("Wilayah Harus Diisi");
								}

								else if (level_harga == "") {

									alert("Level Harga Harus Dipilih");
								}
								else {
								$.post("update_pelanggan.php",{jurusan:jurusan,nama_pelanggan:nama,kode_pelanggan:kode,no_telp:nomor,tgl_lahir:tanggal,e_mail:email,wilayah:wilayah,level_harga:level_harga,id:id},function(data){

								

								$("#table_baru").load('tabel-pelanggan.php');
								$("#modal_edit").modal('hide');
								
								
								
								});
								

								}


								});
								
								
								
					 //end function edit data
								
								$('form').submit(function(){
								
								return false;
								});
								
								});
								
								
								
								
								function tutupalert() {
								$(".alert").hide("fast")
								}

			

        </script>


<?php 
//memasukkan file footer.php
include 'footer.php'; 
?>
