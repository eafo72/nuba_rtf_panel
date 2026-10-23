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

                                    <?php
                                    require_once("conexion.php");
                                    $id=$_GET['id'];
                                    $consulta = "SELECT * FROM marcas WHERE marca_id = $id";
                                    $resultado = $mysqli->query($consulta);
                                    $obj = $resultado->fetch_object();
                                    $nombre_marca = $obj->nombre_marca;
                                    $resultado->close();
                                    ?>
                                    <h2 style="font-size:25px;">Relacionar Empresa : <?php echo $nombre_marca; ?></h2>
                                    <br>
                                    <h6><b>Objetivo:</b></h6>     
                                    <select id="objective" name="relacion_om_objetivo_id" required>
                                        <option value="" hidden>Seleccione</option>
                                        <?php
                                        require_once('conexion.php');
                                        $sql = "SELECT * FROM objetivos";
                                        if ($resql = $mysqli->query($sql)){
                                            while ($obsql = $resql->fetch_object()){
                                        ?>   
                                        <option value="<?php echo $obsql->objetivo_id.'/'.$obsql->tipo_objetivo; ?>"><?php echo $obsql->nombre_objetivo; ?></option>
                                        <?php
                                            }
                                            $resql->close();
                                        }
                                        ?>
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

                                $relacion_om_mtc_id = $_GET['id'];


                                $pack_relacion_om_objetivo_id = explode("/",$_REQUEST['relacion_om_objetivo_id']);
                                $relacion_om_objetivo_id = $pack_relacion_om_objetivo_id[0];
                                $tipo_objetivo = $pack_relacion_om_objetivo_id[1];

                                //ponemos si en marcas incluye_inventario en caso de q sea tipo inventario el objetivo
                                if($tipo_objetivo == 'Inventario'){
                                    $sql = "UPDATE marcas SET incluye_inventario = 'si' WHERE marca_id = '$relacion_om_mtc_id'";
                                    $mysqli->query($sql);    
                                }

                                $sql = "INSERT INTO relacion_o_m SET
                                relacion_om_mtc_id = '$relacion_om_mtc_id', 
                                relacion_om_objetivo_id = '$relacion_om_objetivo_id'
                                ";
                                $mysqli->query($sql);    
                            ?>
                            <script type="text/javascript">
                                
                                var js = "<?php echo $id; ?>";
                                window.location.assign("marcas_relacionar_obj.php?id="+js);
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
        <script>
            $("#objective").select2( {
                placeholder: "Selecciona",
                allowClear: true
            } );
        </script>
    </body>
</html>