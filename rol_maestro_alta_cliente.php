<?php include('pass.php');
require_once('conexion.php');
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
                                <h2 style="font-size:25px;">Alta de Visita</h2>

                                <?php
                                $id_cliente = $_SESSION['user_id'];
                                
                                ?>
                                <h6><b>Cliente:</b></h6>
                                <select name="rol_id_tienda" id="btn_store" required>
                                    <option value="" hidden>Seleccione</option>
                                    <?php
                                    $sql = "SELECT * FROM relacion_m_t_c INNER JOIN tienda ON relacion_m_t_c.relacion_mtc_tienda_id = tienda.tienda_id WHERE tienda.id_administrador = '$id_cliente'";
                                    if ($resql = $mysqli->query($sql)) {
                                        while ($obsql = $resql->fetch_object()) {
                                            ?>
                                            <option value="<?php echo $obsql->relacion_mtc_tienda_id; ?>"><?php echo $obsql->nombre_tienda; ?></option>
                                            <?php
                                        }
                                        $resql->close();
                                    }
                                    ?>
                                </select>
                                <br><br>



                                <h6><b>Fecha Programada:</b></h6>
                                <input type='date' name='fecha_programada_visita_rol'
                                    value="<?php echo $_GET['fecha']; ?>" required />
                                <br><br>

                                <h6><b>Hora Programada:</b></h6>
                                <input type="time" name='hora_programada_visita_rol' required />
                                <br><br>

                                <h6><b>Técnico:</b></h6>
                                <select id="empleado" name="colaborador_id_asignado_rol" required>
                                    <option value="" hidden>Seleccione</option>
                                    <?php
                                    $sql = "SELECT * FROM colaboradores WHERE id_administrador = $id_cliente";
                                    if ($resql = $mysqli->query($sql)) {
                                        while ($obsql = $resql->fetch_object()) {
                                            ?>
                                            <option value="<?php echo $obsql->col_usuario_id; ?>"><?php echo $obsql->nombre_col . ' ' . $obsql->apellido_col; ?></option>
                                            <?php
                                        }
                                        $resql->close();
                                    }
                                    ?>
                                </select>
                                <br><br>


                                <br>
                                <div class="text-center">

                                    <input class="btn btn-success btn-rounded" type='submit' name='Terminar'
                                        value='Terminar' />
                                    <input class="btn btn-success btn-rounded" type='submit' name='Otra' value='Otra' />

                                </div>
                            </form>
                        </div>
                        <?php
                        if (isset($_REQUEST['Terminar'])) {

                            
                             //buscamos la marca
                             $sql = "SELECT * FROM marcas WHERE id_usuario = $id_cliente";
                             if ($resql = $mysqli->query($sql)){
                                 $obsql = $resql->fetch_object();
                                 $id_marca = $obsql->marca_id;
                                 $resql->close();
                             }   

                            $rol_id_tienda = $_REQUEST['rol_id_tienda'];

                            //buscamos el id de orden de trabajo
                            $sql = "SELECT * FROM folio_orden_trabajo";
                            if ($resX = $mysqli->query($sql)) {
                                $obX = $resX->fetch_object();
                                $rol_id_orden_trabajo = $obX->id_orden_trabajo;
                                $resX->close();
                            }

                            $fecha_programada_visita_rol = $_REQUEST['fecha_programada_visita_rol'];
                            $hora_programada_visita_rol = $_REQUEST['hora_programada_visita_rol'];
                            $usuario_id_creador_rol = $_SESSION['user_id'];
                            $colaborador_id_asignado_rol = $_REQUEST['colaborador_id_asignado_rol'];


                            $sql = "INSERT INTO rol_maestro_misiones SET
                                rol_marca_id = '$id_marca',
                                rol_id_tienda = '$rol_id_tienda',
                                rol_id_orden_trabajo = '$rol_id_orden_trabajo',
                                fecha_hora_creacion_visita_rol = now(),
                                fecha_programada_visita_rol = '$fecha_programada_visita_rol',
                                hora_programada_visita_rol = '$hora_programada_visita_rol',
                                usuario_id_creador_rol = '$usuario_id_creador_rol',
                                colaborador_id_asignado_rol = '$colaborador_id_asignado_rol'
                                ";
                            $mysqli->query($sql);


                            //actualizamos el id de orden de trabajo
                            $sql = "UPDATE folio_orden_trabajo SET id_orden_trabajo = id_orden_trabajo + 1";
                            $mysqli->query($sql)


                                ?>
                            <script type="text/javascript">
                                alert('Se ha dado de alta el item.');
                                window.location.assign("calendario.php");
                            </script>
                            <?php

                        }

                        if (isset($_REQUEST['Otra'])) {


                            //buscamos la marca
                            $sql = "SELECT * FROM marcas WHERE id_usuario = $id_cliente";
                            if ($resql = $mysqli->query($sql)){
                                $obsql = $resql->fetch_object();
                                $id_marca = $obsql->marca_id;
                                $resql->close();
                            }   
                            
                            $rol_id_tienda = $_REQUEST['rol_id_tienda'];

                            //buscamos el id de orden de trabajo
                            $sql = "SELECT * FROM folio_orden_trabajo";
                            if ($resX = $mysqli->query($sql)) {
                                $obX = $resX->fetch_object();
                                $rol_id_orden_trabajo = $obX->id_orden_trabajo;
                                $resX->close();
                            }

                            $fecha_programada_visita_rol = $_REQUEST['fecha_programada_visita_rol'];
                            $hora_programada_visita_rol = $_REQUEST['hora_programada_visita_rol'];
                            $usuario_id_creador_rol = $_SESSION['user_id'];
                            $colaborador_id_asignado_rol = $_REQUEST['colaborador_id_asignado_rol'];


                            $sql = "INSERT INTO rol_maestro_misiones SET
                                rol_marca_id = '$id_marca',
                                rol_id_tienda = '$rol_id_tienda',
                                rol_id_orden_trabajo = '$rol_id_orden_trabajo',
                                fecha_hora_creacion_visita_rol = now(),
                                fecha_programada_visita_rol = '$fecha_programada_visita_rol',
                                hora_programada_visita_rol = '$hora_programada_visita_rol',
                                usuario_id_creador_rol = '$usuario_id_creador_rol',
                                colaborador_id_asignado_rol = '$colaborador_id_asignado_rol'
                                ";
                            $mysqli->query($sql);


                            ?>
                            <script type="text/javascript">

                                window.location.assign("rol_maestro_alta_cliente.php");
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>

    <script>

        $("#empleado").select2({
            placeholder: "Selecciona",
            allowClear: true
        });
    </script>
</body>

</html>