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
                                    <h2 style="font-size:25px;">Editar elemento</h2>
                                    <?php
                                    require_once("conexion.php");
                                    $id=$_GET['id'];
                                    $consulta = "SELECT * FROM elementos_llegada WHERE elemento_id = $id";
                                    $resultado = $mysqli->query($consulta);
                                    $obj = $resultado->fetch_object();
                                    $nombre = $obj->nombre_elemento;
                                    $script = htmlentities($obj->script_elemento);
                                    $tipo_entrega = $obj->tipo_entrega;
                                    $name = $obj->name;
                                    $resultado->close();
                                    ?>

                                    <h6><b>Nombre:</b></h6>     
                                    <input type='text' name='nombre' size="20" value="<?php echo $nombre;?>"/><br><br>

                                    <h6><b>Script:</b></h6>     
                                    <textarea name='script' cols="50" rows="5"><?php echo $script;?></textarea><br><br>

                                    <h6><b>Name:</b></h6>     
                                    <input type='text' name='name' value="<?php echo $name;?>" >
                                    <br><br> 

                                    <h6><b>Tipo Entrega:</b></h6>     
                                    <select name="tipo_entrega">
                                        <option <?php if($tipo_entrega == 'Archivo'){echo "selected";} ?> >Archivo</option>
                                        <option <?php if($tipo_entrega == 'Dato Texto'){echo "selected";} ?> >Dato Texto</option>
                                        <option <?php if($tipo_entrega == 'Dato Numero'){echo "selected";} ?> >Dato Numero</option>
                                        <option <?php if($tipo_entrega == 'Dato Numero Inventario'){echo "selected";} ?> >Dato Numero Inventario</option>
                                        <option <?php if($tipo_entrega == 'Dato Numero Venta'){echo "selected";} ?> >Dato Numero Venta</option>           <option <?php if($tipo_entrega == 'Dato Fecha'){echo "selected";} ?> >Dato Fecha</option>
                                        <option <?php if($tipo_entrega == 'Dato Hora'){echo "selected";} ?> >Dato Hora</option>

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
                                require_once 'conexion.php'; 
                                $nombre_nuevo = $_REQUEST['nombre'];
                                $script = $_REQUEST['script'];
                                $name = $_REQUEST['name'];
                                $tipo_entrega = $_REQUEST['tipo_entrega'];

                                $sql = "UPDATE elementos_llegada SET
                                    nombre_elemento = '$nombre_nuevo',
                                    script_elemento = '$script',
                                    tipo_entrega = '$tipo_entrega',
                                    name = '$name'
                                    WHERE elemento_id = '$id'
                                    ";
                                $mysqli->query($sql);    
                            ?>
                            <script type="text/javascript">
                                window.location.assign("elementos_panel.php");
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