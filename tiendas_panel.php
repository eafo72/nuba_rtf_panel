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
                           
                            <h4>Clientes:</h4>
                                <ol class="breadcrumb mb-4">
                                    <li class="breadcrumb-item"><a href="admin.php">Inicio </a></li>
                                    <li class="breadcrumb-item active">Clientes</li>
                                </ol>

                                <button onclick="upsection();" class="btn btn-success btn-rounded"><i
                                        class="fa fa-plus-circle m-r-5"></i> Alta</button>
                                <br><br>

                                <div class="card mb-4">
                                    <div class="card-header"><i class="fas fa-table mr-1"></i>Clientes</div>
                                    <div class="card-body">
                                        <div class="table-responsive" id="tiendas-container">
                                            <table id="tiendas"
                                                class="records_list table  table-bordered dt-responsive nowrap"
                                                cellspacing="0" width="100%">
                                                <!-- Inicio de tabla Admin -->
                                                <?php
                                                if ($_SESSION['permisos'] == "Administrador" or $_SESSION['permisos'] == "Cliente") {
                                                    ?>
                                                    <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Nombre</th>
                                                            <th>Ubicación</th>
                                                            <th>Geo</th>
                                                            <th>Encargado</th>
                                                            <th>Opciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        require_once 'conexion.php';

                                                        if ($_SESSION['permisos'] == 'Cliente') {
                                                            $id_administrador = $_SESSION['user_id'];
                                                            $consulta = "SELECT * FROM tienda WHERE id_administrador = $id_administrador";
                                                        } else if ($_SESSION['permisos'] == 'Administrador') {
                                                            $consulta = "SELECT * FROM tienda";
                                                        }



                                                        if ($resultado = $mysqli->query($consulta)) {
                                                            while ($obj = $resultado->fetch_object()) {
                                                                ?>
                                                                <tr>
                                                                    <td style="max-width:30px;overflow:auto;">
                                                                        <h6>
                                                                            <?php
                                                                            echo $obj->tienda_id;
                                                                            ?>
                                                                        </h6>
                                                                    </td>
                                                                    <td style="max-width:30px;overflow:auto;">
                                                                        <h6>
                                                                            <?php
                                                                            echo $obj->nombre_tienda;
                                                                            ?>
                                                                        </h6>
                                                                    </td>
                                                                    <td style="max-width:30px;overflow:auto;">
                                                                        <h6>
                                                                            <?php
                                                                            echo $obj->ubicacion_tienda;
                                                                            ?>
                                                                        </h6>
                                                                    </td>
                                                                    <td style="max-width:30px;overflow:auto;">
                                                                        <h6>
                                                                            <?php
                                                                            echo $obj->geo_tienda;
                                                                            ?>
                                                                        </h6>
                                                                    </td>
                                                                    <td style="max-width:30px;overflow:auto;">
                                                                        <h6>
                                                                            <?php
                                                                            echo $obj->encargado_tienda;
                                                                            ?>
                                                                        </h6>
                                                                    </td>

                                                                    <td>

                                                                        <?php
                                                                        echo "<a href='tiendas_editar.php?id=$obj->tienda_id' style='width:20px;'  aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Editar'><i class='fa fa-edit'></i></a>";
                                                                        ?>

                                                                        <?php
                                                                        echo "<a href='tiendas_borrar.php?id=$obj->tienda_id' style='width:20px;'  aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Borrar'><i class='fa fa-eraser'></i></a>";
                                                                        ?>

                                                                        <?php
                                                                        echo "<a href='tiendas_relacionar_obj.php?id=$obj->tienda_id' style='width:20px;'  aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Relaciones con objetivos'><i class='fa fa-bullseye'></i></a>";
                                                                        ?>

                                                                        <?php
                                                                        if ($obj->codigoqr == 'Si') {
                                                                            echo "<a href='ver_qr.php?id=$obj->tienda_id' style='width:20px;'  aria-hidden='true' data-toggle='tooltip' data-placement='top' title='codigo QR'><i class='fa fa-qrcode'></i></a>";
                                                                        }
                                                                        ?>

                                                                    </td>
                                                                </tr>
                                                            <?php
                                                            }
                                                            $resultado->close();
                                                        }
                                                        ?>



                                                    </tbody>
                                                    <?php
                                                }
                                                ?>
                                                <!-- Fin de tabla Admin -->

                                                <!-- Inicio de tabla Cliente -->
                                                <?php
                                                if ($_SESSION['permisos'] == "Veremos_luego") {
                                                    $id_user = $_SESSION['user_id'];

                                                    require_once 'conexion.php';
                                                    $sql = "SELECT * FROM marcas WHERE mar_cliente_id = '$id_user'";
                                                    if ($resql = $mysqli->query($sql)) {
                                                        $obsql = $resql->fetch_object();
                                                        $id_marca = $obsql->marca_id;
                                                        $resql->close();
                                                    }
                                                    ?>
                                                    <thead>
                                                        <tr>
                                                            <th><i>Id</i></th>
                                                            <th><i>Nombre</i></th>
                                                            <th><i>Asignaciones</i></th>
                                                            <th><i>%Entregas</i></th>
                                                            <th><i>%EnFecha</i></th>
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
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>

                                                        <?php require_once 'conexion.php';
                                                        $consulta = "SELECT * FROM relacion_m_t_c INNER JOIN marcas on marcas.marca_id = relacion_m_t_c.relacion_mtc_marca_id INNER JOIN tienda on relacion_m_t_c.relacion_mtc_tienda_id = tienda.tienda_id WHERE mar_cliente_id = '$id_user' ";
                                                        if ($resultado = $mysqli->query($consulta)) {
                                                            while ($obj = $resultado->fetch_object()) {
                                                                ?>
                                                                <tr>
                                                                    <td style="max-width:30px;overflow:auto;">
                                                                        <h6>
                                                                            <?php echo $obj->tienda_id; ?>
                                                                        </h6>
                                                                    </td>
                                                                    <td style="max-width:30px;overflow:auto;">
                                                                        <h6>
                                                                            <?php echo $obj->nombre_tienda; ?>
                                                                        </h6>
                                                                    </td>
                                                                    <td style="max-width:30px;overflow:auto;">
                                                                        <h6>
                                                                            <?php

                                                                            $consultas = "SELECT * FROM `rol_maestro_misiones` INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id WHERE mar_cliente_id = '$id_user' AND rol_marca_id = '$obj->marca_id' AND rol_id_tienda = '$obj->tienda_id' ";
                                                                            if ($resultados = $mysqli->query($consultas)) {
                                                                                $numasignaciones = $resultados->num_rows;
                                                                                $resultados->close();
                                                                            }
                                                                            echo $numasignaciones;



                                                                            ?>
                                                                        </h6>
                                                                    </td>
                                                                    <td style="max-width:30px;overflow:auto;">
                                                                        <h6>
                                                                            <?php
                                                                            $consultas = "SELECT * FROM `rol_maestro_misiones` INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id INNER JOIN misiones ON rol_maestro_misiones.rol_id_orden_trabajo = misiones.mision_id_orden_trabajo WHERE mar_cliente_id = '$id_user' AND rol_marca_id = '$obj->marca_id' ";
                                                                            if ($resultados = $mysqli->query($consultas)) {
                                                                                $numentregas = $resultados->num_rows;
                                                                                $resultados->close();
                                                                            }
                                                                            $porentregas = ($numasignaciones / $numentregas) * 100;
                                                                            if ($numentregas == 0) {
                                                                                echo "sin entregas";
                                                                            } else {
                                                                                echo $porentregas . "%";
                                                                            }

                                                                            ?>
                                                                        </h6>
                                                                    </td>
                                                                    <td style="max-width:30px;overflow:auto;">
                                                                        <h6>
                                                                            <?php

                                                                            $consultas = "SELECT * FROM `rol_maestro_misiones` INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id INNER JOIN misiones ON rol_maestro_misiones.rol_id_orden_trabajo = misiones.mision_id_orden_trabajo WHERE mar_cliente_id = '$id_user' AND rol_marca_id = '$obj->marca_id' AND fecha_inicio_mision <= fecha_programada_visita_rol ";
                                                                            if ($resultados = $mysqli->query($consultas)) {
                                                                                $numenfecha = $resultados->num_rows;
                                                                                $resultados->close();
                                                                            }
                                                                            $porenfecha = ($numasignaciones / $numenfecha) * 100;
                                                                            if ($numenfecha == 0) {
                                                                                echo "sin entregas";
                                                                            } else {
                                                                                echo $porenfecha . "%";
                                                                            }


                                                                            ?>
                                                                        </h6>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        echo "<a href='misiones_panel.php?tie=$obj->tienda_id' style='width:20px;' class='fa fa-eye' aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Ver Misiones'></a>";
                                                                        ?>


                                                                    </td>
                                                                </tr>
                                                            <?php
                                                            }
                                                            $resultado->close();
                                                        }
                                                        ?>

                                                        <?php
                                                }
                                                ?>
                                                    <!-- Fin de tabla Cliente -->



                                            </table>
                                        </div>
                                    </div>
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
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            var table = $('#tiendas').DataTable({
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
            window.location.assign("tiendas_alta.php");
        }
    </script>
</body>

</html>