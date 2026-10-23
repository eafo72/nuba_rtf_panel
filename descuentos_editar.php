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
                                    <h2 style="font-size:25px;">Editar Código de Descuento</h2>
                                    <?php
                                    $id=$_GET['id'];
                                    $consulta = "SELECT * FROM descuentos WHERE id_descuentos = $id";
                                    $resultado = $mysqli->query($consulta);
                                    $obj = $resultado->fetch_object();
                                    
                                    $codigo = $obj->codigo; 
                                    $porcentaje = $obj->porcentaje;
                                    $status = $obj->status;
                                                                        
                                    $resultado->close();
                                    ?>
                                   
                                    <br>

                                    <h6><b>Código:</b></h6>     
                                    <input type='text' name='codigo' value="<?php echo $codigo;?>"/>
                                    <br><br>

                                    <h6><b>Porcentaje:</b></h6>     
                                    <input type='number' name='porcentaje' step="any" value="<?php echo $porcentaje;?>"/>
                                    <br><br>

                                    <h6><b>Status:</b></h6>     
                                    <select name="status" required>
                                        <option value="" hidden>Seleccione</option>
                                        <option <?php if($status == 'Activo'){echo "selected";} ?> >Activo</option>
                                        <option <?php if($status == 'Pausado'){echo "selected";} ?> >Pausado</option>
                                    </select>
                                    <br><br>


                                    <br><br>      
                                    <div class="text-center">
                                        <input  class="btn btn-success btn-rounded" type="submit" name="Editar"   value="Guardar"/>
                                    </div>    
                                    <br>
                                </form>
                            </div>
                            <?php
                            if(isset($_REQUEST['Editar'])){

                                $codigo = $_REQUEST['codigo'];           
                                $porcentaje = $_REQUEST['porcentaje'];           
                                $status = $_REQUEST['status'];           

                                require_once 'conexion.php'; 
                                
                                $sql = "UPDATE descuentos SET
                                    codigo = '$codigo',
                                    porcentaje = '$porcentaje',
                                    status = '$status'
                                    WHERE id_descuentos = '$id'
                                    ";
                                $mysqli->query($sql);    
                            ?>
                            <script type="text/javascript">
                                window.location.assign("descuentos_panel.php");
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