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
                                    <h2 style="font-size:25px;">Editar Item del Rol Maestro</h2>
                                    <?php
                                    require_once("conexion.php");
                                    $id=$_GET['id'];
                                    $consulta = "SELECT * FROM rol_maestro_misiones WHERE rol_maestro_id = '$id'";
                                    $resultado = $mysqli->query($consulta);
                                    $obj = $resultado->fetch_object();
                                    $fecha_programada_visita_rol = $obj->fecha_programada_visita_rol;
                                    $hora_programada_visita_rol = $obj->hora_programada_visita_rol;
                                    $colaborador_id_asignado_rol = $obj->colaborador_id_asignado_rol;
                                    $resultado->close();
                                    ?>

                                    <h6><b>Fecha Programada:</b></h6>     
                                    <input type='date' name='fecha_programada_visita_rol' value="<?php echo $fecha_programada_visita_rol; ?>"/>
                                    <br><br>

                                    <h6><b>Hora Programada:</b></h6>     
                                    <input type="time" name='hora_programada_visita_rol' value="<?php echo $hora_programada_visita_rol; ?>"/>
                                    <br><br>

                                    <h6><b>Técnico:</b></h6>     
                                    <select id="user" name="colaborador_id_asignado_rol">
                                        <?php
                                        $sql = "SELECT * FROM colaboradores";
                                        if ($resql = $mysqli->query($sql)){
                                            while ($obsql = $resql->fetch_object()){
                                        ?>
                                        <option value="<?php echo $obsql->col_usuario_id; ?>" <?php if($obsql->col_usuario_id == $colaborador_id_asignado_rol){echo "selected";} ?> ><?php echo $obsql->nombre_col.' '.$obsql->apellido_col; ?></option>
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
                                $fecha_programada_visita_rol = $_REQUEST['fecha_programada_visita_rol']; 
                                $hora_programada_visita_rol = $_REQUEST['hora_programada_visita_rol'];    
                                $colaborador_id_asignado_rol = $_REQUEST['colaborador_id_asignado_rol'];


                                $sql = "UPDATE rol_maestro_misiones SET
                                fecha_programada_visita_rol = '$fecha_programada_visita_rol',
                                hora_programada_visita_rol = '$hora_programada_visita_rol',
                                colaborador_id_asignado_rol = '$colaborador_id_asignado_rol'
                                WHERE rol_maestro_id = '$id'
                                ";
                                $mysqli->query($sql);    
                            ?>
                            <script type="text/javascript">
                                window.location.assign("rol_maestro_panel.php");
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
            $("#user").select2( {
                placeholder: "Selecciona",
                allowClear: true
            } );
        </script>
    </body>
</html>