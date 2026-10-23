<?php include ('pass.php'); ?>
<!DOCTYPE html>
<html lang="en">
<?php include ('cabecera_panel.php'); ?>

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
                    <div class="row">
                        <div class="col-12">
                            
                            <h4 >Técnicos:</h4>
                                <ol class="breadcrumb mb-4">
                                    <li class="breadcrumb-item"><a href="admin.php">Inicio </a></li>
                                    <li class="breadcrumb-item active">Técnicos</li>
                                </ol>

                                <button onclick="upsection();" class="btn btn-success btn-rounded"><i
                                        class="fa fa-plus-circle m-r-5"></i> Alta</button>
                                <br><br>

                                <div class="card mb-4">
                                    <div class="card-header"><i class="fas fa-table mr-1"></i>Técnicos</div>
                                    <div class="card-body">

                                        <div class="table-responsive" id="colaboradores-container">
                                            <table id="colaboradores"
                                                class="records_list table  table-bordered dt-responsive nowrap"
                                                cellspacing="0" width="100%">


                                                <?php
                                                require_once 'conexion.php';
                                                if ($_SESSION['permisos'] == "Administrador" or $_SESSION['permisos'] == "Cliente") {
                                                    ?>
                                                    <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Id Usuario</th>
                                                            <th>Nombres</th>
                                                            <th>Apellidos</th>
                                                            <th>Nombre de Usuario</th>
                                                            <th>Edad</th>
                                                            <th>Género</th>
                                                            <th>Estudios</th>
                                                            <th>Contrato</th>
                                                            <th>Foto</th>
                                                            <th>Opciones</th>
                                                        </tr>
                                                    </thead>
                                                    <!-- <tfoot>
                                            <tr>
                                                <th style="max-width:30px;overflow:auto;">Filter..</th>
                                                <th style="max-width:30px;overflow:auto;">Filter..</th>
                                                <th style="max-width:30px;overflow:auto;">Filter..</th>
                                                <th style="max-width:30px;overflow:auto;">Filter..</th>
                                                <th style="max-width:30px;overflow:auto;">Filter..</th>
                                                <th style="max-width:30px;overflow:auto;">Filter..</th>
                                                <th style="max-width:30px;overflow:auto;">Filter..</th>
                                                <th style="max-width:30px;overflow:auto;">Filter..</th>
                                                <th style="max-width:30px;overflow:auto;">Filter..</th>
                                                <th style="max-width:30px;overflow:auto;">Filter..</th>
                                            </tr>
                                        </tfoot>
                                        -->
                                                    <tbody>
                                                        <?php
                                                        if ($_SESSION['permisos'] == 'Cliente') {
                                                            $id_administrador = $_SESSION['user_id'];
                                                            $consulta = "SELECT * FROM colaboradores INNER JOIN usuarios ON colaboradores.col_usuario_id = usuarios.usuario_id WHERE id_administrador = $id_administrador";
                                                        } else if ($_SESSION['permisos'] == 'Administrador') {
                                                            $consulta = "SELECT * FROM colaboradores  INNER JOIN usuarios ON colaboradores.col_usuario_id = usuarios.usuario_id";
                                                        }


                                                        if ($resultado = $mysqli->query($consulta)) {
                                                            while ($obj = $resultado->fetch_object()) {
                                                                ?>
                                                                <tr>
                                                                    <td style="max-width:30px;overflow:auto;">
                                                                        <h6>
                                                                            <?php echo $obj->colaborador_id; ?>
                                                                        </h6>
                                                                    </td>
                                                                    <td style="max-width:30px;overflow:auto;">
                                                                        <h6>
                                                                            <?php echo $obj->col_usuario_id; ?>
                                                                        </h6>
                                                                    </td>
                                                                    <td style="max-width:30px;overflow:auto;">
                                                                        <h6>
                                                                            <?php echo $obj->nombre_col; ?>
                                                                        </h6>
                                                                    </td>
                                                                    <td style="max-width:30px;overflow:auto;">
                                                                        <h6>
                                                                            <?php echo $obj->apellido_col; ?>
                                                                        </h6>
                                                                    </td>
                                                                    <td style="max-width:30px;overflow:auto;">
                                                                        <h6>
                                                                            <?php echo $obj->nombre_usuario; ?>
                                                                        </h6>
                                                                    </td>
                                                                    <td style="max-width:30px;overflow:auto;">
                                                                        <h6>
                                                                            <?php echo $obj->edad; ?>
                                                                        </h6>
                                                                    </td>
                                                                    <td style="max-width:30px;overflow:auto;">
                                                                        <h6>
                                                                            <?php echo $obj->genero; ?>
                                                                        </h6>
                                                                    </td>
                                                                    <td style="max-width:30px;overflow:auto;">
                                                                        <h6>
                                                                            <?php echo $obj->estudios; ?>
                                                                        </h6>
                                                                    </td>
                                                                    <td style="max-width:30px;overflow:auto;">
                                                                        <h6>
                                                                            <?php echo $obj->contrato; ?>
                                                                        </h6>
                                                                    </td>
                                                                    <td style="max-width:30px;overflow:auto;">
                                                                        <h6>
                                                                            <?php echo $obj->foto; ?>
                                                                        </h6>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        echo "<a href='colaboradores_editar.php?id=$obj->colaborador_id' style='width:20px;' aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Editar'><i class='fa fa-edit'></i></a>"; ?>

                                                                        <?php echo "<a href='colaboradores_borrar.php?id=$obj->colaborador_id' style='width:20px;'  aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Borrar'><i class='fa fa-eraser'></i></a>"; ?>

                                                                        <?php
                                                                        $sql = "SELECT * FROM usuarios WHERE usuario_id = $obj->col_usuario_id";
                                                                        if ($resql = $mysqli->query($sql)) {
                                                                            $obsql = $resql->fetch_object();
                                                                            $estado = $obsql->estado;
                                                                            $resql->close();
                                                                        }
                                                                        ?>

                                                                        <?php
                                                                        if ($estado == 'Activo') {
                                                                            echo "<a href='clientes_desactivar_colaborador.php?id=$obj->col_usuario_id' style='width:20px;color:red;'  aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Desactivar'><i class='fa fa-times'></i></a>";
                                                                        }
                                                                        ?>

                                                                        <?php
                                                                        if ($estado == 'Inactivo') {
                                                                            echo "<a href='clientes_activar_colaborador.php?id=$obj->col_usuario_id' style='width:20px;color:green;'  aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Activar'><i class='fa fa-check'></i></a>";
                                                                        }
                                                                        ?>

                                                                        <?php
                                                                        echo "<a href='colaboradores_password.php?id=$obj->col_usuario_id' style='width:20px;'  aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Cambiar Password'><i class='fa fa-key'></i></a>";
                                                                        ?>


                                                                    </td>
                                                                </tr>
                                                                <?php
                                                            }
                                                            $resultado->close();
                                                        }
                                                    /*fin de tabla administrador */
                                                }

                                                if ($_SESSION['permisos'] == "Veremos_luego") {
                                                    ?>

                                                        <thead>
                                                            <tr>
                                                                <th><i>Id</i></th>
                                                                <th><i>Nombres</i></th>
                                                                <th><i>Apellidos</i></th>
                                                                <th><i>Foto</i></th>
                                                                <th><i>Asignaciones</i></th>
                                                                <th><i>%Entregas</i></th>
                                                                <th><i>%EnFecha</i></th>
                                                                <th><i>%EnTiempo</i></th>
                                                                <th><i>Opciones</i></th>
                                                            </tr>
                                                        </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th style="max-width:30px;overflow:auto;">Filter..</th>
                                                            <th style="max-width:30px;overflow:auto;">Filter..</th>
                                                            <th style="max-width:30px;overflow:auto;">Filter..</th>
                                                            <th style="max-width:30px;overflow:auto;">Filter..</th>
                                                            <th style="max-width:30px;overflow:auto;">Filter..</th>
                                                            <th style="max-width:30px;overflow:auto;">Filter..</th>
                                                            <th style="max-width:30px;overflow:auto;">Filter..</th>
                                                            <th style="max-width:30px;overflow:auto;">Filter..</th>
                                                            <th style="max-width:30px;overflow:auto;">Filter..</th>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>
                                                        <?php
                                                        $id_user = $_SESSION['user_id'];
                                                        $consulta = "SELECT DISTINCT colaborador_id, col_usuario_id, nombre_col, apellido_col,  foto FROM `rol_maestro_misiones` INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id INNER JOIN colaboradores ON rol_maestro_misiones.colaborador_id_asignado_rol = colaboradores.col_usuario_id WHERE mar_cliente_id = '$id_user'";
                                                        if ($resultado = $mysqli->query($consulta)) {
                                                            while ($obj = $resultado->fetch_object()) {

                                                                $consultas = "SELECT * FROM `rol_maestro_misiones` INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id WHERE mar_cliente_id = '$id_user' AND colaborador_id_asignado_rol = '$obj->col_usuario_id'  ";
                                                                if ($resultados = $mysqli->query($consultas)) {
                                                                    $numasignaciones = $resultados->num_rows;
                                                                    $resultados->close();
                                                                }

                                                                $consultaz = "SELECT * FROM `rol_maestro_misiones` INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id INNER JOIN misiones ON rol_maestro_misiones.rol_id_orden_trabajo = misiones.mision_id_orden_trabajo WHERE mar_cliente_id = '$id_user' AND colaborador_id_asignado_rol = '$obj->col_usuario_id'  ";
                                                                if ($resultadoz = $mysqli->query($consultaz)) {
                                                                    $numentregas = $resultadoz->num_rows;
                                                                    $resultadoz->close();
                                                                }

                                                                $porentregas = ($numasignaciones / $numentregas) * 100;

                                                                $consultar = "SELECT * FROM `rol_maestro_misiones` INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id INNER JOIN misiones ON rol_maestro_misiones.rol_id_orden_trabajo = misiones.mision_id_orden_trabajo WHERE mar_cliente_id = '$id_user' AND colaborador_id_asignado_rol = '$obj->col_usuario_id' AND fecha_inicio_mision <= fecha_programada_visita_rol  ";
                                                                if ($resultador = $mysqli->query($consultar)) {
                                                                    $numenfecha = $resultador->num_rows;
                                                                    $resultador->close();
                                                                }

                                                                $porenfecha = ($numasignaciones / $numenfecha) * 100;

                                                                $consultap = "SELECT * FROM `rol_maestro_misiones` INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id INNER JOIN misiones ON rol_maestro_misiones.rol_id_orden_trabajo = misiones.mision_id_orden_trabajo WHERE mar_cliente_id = '$id_user' AND colaborador_id_asignado_rol = '$obj->col_usuario_id' AND hora_inicio_mision > hora_programada_visita_rol  ";
                                                                if ($resultadop = $mysqli->query($consultap)) {
                                                                    $numentiempo = $resultadop->num_rows;
                                                                    $resultadop->close();
                                                                }

                                                                $porentiempo = (($numasignaciones / $numentiempo) * 100) - 100;
                                                                ?>
                                                                <tr>

                                                                    <td style="max-width:30px;overflow:auto;">
                                                                        <h6>
                                                                            <?php echo $obj->colaborador_id; ?>
                                                                        </h6>
                                                                    </td>

                                                                    <td style="max-width:30px;overflow:auto;">
                                                                        <h6>
                                                                            <?php echo $obj->nombre_col; ?>
                                                                        </h6>
                                                                    </td>

                                                                    <td style="max-width:30px;overflow:auto;">
                                                                        <h6>
                                                                            <?php echo $obj->apellido_col; ?>
                                                                        </h6>
                                                                    </td>

                                                                    <td style="max-width:30px;overflow:auto;">
                                                                        <h6>
                                                                            <?php echo $obj->foto; ?>
                                                                        </h6>
                                                                    </td>

                                                                    <!-- Trabajos colaborador -->

                                                                    <td style="max-width:30px;overflow:auto;">
                                                                        <h6>
                                                                            <?php echo $numasignaciones; ?>
                                                                        </h6>
                                                                    </td>
                                                                    <td style="max-width:30px;overflow:auto;">
                                                                        <h6>
                                                                            <?php if ($porentregas == INF) {
                                                                                echo "sin datos";
                                                                            } else {
                                                                                echo $porentregas . "%";
                                                                            }
                                                                            ?>
                                                                        </h6>
                                                                    </td>
                                                                    <td style="max-width:30px;overflow:auto;">
                                                                        <h6>
                                                                            <?php if ($porenfecha == INF) {
                                                                                echo "sin datos";
                                                                            } else {
                                                                                echo $porenfecha . "%";
                                                                            }
                                                                            ?>
                                                                        </h6>
                                                                    </td>
                                                                    <td style="max-width:30px;overflow:auto;">
                                                                        <h6>
                                                                            <?php if ($porentiempo == INF) {
                                                                                echo "sin datos";
                                                                            } else {
                                                                                echo $porentiempo . "%";
                                                                            }
                                                                            ?>
                                                                        </h6>
                                                                    </td>

                                                                    <td style="max-width:30px;overflow:auto;">
                                                                        <?php
                                                                        echo "<a href='misiones_panel.php?ser=$obj->colaborador_id' style='width:20px;'  aria-hidden='true'  data-placement='top' title='Editar'><i class='fa fa-eye'></i></a>"; ?>
                                                                    </td>
                                                                    <td style="max-width:1px;overflow:auto;">
                                                                        <h6>
                                                                        </h6>
                                                                    </td>

                                                                </tr>
                                                                <!-- Fin Trabajos colaborador -->
                                                                <?php
                                                            }
                                                            $resultado->close();
                                                        }
                                                    /*fin de tabla Cliente */
                                                }

                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <!-- fin contenido -->
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
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            /*
            $('#colaboradores tfoot th').each( function () {
                var title = $(this).text();
                $(this).html( '<input type="text" placeholder="Filtrar.." />' );
            } );
            */
            var table = $('#colaboradores').DataTable({
                "responsive": false,
                "stateSave": true,
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "order": [[0, "asc"]],
            });
        });
    </script>
    <script>
        function upsection() {
            window.location.assign("colaboradores_alta.php");
        }
    </script>
</body>

</html>