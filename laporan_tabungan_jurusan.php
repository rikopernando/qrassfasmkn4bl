<?php include 'session_login.php';

include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


 ?>

<div class="container">
<h1>Laporan Tabungan Jurusan</h1>


<form id="nama_form" class="form-inline" method="POST" role="form">
<br>
<div class="form-group">
<label> Nama Jurusan </label>	<br>
<select type="text" name="jurusan" id="jurusan" class="form-control chosen" >
<option value="">--Pilih Jurusan--</option>
<?php 
    $query = $db->query("SELECT id,nama FROM jurusan ");
    while($data = mysqli_fetch_array($query))
    {
    echo "<option value='".$data['id'] ."'>".$data['nama']."</option>";
    }
    ?>
</select>

<button id="show_data" class="btn btn-purple"><i class="fa fa-eye"></i> Tampil</button>
</div>
</form>


  <div class="card card-block">
      <center id="judul"> <h2> <b>  </b> </h2> </center>

<div class="table-responsive">
<span id="show_table" ><!--span untuk table-->       
    <table id="table_lap_jurusan" class="table table-bordered">

      <thead>
      <th style='background-color: #4CAF50; color:white'> No Rekening </th>
      <th style='background-color: #4CAF50; color:white'> Nama Nasabah</th>
      <th style='background-color: #4CAF50; color:white'> Jurusan </th>
      <th style='background-color: #4CAF50; color:white'> Saldo </th>
            
           </thead>

        <tbody>
            
      </tbody>
     </table>
</span><!--akhir span untuk table-->
</div><!--end responsive-->
</div>
<br>

<h4 style="display: none" id="lihat_total"><b> </b></h4>

<a href='' type='submit' id="export" class='btn btn-default' style="display: none"> <i class='fa fa-download'> </i> Download Excel</a>

 <a href='' id="cetak" id="cetak" class="btn btn-success" target="blank" style="display: none"><i class='fa fa-print'> </i> Cetak</a>

</div><!--container end-->


    <script type="text/javascript" language="javascript" >
      $(document).ready(function() {
$(document).on('click','#show_data',function(e) {
     $('#table_lap_jurusan').DataTable().destroy();

          var dataTable = $('#table_lap_jurusan').DataTable( {
          "processing": true,
          "serverSide": true,
          "info":     false,
          "language": {
        "emptyTable":     "My Custom Message On Empty Table"
    },
          "ajax":{
            url :"proses_laporan_jurusan.php", // json datasource
             "data": function ( d ) {
                d.jurusan = $("#jurusan").val();
                // d.custom = $('#myInput').val();
                // etc
            },
                type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#table_lap_jurusan").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
              $("#table_lap_jurusan_processing").css("display","none");
              
            }
          }
    

        } );

var jurusan = $("#jurusan").val();
$("#show_table").show()
$("#export").attr('href', 'export_data_lap_jurusan.php?jurusan='+jurusan+'')
$("#cetak").attr('href', 'cetak_laporan_jurusan.php?jurusan='+jurusan+'')
$("#lihat_total").show()
$("#export").show()
$("#cetak").show()

          $.post("cek_total_saldo_jurusan.php",{jurusan:jurusan},function(data){
            var tampil = "Total Saldo Rp. ";
            var akhir = tampil + tandaPemisahTitik(data);
            $("#lihat_total").text(akhir)


          });

            $.post("cek_jurusan.php",{jurusan:jurusan},function(data){
      
            var judulnya = "Saldo Tabungan " + data;
            $("#judul").text(judulnya)

          });

   } );  
  $("#nama_form").submit(function(){
      return false;
  });
  function clearInput(){
      $("#nama_form :input").each(function(){
          $(this).val('');
      });
  };
  } );
    </script>

<script type="text/javascript">
$(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!"});  
</script>


<script>
// untuk memunculkan data tabel 
$(document).ready(function() {
  $('#table_lap_jurusan').DataTable({"ordering":false});
});

</script>

<?php 
include 'footer.php';
 ?>