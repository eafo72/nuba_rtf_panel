<?php include('pass.php');?>
<!DOCTYPE html>
<html lang="en">
    <?php include('cabecera_panel.php'); ?>
    <body class="sb-nav-fixed">
        <?php include('preloader.php'); ?>
        <?php include('header.php'); ?>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <?php include('menu_panel.php'); ?>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <div class="row">
                            <?php 
                            $id=$_GET['id'];
                            require_once 'conexion.php';   
                            $consultaone = "SELECT * FROM usuarios WHERE usuario_id = $id"; 
                            $result = $mysqli->query($consultaone);
                            $ive = $result->fetch_object();
                            ?>  
                            <!-- fin recopilacion de info para value -->   
                            <div align="center" class="col-12">
                                <form method="post" enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']; ?>" >

                                    <br>
                                    <h2 style="font-size:25px;" >Confirma borrar el Usuario :</h2>  
                                    <h2><i><?php printf($ive->nombre_usuario); ?></i></h2>
                                    <h2><i>ID : <?php printf($ive->usuario_id); ?></i></h2>
                                    <br><br>
                                    <input  class="btn btn-success btn-rounded" type="submit" name="Borrar" value="Borrar"/><br><br> 

                                </form>
                            </div>
                            <?php
                            $result->close();
                            if(isset($_REQUEST['Borrar'])){
                                include("conexion.php");
                                $id=$_GET['id'];
                                $borrado = "DELETE FROM usuarios WHERE usuario_id = $id";
                                $mysqli->query($borrado);
                            ?>
                            <script type="text/javascript">
                                window.location.assign("usuarios.php");
                            </script>
                            <?php
                            }

                            ?>    

                        </div>    
                    </div>
                </main>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    </body>
</html>