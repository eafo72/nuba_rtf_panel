<?php include('pass.php');
require_once 'conexion.php';   
?>
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
                            $consultaone = "SELECT * FROM viaticos WHERE id_viatico = $id"; 
                            $result = $mysqli->query($consultaone);
                            $ive = $result->fetch_object();
                            ?>  
                            <!-- fin recopilacion de info para value -->   
                            <div align="center" class="col-12">
                                <form method="post" enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']; ?>" >
                                    <div align="center">
                                        <br>
                                        <h2 style="font-size:25px;" >Confirma borrar la Cuenta :</h2> <h4><i>ID : <?php printf($ive->id_viatico); ?></i></h4>
                                        <h4><i>Técnico: <?php printf($ive->nombre_asignado); ?></i></h4>
                                        <h4><i>Semana: <?php printf($ive->id_semana); ?></i></h4>
                                        <br><br>
                                        <input  class="btn btn-success btn-rounded" type="submit" name="Borrar" value="Borrar"/><br><br> 
                                    </div>
                                </form>
                            </div>

                            <?php
                            $result->close();
                            if(isset($_REQUEST['Borrar'])){
                                $id=$_GET['id'];
                                $borrado = "DELETE FROM viaticos where id_viatico = $id";
                                $mysqli->query($borrado);
                                ?>
                                <script type="text/javascript">
                                    window.location.assign("viaticos_panel.php");
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