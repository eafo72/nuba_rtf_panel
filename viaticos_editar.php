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
                                
                                <form method="post" enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']; ?>" >
                                    <div align="center">
                                        <br>
                                        <?php
                                        $id=$_GET['id'];
                                        $consulta = "SELECT * from viaticos where id_viatico = '$id'";
                                        $resultado = $mysqli->query($consulta);
                                        $obj = $resultado->fetch_object();
                                        ?>
                                        <h2 align="center" style="font-size:25px;">Edición de Cuenta para Gastos:</h2>
                                        <br>
                                        <h4>Técnico:</h4>
                                        <?php 
                                        $consult = "SELECT * FROM usuarios INNER JOIN colaboradores ON usuarios.usuario_id = colaboradores.col_usuario_id WHERE permisos = 'Colaborador' AND estado = 'Activo'"; 
                                        ?>
                                        <select name='asignado' required>
                                            <?php
                                            if($result = $mysqli->query($consult)) {
                                                ?>
                                                <option value="" hidden>Ninguno</option> 
                                                <?php
                                                while ($ivj = $result->fetch_object()){?>
                                                    <option value="<?php echo $ivj->usuario_id.','.$ivj->nombre_col.','.$ivj->apellido_col;?>" <?php if($ivj->usuario_id == $obj->id_asignado){echo("selected");}?> ><?php echo $ivj->nombre_col.' '.$ivj->apellido_col;?></option>
                                                    <?php 
                                                }
                                            }
                                            ?>
                                        </select>
                                        <?php 
                                        $result->close();
                                        ?> 
                                        <h4>Semana :</h4>
                                        <?php 
                                        $consult = "SELECT * FROM semanas"; 
                                        ?>
                                        <select name='id_semana'>
                                            <?php
                                            if($result = $mysqli->query($consult)) {
                                                while ($obT = $result->fetch_object()){?>
                                                    <option value="<?php printf($obT->id);?>" <?php if($obT->id == $obj->id_semana){echo("selected");}?>  ><?php printf($obT->nombre);?></option>
                                                    <?php                          
                                                }
                                            } 
                                            ?>
                                        </select>
                                        <?php 
                                        $result->close();
                                        ?>
                                        <br/><br/>
                                    </div>    
                                    <br>
                                    <div class="text-center">
                                        <input class="btn btn-success btn-rounded" type="submit" name="Alta" value="Registrar">
                                    </div>
                                </form>
                            </div>
                            <?php 
                            $resultado->close();
                            if(isset($_REQUEST['Alta'])){
                                $asignado = explode(',', $_REQUEST['asignado']);
                                $id_asignado = $asignado[0];
                                $nombre_asignado = $asignado[1].' '.$asignado[2];
                                $semana = $_REQUEST['id_semana'];

                                $alta = "UPDATE viaticos SET id_asignado = '$id_asignado', nombre_asignado = '$nombre_asignado', id_semana = '$semana' WHERE id_viatico = '$id'";
                                $mysqli->query($alta);
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