<?php session_start();
$user_id = $_SESSION['user_id'];    
?>
  <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="admin.php">
                <?php
                if($user_id == 23){
                  ?>
                  <img src="landing/images/hpmled_logo.jpg" alt="logo" class="img-fluid">
                  <?php  
                }else if($user_id == 31){
                    ?>
                    <img src="landing/images/lup_logo.jpg" alt="logo" class="img-fluid">
                    <?php  
                }else{
                   ?>
                   <img src="landing/images/logo-rtf-original.png" alt="logo" class="img-fluid">
                   <?php  
                }
                ?>
            </a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button
            ><!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
              
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa-regular fa-user"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="logout.php">Salir</a>
                    </div>
                </li>
            </ul>
        </nav>