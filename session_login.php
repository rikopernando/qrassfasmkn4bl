<?php session_start();


if ($_SESSION['user_name'] == '' )
{
		if ($_SESSION['kode_pelanggan'] == '') {
			header('location:index.php');
		}


}

 ?>