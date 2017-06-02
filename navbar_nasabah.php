
<div id="modal_logout" class="modal fade" role="dialog">
  <div class="modal-dialog">



    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="color: black">Konfirmasi LogOut</h4>
      </div>

      <div class="modal-body">
   
   <h3 style="color: black">Apakah Anda Yakin Ingin Keluar ?</h3>
 

     </div>

      <div class="modal-footer">
        <a href="logout.php"> <button class="btn btn-warning" ><i class="fa  fa-check "></i> Ya </button></a>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa  fa-close "></i> Batal</button>
      </div>
    </div>

  </div>
</div>

    <!--Double navigation-->
    <header>

        

        <!--Navbar-->
        <nav class="navbar navbar-fixed-top scrolling-navbar double-nav">

        




          <?php 

      include_once 'db.php';
      
      $perusahaan = $db->query("SELECT * FROM perusahaan ");
      $ambil_perusahaan = mysqli_fetch_array($perusahaan);


           ?>


            <div class="breadcrumb-dn">
                <p style="font-size: 100%"><?php echo $ambil_perusahaan['nama_perusahaan']; ?></p>
            </div>

            <ul class="nav navbar-nav pull-right">
        
        <li class="nav-item">
        <a class="nav-link" href="form_ubah_password_nasabah.php"> Ubah Password</a>

        </li>

        <li class="nav-item ">
                    <a href="https://www.andaglos.com" class="nav-link"><i class="fa fa-envelope"></i> <span class="hidden-sm-down">Contact Us</span></a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link"><i class="fa fa-user"></i> <span class="hidden-sm-down">
                    <?php echo $_SESSION['nama_pelanggan'];?></span>
                    </a>

                </li>

                <li class="nav-item">
                    <a class="nav-link" id="loguot"><i class="fa  fa-sign-out" data-toggle="modal" ></i> <span class="hidden-sm-down">LogOut</span>
                    </a>

                </li>
                
                
            </ul>

        </nav>
        <!--/.Navbar-->

    </header>
    <!--/Double navigation-->

    <main>