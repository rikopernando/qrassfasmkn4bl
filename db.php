<?php date_default_timezone_set("Asia/Jakarta");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "minibank";

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());

// perintah untuk mengkoneksikan php ke database mysql
 /* $db = new mysqli('localhost','demoo','asdakgnadjfbdfnkb34r3cff3','minibank_smk4bl');*/

 $db = new mysqli('localhost','root','','minibank');  

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}


?>