<?php session_start();
 
    include 'sanitasi.php';
    include 'db.php';

    $username = stringdoang($_POST['username']);
    $password = $_POST['password'];

   $querymaster =  $db->query("SELECT * FROM user WHERE username = '$username' ");
   
   $jumlah = mysqli_num_rows($querymaster);

   $data = mysqli_fetch_array($querymaster);   
   $otoritas = $data['otoritas'];
   $nama = $data['nama'];


   $id_otoritas =  $db->query("SELECT id FROM hak_otoritas WHERE nama = '$data[otoritas]'");
   $data0 = mysqli_fetch_array($id_otoritas);   
   $otoritas_id = $data0['id'];

   $hash = '$2y$07$BCryptRequires22Chrcte/VlQH0piJtjxl.0t1kA8pw9dMXTpOq';

    
    if ($jumlah == 1 )
        {
                $passwordku = $data['password'];

                if (password_verify($password,$passwordku)) 
                {
                echo "Mohon Tunggu...";
                $_SESSION['otoritas_id'] = $otoritas_id;
                $_SESSION['otoritas'] = $otoritas;
                $_SESSION['user_name'] = $username;
                $_SESSION['nama'] = $nama;
                
                echo '<META HTTP-EQUIV="Refresh" Content="0; URL=home.php">';
                
                
                }
                else
                {
                echo "<center> <h2> Password Yang Anda Masukan Salah !! <br>
                <a href='index.php'> KEMBALI </a> </h2> </center>";
                }
         }       
                
    else 
        {

            $asc = $db->query("SELECT * FROM pelanggan WHERE kode_pelanggan = '$username' ");
            $esc = mysqli_num_rows($asc);
            $nasabah = mysqli_fetch_array($asc);

            if ($esc == 1)
           {
                $passwordku = $nasabah['password'];

                if (password_verify($password,$passwordku)) 
                {
                echo "Mohon Tunggu...";
                $_SESSION['kode_pelanggan'] = $username;
                $_SESSION['nama_pelanggan'] = $nasabah['nama_pelanggan'];
                $_SESSION['id_pelanggan'] = $nasabah['id'];

                echo '<META HTTP-EQUIV="Refresh" Content="0; URL=laporan_tabungan_nasabah.php">';
                
                }
                else
                {
                echo "<center> <h2> Password Yang Anda Masukan Salah !! <br>
                <a href='index.php'> KEMBALI </a> </h2> </center>";
                }
            }
            else
            {
                echo "<center> <h2> Username Yang Anda Masukan Salah !! <br>
               
                <a href='index.php'> KEMBALI </a> </h2> </center>";
            }


        }
        
        
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

?> 