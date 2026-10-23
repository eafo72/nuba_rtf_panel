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
                                    <h2 style="font-size:25px;">Ver Objetivo</h2>
                                    <?php
                                    require_once("conexion.php");
                                    $id=$_GET['id'];
                                    $consulta = "SELECT * FROM objetivos WHERE objetivo_id = $id";
                                    $resultado = $mysqli->query($consulta);
                                    $obj = $resultado->fetch_object();
                                    $nombre = $obj->nombre_objetivo;
                                    $imagen = $obj->imagen_objetivo;
                                    $tipo = $obj->tipo_objetivo;
                                    $resultado->close();
                                    ?>
                                    <h2 align="center"><?php echo $nombre; ?></h2> 
                                    <br>
                                    <div class="row">
                                        <div class="col-xs-12 col-md-4"></div>
                                        <div class="col-xs-12 col-md-4">
                                            <img src="assets/images/<?php echo $imagen;?>" class="img-responsive text-center">
                                        </div>    
                                        <div class="col-xs-12 col-md-4"></div>

                                    </div>    
                                    <br>

                                    <!-- elementos -->
                                    <?php
                                    $sql="SELECT * FROM relacion_e_o WHERE relacion_eo_objetivo_id = '$id' ORDER BY relacion_eo_objetivo_id, orden_aparicion";
                                    if ($resql = $mysqli->query($sql)){
                                        $count = mysqli_num_rows($resql);
                                        if ($count > 0){
                                            while ($obsql = $resql->fetch_object()){
                                                //buscamos el script
                                                $sql="SELECT * FROM elementos_llegada WHERE elemento_id = '$obsql->relacion_eo_elementos_id'";
                                                if ($resQ = $mysqli->query($sql)){
                                                    $obQ = $resQ->fetch_object();
                                                    $script = $obQ->script_elemento;
                                                    $label = $obQ->nombre_elemento;
                                                    $name = $obQ->name;
                                                    $tipo_entrega = $obQ->tipo_entrega;
                                                    $resQ->close();
                                    ?>
                                    <div align="center">
                                        <label><?php echo $label; ?></label><br>
                                        <?php echo $script; ?>

                                        <input type="hidden" name="id_elemento[]" value="<?php echo $obsql->relacion_eo_elementos_id;?>">
                                        <input type="hidden" name="etiqueta_name[]" value="<?php echo $name;?>">
                                        <input type="hidden" name="tipo_dato_entrega[]" value="<?php echo $tipo_entrega;?>">
                                    </div><br><br>
                                    <?php
                                                }
                                            }
                                            $resql->close(); 
                                    ?>
                                    <input type="hidden" name="numero_elementos" value="<?php echo $count;?>">
                                    <?php
                                        }
                                    }
                                    ?>
                                    <br><br> 

                                    <br>      
                                    <div class="text-center">
                                        <a  class="btn btn-success btn-rounded" href="objetivo_panel.php" >Regresar</a>
                                    </div>    
                                    <br>
                                </form>
                            </div>  
                            <?php
                            if(isset($_REQUEST['Regresar'])){
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