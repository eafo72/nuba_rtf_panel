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
                            <div align="center" class="col-12">
                                <form method="post" enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']; ?>">

                                    <br>
                                    <h2 style="font-size:25px;">Editar cadena</h2>
                                    <?php
                                    require_once("conexion.php");
                                    $id=$_GET['id'];
                                    $consulta = "SELECT * FROM cadena WHERE cadena_id = $id";
                                    $resultado = $mysqli->query($consulta);
                                    $obj = $resultado->fetch_object();
                                    $nombre = $obj->nombre_cadena;
                                    $resultado->close();
                                    ?>

                                    <h6><b>Nombre:</b></h6>     
                                    <input type='text' name='nombre' size="20" value="<?php echo $nombre;?>"/><br><br>


                                    <br>      
                                    <div class="text-center">
                                        <input  class="btn btn-success btn-rounded" type="submit" name="Editar"   value="Guardar"/>
                                    </div>    
                                    <br>
                                </form>
                            </div>
                            <?php
                            if(isset($_REQUEST['Editar'])){
                                require_once 'conexion.php'; 
                                $nombre_nuevo = $_REQUEST['nombre'];


                                $sql = "UPDATE cadena SET
                                    nombre_cadena = '$nombre_nuevo'
                                    WHERE cadena_id = '$id'
                                    ";
                                $mysqli->query($sql);    
                            ?>
                            <script type="text/javascript">
                                window.location.assign("cadenas_panel.php");
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