<?php include 'session_login.php';
//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


 ?>

<div class="container">


<!--tampilan modal-->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- isi modal-->
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Data Nasabah</h4>
      </div>
      <div class="modal-body">

<span class="modal_baru">
<div class="table-resposive">
<center>
    <table id="tabel_siswa" class="table table-striped">
        <thead> <!-- untuk memberikan nama pada kolom tabel -->
        
      <th> No Rekening </th>
      <th> Nasabah </th>
      <th> Kelas </th>
      <th> Tgl. Lahir </th>
      <th> Nomor Telp. </th>
      <th> Jurusan</th>
        
        </thead> <!-- tag penutup tabel -->
  </table>
</center>
  </div>
</span>
</div> <!-- tag penutup modal-body-->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div><!-- end of modal data barang  -->

<h1> LAPORAN SALDO/NASABAH</h1><hr>
<br>


<button type="button" id="cari_siswa" class="btn btn-info " data-toggle="modal" data-target="#myModal"><i class='fa fa-search'> </i> Cari</button> 
<br><br>

<form id="perhari" class="form-inline"  method="POST" role="form">
          
<div class="form-group">
    <input type="text" class="form-control" id="no_rek" autocomplete="off" name="no_rek" placeholder="No. Rekening">
  
</div>
<input type="hidden" class="form-control" id="id_nasabah" autocomplete="off" name="id_nasabah">
<div class="form-group">
    <input type="text" class="form-control dsds" id="daritgl" autocomplete="off" name="daritanggal" placeholder="Dari Tanggal ">
</div>

<div class="form-group">
    <input type="text" class="form-control dsds" id="sampaitgl" autocomplete="off" name="sampaitanggal" placeholder="Sampai Tanggal ">
</div>

    
<button id="btntgl" class="btn btn-primary"><i class="fa fa-eye"></i>Tampil</button>
    
</form>
<br>

<span id="result" style="display: none;">
<div class="card card-block">
  <center><h2 style="display: none;" id="judul"></h2></center>
<br>  
 <table id="table-data">
  <tbody>
      <tr><td width="25%"><font class="satu">No. Rekening</font></td> <td> :&nbsp;</td> <td><font class="satu" id="no_rekening"></font> </tr>

      <tr><td  width="25%"><font class="satu">Nama Penabung</font></td> <td> :&nbsp;</td> <td><font class="satu" id="nama_penabung"></font></td></tr>

      <tr><td  width="25%"><font class="satu">Jurusan</font></td> <td> :&nbsp;</td> <td><font class="satu" id="jurusan"></font></td></tr>
         

  </tbody>
</table>
<br> <br>      
<div class="table-resposive">
    <table id="tabel_tampil" class="table table-striped">
        <thead> <!-- untuk memberikan nama pada kolom tabel -->
        
      <th  style='background-color: #4CAF50; color: white'> Tanggal </th>
      <th  style='background-color: #4CAF50; color: white'> Jam </th>
      <th  style='background-color: #4CAF50; color: white'> Kode </th>
      <th  style='background-color: #4CAF50; color: white'> Setoran </th>
      <th  style='background-color: #4CAF50; color: white'> Penarikan </th>
      <th  style='background-color: #4CAF50; color: white'> Saldo </th>
        
        </thead> <!-- tag penutup tabel -->
  </table>
  </div>
<br>
    <div class="row">
        <div class="col-sm-2">
          <label style="height: 25px; width:90%; font-size:20px;"> Total Saldo</label>
            <b><input type="text" style="height: 25px; width:90%; font-size:20px;" class="form-control" id="total_saldo" autocomplete="off" name="total_saldo" readonly=""></b>
            <p> * Kode <br> 1.Penabungan <br> 2. Penarikan </p>
        </div>


        <div class="col-sm-2"><br>
          <a id="trx" href='' class='btn btn-success' target='blank'><i class='fa fa-print'> </i> Cetak</a>
        </div>  

         <div class="col-sm-2">
         <br>
        <a href='' style="width: 170px;" type='submit' id="btn-export" class='btn btn-default'><i class='fa fa-download'> </i> Download Excel</a>
        </div>

    </div>
</div>


</span>

</div> <!-- END DIV container -->

  <script>

$(function() {
    $("#no_rek").autocomplete({
        source: 'cari_nasabah_auto.php'
    });
});
</script>

    <script type="text/javascript" language="javascript" >
      $(document).ready(function() {
$(document).on('click','#btntgl',function(e) {
     $('#tabel_tampil').DataTable().destroy();

          var dataTable = $('#tabel_tampil').DataTable( {
          "processing": true,
          "serverSide": true,
          "info":     false,
          "language": {
        "emptyTable":     "My Custom Message On Empty Table"
    },
          "ajax":{
            url :"proses_laporan_saldo_nasabah.php", // json datasource
             "data": function ( d ) {
                d.dari_tanggal = $("#daritgl").val();
                d.sampai_tanggal = $("#sampaitgl").val();
                d.id_nasabah = $("#id_nasabah").val()
                // d.custom = $('#myInput').val();
                // etc
            },
                type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#tabel_tampil").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
              $("#tabel_tampil_processing").css("display","none");
              
            }
          }
    


        } );
          $("#result").show()

   } );  
  $("#perhari").submit(function(){
      return false;
  });
  function clearInput(){
      $("#perhari :input").each(function(){
          $(this).val('');
      });
  };
  } );
    </script>




