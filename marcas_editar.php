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
                                    <h2 style="font-size:25px;">Editar Empresa</h2>
                                    <?php
                                    require_once("conexion.php");
                                    $id=$_GET['id'];
                                    $consulta = "SELECT * FROM marcas WHERE marca_id = $id";
                                    $resultado = $mysqli->query($consulta);
                                    $obj = $resultado->fetch_object();
                                    $nombre_marca = $obj->nombre_marca;
                                    $descripcion_marca = $obj->descripcion_marca;
                                    $tipo_marca = $obj->tipo_marca;
                                    $no_marca = $obj->no_marca;
                                    $resultado->close();
                                    ?>

                                    <h6><b>Nombre:</b></h6>     
                                    <input type='text' name='nombre_marca' value="<?php echo $nombre_marca;?>">
                                    <br><br>

                                    <h6><b>Descripción:</b></h6>     
                                    <textarea name='descripcion_marca' cols="50" rows="5"><?php echo $descripcion_marca;?></textarea>
                                    <br><br>

                                    
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
                                $nombre_marca = $_REQUEST['nombre_marca'];
                                $descripcion_marca = $_REQUEST['descripcion_marca'];
                                $tipo_marca = '';
                                $no_marca ='';


                                $sql = "UPDATE marcas SET
                                nombre_marca = '$nombre_marca',
                                descripcion_marca = '$descripcion_marca',
                                tipo_marca = '$tipo_marca',
                                no_marca = '$no_marca'
                                WHERE marca_id = '$id'
                                    ";
                                $mysqli->query($sql);    
                            ?>
                            <script type="text/javascript">
                                window.location.assign("marcas_panel.php");
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