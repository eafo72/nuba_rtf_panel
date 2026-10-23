<?php include('pass.php');
require_once("conexion.php");
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
                            <div align="center" class="col-12">
                                <form method="post" enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']; ?>">

                                    <br>
                                    <h2 style="font-size:25px;">Editar Paquete</h2>
                                    <?php
                                    
                                    $id=$_GET['id'];
                                    $consulta = "SELECT * FROM paquetes WHERE id_paquete = $id";
                                    if($resultado = $mysqli->query($consulta)){
                                        $obj = $resultado->fetch_object();

                                        $nombre = $obj->nombre;
                                        $precio = $obj->precio;
                                        $colaboradores = $obj->colaboradores;
                                        $ubicaciones = $obj->ubicaciones;
                                        $temporalidad_dias = $obj->temporalidad_dias;

                                        $resultado->close();
                                    }
                                    
                                    ?>

                                    <br>

                                    <h6><b>Nombre:</b></h6>     
                                    <input type='text' name='nombre' value="<?php echo $nombre;?>"/>
                                    <br><br>

                                    <h6><b>Precio:</b></h6>     
                                    <input type="number" name='precio' step="any" value="<?php echo $precio;?>"/>
                                    <br><br>

                                    <h6><b>#Colaboradores:</b></h6>     
                                    <input type="number" name='colaboradores' value="<?php echo $colaboradores;?>"/>
                                    <br><br>

                                    <h6><b>#Ubicaciones:</b></h6>     
                                    <input type="number" name='ubicaciones' value="<?php echo $ubicaciones;?>"/>
                                    <br><br>

                                    <h6><b>Temporalidad (días):</b></h6>     
                                    <input type="number" name='temporalidad_dias' value="<?php echo $temporalidad_dias;?>"/>
                                    <br><br>


                                    <div class="text-center">
                                        <input  class="btn btn-success btn-rounded" type="submit" name="Editar"   value="Guardar"/>
                                    </div>    
                                    <br>
                                </form>
                            </div>
                            <?php
                            if(isset($_REQUEST['Editar'])){
                                
                                $nombre = $_POST['nombre'];
                                $precio = $_POST['precio'];
                                $colaboradores = $_POST['colaboradores'];
                                $ubicaciones = $_POST['ubicaciones'];
                                $temporalidad_dias = $_POST['temporalidad_dias'];


                                $sql = "UPDATE paquetes SET
                                nombre = '$nombre',
                                precio = '$precio',
                                colaboradores = '$colaboradores',
                                ubicaciones = '$ubicaciones',
                                temporalidad_dias = '$temporalidad_dias'
                                WHERE id_paquete = '$id'";
                                $mysqli->query($sql);    
                            ?>
                            <script type="text/javascript">
                                window.location.assign("paquetes_panel.php");
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