<!--SCRIPT datepicker -->
<script> 
  $(function() {
    $( ".dsds" ).datepicker({ dateFormat: "yy-mm-dd", beforeShow: function (input, inst) {
        var rect = input.getBoundingClientRect();
        setTimeout(function () {
         inst.dpDiv.css({ top: rect.top + 40, left: rect.left + 0 });
        }, 0);
    } });
  });
</script> 
<!--end SCRIPT datepicker -->



<script type="text/javascript" language="javascript" >
   $(document).ready(function() {
        var dataTable = $('#tabel_siswa').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"modal_cari_nasabah.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#tabel_siswa").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#tabel_siswa_processing").css("display","none");
              
            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class', "pilih");
              $(nRow).attr('data-no_rek', aData[0]+"("+aData[1]+")");
              $(nRow).attr('data-id', aData[6]);


          }

        });    
     
  });
 
 </script>


<!--untuk memasukkan perintah java script-->
<script type="text/javascript">

// jika dipilih, nim akan masuk ke input dan modal di tutup
  $(document).on('click', '.pilih', function (e) {

  document.getElementById("no_rek").value = $(this).attr('data-no_rek');

  document.getElementById("id_nasabah").value = $(this).attr('data-id');

  $('#myModal').modal('hide'); 


});

    $(document).on('blur','#no_rek',function(e){
        var no_rek = $(this).val();
        var no_rek = no_rek.substr(0, no_rek.indexOf('('));
        var nama_penabung = no_rek.substr(0, no_rek.indexOf(')'));

        $.post("cek_id_nasabah.php",{no_rek:no_rek},function(data){
          $("#id_nasabah").val(data)

        });

    });


    $(document).on('click','#btntgl',function(e) {

   
        function ambil_tgl(tanggal_input1){
        var birthday1 = tanggal_input1;
        birthday1=birthday1.split("-");   
        var hari_ini = birthday1[2];
        return hari_ini;
        }
        function ambil_bln(tanggal_input2){
        var birthday2 = tanggal_input2;
        birthday2=birthday2.split("-");   
        var bulan = birthday2[1];
        return bulan;
        }

        function ambil_thn(tanggal_input3){
        var birthday3 = tanggal_input3;
        birthday3=birthday3.split("-");   
        var tahun = birthday3[0];
        return tahun;
        }
        var dari_tanggal = $("#daritgl").val();
        var ambil_tgl1 = ambil_tgl(dari_tanggal);
        var ambil_bln1 = ambil_bln(dari_tanggal);
        var ambil_thn1 = ambil_thn(dari_tanggal);
        var tanggal1 = ambil_tgl1 + "/" + ambil_bln1 + "/" + ambil_thn1;

        var sampai_tanggal = $("#sampaitgl").val();
        var ambil_tgl2 = ambil_tgl(sampai_tanggal);
        var ambil_bln2 = ambil_bln(sampai_tanggal);
        var ambil_thn2 = ambil_thn(sampai_tanggal);
        var tanggal2 = ambil_tgl2 + "/" + ambil_bln2 + "/" + ambil_thn2;

        var id = $("#id_nasabah").val()
        var judul = "Laporan Tabungan Dari " + tanggal1 + " Sampai " + tanggal2;



          $.post("cek_total_saldo.php",{id:id},function(data){
            $("#total_saldo").val(tandaPemisahTitik(data))
          });

          $("#judul").show();
          $("#judul").text(judul);
          $("#trx").attr('href','cetak_lap_tabungan_rek.php?dari_tanggal='+dari_tanggal+'&sampai_tanggal='+sampai_tanggal+"&id_nasabah="+id+"");
          $("#btn-export").attr("href","export_lap_tab_rek.php?dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"&id_nasabah="+id+"");

          $.getJSON("cek_data_nasabah.php",{id:id},function(info){

            $("#no_rekening").text(info.kode_pelanggan)
            $("#nama_penabung").text(info.nama_pelanggan)
            $("#jurusan").text(info.nama)

          });
    });  

      $("#perhari").submit(function(){
      return false;
  });
  function clearInput(){
      $("#perhari :input").each(function(){
          $(this).val('');
      });
  };

  </script>


<?php 

include 'footer.php';
 ?>