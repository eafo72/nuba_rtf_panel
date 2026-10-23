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
                                <form method="post" enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']; ?>" novalidate>

                                    <br>
                                    <h2 style="font-size:25px;">Editar objetivo</h2>
                                    <?php
                                    require_once("conexion.php");
                                    $id=$_GET['id'];
                                    $consulta = "SELECT * FROM objetivos WHERE objetivo_id = $id";
                                    $resultado = $mysqli->query($consulta);
                                    $obj = $resultado->fetch_object();
                                    $nombre = $obj->nombre_objetivo;
                                    $imagen = $obj->imagen_objetivo;
                                    $tipo = $obj->tipo_objetivo;
                                    $firma = $obj->firma;

                                    $resultado->close();
                                    ?>

                                    <h6><b>Nombre:</b></h6>     
                                    <input type='text' name='nombre' size="20" value="<?php echo $nombre;?>"/><br><br>
                                    <h6><b>Imagen:</b></h6>     
                                    <h6>Actual : <?php echo $imagen;?></h6>
                                    <input type='file' name='imagen'/><br><br>

                                    <!--
<h6><b>Tipo:</b></h6>     
<select name="tipo">
<option <?php //if($tipo == 'Actividad') {echo "selected";} ?> >Actividad</option>
<option <?php //if($tipo == 'Inventario') {echo "selected";} ?> >Inventario</option>
<option <?php //if($tipo == 'Venta') {echo "selected";} ?> >Venta</option>                                        
</select>
-->
                                    
                                    <h6><b>Incluir Firma:</b></h6>
                                    <select name='firma'>
                                        
                    <option <?php if($firma == 'Si'){echo "selected";} ?> value="Si">Sí</option>
                    <option <?php if($firma == 'No'){echo "selected";} ?> >No</option>
                                    </select>

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
                                $id=$_GET['id'];
                                require_once 'conexion.php'; 
                                $nombre_nuevo = $_REQUEST['nombre'];
                                $firma = $_REQUEST['firma'];
                                
                                //$tipo =$_REQUEST['tipo'];

                                if ($nombre != $nombre_nuevo){
                                    $sql = "SELECT * FROM objetivos WHERE nombre_objetivo = '$nombre_nuevo'";
                                    $resql = $mysqli->query($sql);
                                    $count = mysqli_num_rows($resql);
                                    if ($count > 0) {
                                        $resql->close();
                            ?>  
                            <script type="text/javascript">    
                                alert ('El Nombre del objetivo ya existe, por favor escoga otro.');
                                var js = "<?php echo $id; ?>";
                                window.location.assign("objetivo_editar.php?id="+js);
                            </script>     
                            <?php 
                                        return;
                                    }
                                }




                                $file_name = $_FILES['imagen']['name'];
                                if (empty($file_name) == false){
                                    $file_tmp =$_FILES['imagen']['tmp_name'];
                                    move_uploaded_file($file_tmp,"assets/images/".$file_name);    
                                    $sql = "UPDATE objetivos SET
                                    imagen_objetivo = '$file_name'
                                    WHERE objetivo_id = '$id'
                                    ";
                                    $mysqli->query($sql);    
                                }
                                $sql = "UPDATE objetivos SET
                                    nombre_objetivo = '$nombre_nuevo',
                                    firma = '$firma'
                                    WHERE objetivo_id = '$id'
                                    ";
                                $mysqli->query($sql);    
                            ?>
                            <script type="text/javascript">
                                window.location.assign("objetivo_panel.php");
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