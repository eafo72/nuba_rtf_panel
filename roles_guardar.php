<?php include('pass.php');?>
<!DOCTYPE html>
<html lang="en">
    <?php include('cabecera_panel.php'); ?>
    <body class="sb-nav-fixed">
        <?php include('preloader.php'); ?>
        <?php include('header.php'); ?>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <?php 
                include('menu_panel.php'); 
                $id_rol = $_GET['id'];
                $id_colaborador = $_GET['id_col'];
                $data  = $_GET['data'];
                ?>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <div class="row">
                            <div align="center" class="col-12">
                                <br>
                                <h2 style="font-size:25px;">Estás a punto de guardar la siguiente información en el ROL MAESTRO :</h2>
                                <h6><?php echo $data; ?></h6>
                                <h2 style="font-size:25px;" >Estás SEGURO ?</h2>
                                <br><br>

                                <form method="post">
                                    
                                    <input class="btn btn-success btn-rounded" type="submit" name="Guardar" value="Guardar">
                                    <input class="btn btn-success btn-rounded" type="submit" name="Cancelar" value="Cancelar">
                                </form> 
                                <?php
                                if(isset($_REQUEST['Guardar'])){
                                    require_once("conexion.php");
                                    $id_rol = $_GET['id'];
                                    $id_colaborador = $_GET['id_col'];
                                    
                                    $sql = "SELECT * FROM roles WHERE rol_maestro_id = '$id_rol' AND colaborador_id_asignado_rol = '$id_colaborador' AND seleccionado = 'Si'";
                                    if ($resql = $mysqli->query($sql)){
                                        while ($obsql = $resql->fetch_object()){
                                            $query = "INSERT INTO rol_maestro_misiones SET
                                            rol_marca_id = '$obsql->rol_marca_id',
                                            rol_id_tienda = '$obsql->rol_id_tienda',
                                            rol_id_orden_trabajo = '$obsql->rol_id_orden_trabajo',
                                            fecha_hora_creacion_visita_rol = '$obsql->fecha_hora_creacion_visita_rol',
                                            fecha_programada_visita_rol = '$obsql->fecha_programada_visita_rol',
                                            hora_programada_visita_rol = '$obsql->hora_programada_visita_rol',
                                            usuario_id_creador_rol = '$obsql->usuario_id_creador_rol',
                                            colaborador_id_asignado_rol  = '$obsql->colaborador_id_asignado_rol'
                                            ";
                                            $mysqli->query($query);
                                            
                                        }
                                        $resql->close();
                                    }
                                    
                                    $sql="DELETE FROM roles";
                                    $mysqli->query($sql);
                                    
                                    
                                    ?>
                                    <script type="text/javascript">
                                        alert('Guardado');
                                        window.location.assign("rol_main_panel.php");
                                    </script>
                                    <?php
                                }
                                
                                if(isset($_REQUEST['Cancelar'])){
                                    ?>
                                    <script type="text/javascript">
                                        alert('Operación cancelada');
                                        window.location.assign("rol_main_panel.php");
                                    </script>
                                    <?php
                                }
                                ?>
                            </div>     

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