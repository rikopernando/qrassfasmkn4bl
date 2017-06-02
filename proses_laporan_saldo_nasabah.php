<?php 
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */


$dari_tgl = stringdoang($_POST['dari_tanggal']);
$sampai_tgl = stringdoang($_POST['sampai_tanggal']);
$no_rek = stringdoang($_POST['id_nasabah']);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name

    0=>'tanggal', 
    1=>'kode',
    2=>'setoran',
    3=>'tarik',
    4=>'saldo'


);




// getting total number records without any search
$sql = "SELECT tanggal,jumlah,kode, jam,waktu";
$sql.="  FROM detail_penyetoran";
$sql.=" WHERE tanggal >= '$dari_tgl' AND tanggal <= '$sampai_tgl' AND dari_akun = '$no_rek'";
$sql.=" UNION";
$sql.=" SELECT tanggal,jumlah,kode, jam,waktu ";
$sql.=" FROM detail_penarikan ";
$sql.=" WHERE tanggal >= '$dari_tgl' AND tanggal <= '$sampai_tgl' AND ke_akun = '$no_rek' ";


$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.



$sql = "SELECT tanggal,jumlah,kode, jam,waktu";
$sql.="  FROM detail_penyetoran";
$sql.=" WHERE  tanggal >= '$dari_tgl' AND tanggal <= '$sampai_tgl' AND dari_akun = '$no_rek'";
$sql.=" UNION";
$sql.=" SELECT tanggal,jumlah,kode, jam,waktu ";
$sql.="  FROM detail_penarikan ";
$sql.="  WHERE 1=1 AND tanggal >= '$dari_tgl' AND tanggal <= '$sampai_tgl' AND ke_akun = '$no_rek' ";


if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
    $sql.=" AND (tanggal LIKE '".$requestData['search']['value']."%' ";
    $sql.=" AND jam LIKE '".$requestData['search']['value']."%' )";  
}

$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY waktu ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."  ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");



$qweasf = $db->query("SELECT SUM(jumlah) AS total_tabungan FROM detail_penyetoran WHERE dari_akun = '$no_rek' AND waktu <= '$dari_tgl'  ");
$ghjui = mysqli_fetch_array($qweasf);

$loip = $db->query("SELECT SUM(jumlah) AS total_tabungan1 FROM detail_penarikan WHERE ke_akun = '$no_rek' AND waktu <= '$dari_tgl' ");
$ccc = mysqli_fetch_array($loip);

// akhir hitungan saldo awal

 $total_saldo_awal = $ghjui['total_tabungan'] - $ccc['total_tabungan1'];
//untuk menentukan saldo awal 


$data = array();

$nestedData=array(); 

$nestedData[] = "";
$nestedData[] = "";
$nestedData[] = "<p style='color:red'>SALDO AWAL</p>";
$nestedData[] = "";
$nestedData[] = "";
$nestedData[] =  "<p style='color:red'>".$total_saldo_awal."</p>";

$data[] = $nestedData;


while( $row=mysqli_fetch_array($query) ) {

    $nestedData=array(); 


$asdas = $db->query("SELECT SUM(jumlah) AS total_tabungan FROM detail_penyetoran WHERE dari_akun = '$no_rek' AND waktu <= '$row[waktu]'  ");
$fasf = mysqli_fetch_array($asdas);

$qweqw = $db->query("SELECT SUM(jumlah) AS total_tabungan1 FROM detail_penarikan WHERE ke_akun = '$no_rek' AND waktu <= '$row[waktu]' ");
$asd = mysqli_fetch_array($qweqw);


    
 $total = $fasf['total_tabungan'] - $asd['total_tabungan1'];

    $nestedData[] = $row["tanggal"];
    $nestedData[] = $row["jam"];
    $nestedData[] = $row["kode"];

    if ($row["kode"] == 1) {
    $nestedData[] = rp($row["jumlah"]);
    $nestedData[] = "";

    }
    else
    {

    $nestedData[] = "";
    $nestedData[] = rp($row["jumlah"]);

    }
    
    $nestedData[] = rp($total);
        
    $data[] = $nestedData;
        
}



$json_data = array(
            "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal"    => intval( $totalData ),  // total number of records
            "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data"            => $data   // total data array
            );

echo json_encode($json_data);  // send data as json format

 ?>