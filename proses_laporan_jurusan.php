<?php
include 'db.php';
include 'sanitasi.php';

$jurusan = stringdoang($_POST['jurusan']);
/* Database connection end */
$show_jurusan = $db->query("SELECT nama FROM jurusan WHERE id = '$jurusan'");
$out = mysqli_fetch_array($show_jurusan);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 =>'kode_pelanggan', 
	1 => 'nama_pelanggan',
	2 => 'jurusan',
	3 => 'saldo'
);

// getting total number records without any search
$sql = "SELECT * ";
$sql.=" FROM pelanggan ";
$sql.=" WHERE jurusan = '$jurusan'";
$query=mysqli_query($conn, $sql) or die("1.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT * ";
$sql.=" FROM pelanggan WHERE jurusan = '$jurusan'";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

	$sql.=" AND ( kode_pelanggan LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR jurusan LIKE '".$requestData['search']['value']."%'";   
	$sql.=" OR nama_pelanggan LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($conn, $sql) or die("2.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("3.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

//menampilkan data
		$select_jurusan = $db->query("SELECT nama FROM jurusan WHERE id = '$row[jurusan]'");
        $taked = mysqli_fetch_array($select_jurusan);


// START hitungan jumlah uang penyetoran dan penarikan
$select_setoran = $db->query("SELECT SUM(jumlah) AS total_tabungan FROM detail_penyetoran WHERE dari_akun = '$row[id]' ");
$jumlah_setor = mysqli_fetch_array($select_setoran);

$select_penarikan = $db->query("SELECT SUM(jumlah) AS total_tabungan1 FROM detail_penarikan WHERE ke_akun = '$row[id]' ");
$jumlah_tarik = mysqli_fetch_array($select_penarikan);

 $total = $jumlah_setor['total_tabungan'] - $jumlah_tarik['total_tabungan1'];
 // END hitungan jumlah uang penyetoran dan penarikan


	$nestedData[] = $row["kode_pelanggan"];
	$nestedData[] = $row["nama_pelanggan"];
	$nestedData[] = $taked["nama"];
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

