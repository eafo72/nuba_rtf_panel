<?php include ('pass.php'); ?>
<!DOCTYPE html>
<html lang="en">
<?php
include ('cabecera_panel.php');
$id_user = $_SESSION['user_id'];
?>

<body class="sb-nav-fixed">
    <?php include ('preloader.php'); ?>
    <?php include ('header.php'); ?>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include ('menu_panel.php'); ?>
        </div>


        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h4 >Actividad por Técnico</h4>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="admin.php">Inicio </a></li>
                        <li class="breadcrumb-item active">Actividad por Técnico</li>
                    </ol>
                    <div class="row">
                        <div class="col-12">
                            <form method="get">
                                <div class="row">
                                    <div class="col-6">


                                        <div class="form-group"> <!-- Date input -->
                                            <label class="control-label">Fecha Inicio</label>
                                            <input class="form-control" type="date" name="fecha_inicial"
                                                value="<?php if (isset($_GET['fecha_inicial'])) {
                                                    echo $_GET['fecha_inicial'];
                                                } ?>" />
                                        </div>

                                    </div>
                                    <div class="col-6">

                                        <div class="form-group"> <!-- Date input -->
                                            <label class="control-label">Fecha Final</label>
                                            <input class="form-control" type="date" name="fecha_final"
                                                value="<?php if (isset($_GET['fecha_final'])) {
                                                    echo $_GET['fecha_final'];
                                                } ?>" />
                                        </div>


                                    </div>
                                </div>
                                <div class="form-group"> <!-- Submit button -->
                                    <button class="btn btn-success " name="submit" type="submit">Filtrar</button>

                                </div>
                            </form>
                          
                        </div>

                        <div class="col-12">

                           

                            <div class="col-12 text-center">
                                <a href="promotores_excel.php" target="_blank" class="btn btn-success"> Exportar
                                    Excel</a>
                                <br><br>
                            </div>


                            <div class="card mb-4">
                                <div class="card-header"><i class="fas fa-table mr-1"></i>Actividad por Técnico</div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table " id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>OT</th>
                                                    <th>Técnico</th>
                                                    <th>Cliente</th>
                                                    <th>Programada</th>
                                                    <th>Reporte</th>
                                                    <th>Condición</th>
                                                    <th>Upload</th>
                                                    <th>Ver</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php
                                                require_once 'conexion.php';

                                                if (isset($_GET['fecha_inicial']) && isset($_GET['fecha_final'])) {
                                                    $fecha_inicial = $_GET['fecha_inicial'];
                                                    $fecha_final = $_GET['fecha_final'];

                                                    if ($_SESSION['permisos'] == "Administrador") {
                                                        $consulta = "SELECT * FROM  rol_maestro_misiones  INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id INNER JOIN colaboradores ON rol_maestro_misiones.colaborador_id_asignado_rol = colaboradores.col_usuario_id INNER JOIN relacion_m_t_c ON rol_maestro_misiones.rol_marca_id = relacion_m_t_c.relacion_mtc_marca_id and rol_maestro_misiones.rol_id_tienda = relacion_m_t_c.relacion_mtc_tienda_id INNER JOIN tienda ON relacion_m_t_c.relacion_mtc_tienda_id = tienda.tienda_id INNER JOIN cadena ON tienda.cadena_id_tienda = cadena.cadena_id WHERE rol_maestro_misiones.fecha_programada_visita_rol BETWEEN '$fecha_inicial' AND '$fecha_final' ORDER BY rol_id_orden_trabajo DESC";
                                                    }
                                                    if ($_SESSION['permisos'] == "Cliente") {
                                                        $id_user = $_SESSION['user_id'];
                                                        $consulta = "SELECT * FROM  rol_maestro_misiones  INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id INNER JOIN colaboradores ON rol_maestro_misiones.colaborador_id_asignado_rol = colaboradores.col_usuario_id INNER JOIN relacion_m_t_c ON rol_maestro_misiones.rol_marca_id = relacion_m_t_c.relacion_mtc_marca_id and rol_maestro_misiones.rol_id_tienda = relacion_m_t_c.relacion_mtc_tienda_id INNER JOIN tienda ON relacion_m_t_c.relacion_mtc_tienda_id = tienda.tienda_id INNER JOIN cadena ON tienda.cadena_id_tienda = cadena.cadena_id WHERE marcas.id_usuario = '$id_user' AND rol_maestro_misiones.fecha_programada_visita_rol BETWEEN '$fecha_inicial' AND '$fecha_final' ORDER BY rol_id_orden_trabajo DESC";
                                                    }
                                                } else {
                                                    if ($_SESSION['permisos'] == "Administrador") {
                                                        $consulta = 'SELECT * FROM  rol_maestro_misiones  INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id INNER JOIN colaboradores ON rol_maestro_misiones.colaborador_id_asignado_rol = colaboradores.col_usuario_id INNER JOIN relacion_m_t_c ON rol_maestro_misiones.rol_marca_id = relacion_m_t_c.relacion_mtc_marca_id and rol_maestro_misiones.rol_id_tienda = relacion_m_t_c.relacion_mtc_tienda_id INNER JOIN tienda ON relacion_m_t_c.relacion_mtc_tienda_id = tienda.tienda_id INNER JOIN cadena ON tienda.cadena_id_tienda = cadena.cadena_id ORDER BY rol_id_orden_trabajo DESC';
                                                    }
                                                    if ($_SESSION['permisos'] == "Cliente") {
                                                        $id_user = $_SESSION['user_id'];
                                                        $consulta = "SELECT * FROM  rol_maestro_misiones  INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id INNER JOIN colaboradores ON rol_maestro_misiones.colaborador_id_asignado_rol = colaboradores.col_usuario_id INNER JOIN relacion_m_t_c ON rol_maestro_misiones.rol_marca_id = relacion_m_t_c.relacion_mtc_marca_id and rol_maestro_misiones.rol_id_tienda = relacion_m_t_c.relacion_mtc_tienda_id INNER JOIN tienda ON relacion_m_t_c.relacion_mtc_tienda_id = tienda.tienda_id INNER JOIN cadena ON tienda.cadena_id_tienda = cadena.cadena_id WHERE marcas.id_usuario = '$id_user' ORDER BY rol_id_orden_trabajo DESC";
                                                    }
                                                }

                                                if ($resultado = $mysqli->query($consulta)) {
                                                    while ($obj = $resultado->fetch_object()) {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php
                                                                echo $obj->rol_id_orden_trabajo;
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                echo $obj->nombre_col . " " . $obj->apellido_col;
                                                                ?>
                                                            </td>

                                                            <td>
                                                                <?php
                                                                $sql = "SELECT * FROM tienda WHERE tienda_id = '$obj->rol_id_tienda'";
                                                                if ($resql = $mysqli->query($sql)) {
                                                                    $obsql = $resql->fetch_object();
                                                                    echo $obsql->nombre_tienda;
                                                                    $resql->close();
                                                                }
                                                                ?>
                                                            </td>


                                                            <td>
                                                                <?php
                                                                echo $obj->fecha_programada_visita_rol;
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                $sqlX = "SELECT * FROM misiones WHERE mision_rol_maestro_id = '$obj->rol_maestro_id'";
                                                                if ($resX = $mysqli->query($sqlX)) {
                                                                    $obsqlX = $resX->fetch_object();
                                                                    $status =  $obsqlX->status;
                                                                    $resX->close();
                                                                }

                                                                if($status == "SOS"){
                                                                    ?>
                                                                    <p>SOS</p>
                                                                    <?php
                                                                }else{

                                                                    if ($obj->fechayhorasubida == "0000-00-00 00:00:00" || $obj->fechayhorasubida == null) {
                                                                        ?>
                                                                        <p>Sin Iniciar</p>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <p>Entregado</p>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                if ($obj->fechayhorasubida != '0000-00-00 00:00:00') {
                                                                    $fecha_subida = date('Y-m-d', strtotime($obj->fechayhorasubida));
                                                                    if ($fecha_subida == $obj->fecha_programada_visita_rol) {
                                                                        ?>
                                                                        <p>Oportunamente </p>
                                                                    <?php
                                                                    } else {
                                                                        $programada = strtotime($obj->fecha_programada_visita_rol);
                                                                        $actividad = strtotime($obj->fechayhorasubida);
                                                                        $dif = ($actividad - $programada);
                                                                        if ($dif < 0) {
                                                                            ?>
                                                                            <p>Adelantado</p>
                                                                        <?php
                                                                        } else if ($dif > 0) {
                                                                            ?>
                                                                                <p>Retrasado </p>
                                                                        <?php
                                                                        }
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <p>Sin realizar</p>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                echo $obj->fechayhorasubida;
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                
                                                                    echo "<a href='consultar_tienda.php?id_ot=$obj->rol_id_orden_trabajo&tid=$obj->rol_id_tienda' style='width:20px; z-index:999;'>Ver</a>";
                                                                
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    $resultado->close();
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer small text-muted"></div>
                            </div>

                        </div>
                    </div>
                </div>
            </main>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>


    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>

    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

    <script>
        $(document).ready(function () {
            var table = $('#dataTable').DataTable({
                "responsive": false,
                "stateSave": true,
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "order": [[0, "asc"]],
            });
        });
    </script>

</body>

</html>