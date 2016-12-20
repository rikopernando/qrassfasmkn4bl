<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name

    0=>'kode_pelanggan', 
    1=>'nama_pelanggan',
    2=>'level_harga',
    3=>'tgl_lahir',
    4=>'no_telp',
    5=>'nama',
    6=>'id'


);

// getting total number records without any search
$sql = "SELECT j.nama,p.kode_pelanggan,p.nama_pelanggan,p.level_harga,p.tgl_lahir,p.no_telp,p.id ";
$sql.=" FROM pelanggan p INNER JOIN jurusan j ON p.jurusan = j.id";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT j.nama,p.kode_pelanggan,p.nama_pelanggan,p.level_harga,p.tgl_lahir,p.no_telp,p.id ";
$sql.=" FROM pelanggan p INNER JOIN jurusan j ON p.jurusan = j.id";
$sql.=" WHERE 1=1";


if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
    $sql.=" AND ( p.kode_pelanggan LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR p.nama_pelanggan LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR p.tgl_lahir LIKE '".$requestData['search']['value']."%'";   
    $sql.=" OR p.no_telp LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR j.nama LIKE '".$requestData['search']['value']."%' )";
}

$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY p.id ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");

$data = array();

while( $row=mysqli_fetch_array($query) ) {

    $nestedData=array(); 

    $nestedData[] = $row["kode_pelanggan"];
    $nestedData[] = $row["nama_pelanggan"];
    $nestedData[] = $row["level_harga"];
    $nestedData[] = $row["tgl_lahir"];
    $nestedData[] = $row["no_telp"];
    $nestedData[] = $row["nama"];
    $nestedData[] = $row["id"];

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