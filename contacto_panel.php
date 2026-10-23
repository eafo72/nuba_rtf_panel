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
                        <div  class="col-12">
                            
                            <h4>Soporte:</h4>
                                <ol class="breadcrumb mb-4">
                                    <li class="breadcrumb-item"><a href="admin.php">Inicio </a></li>
                                    <li class="breadcrumb-item active">Soporte</li>
                                </ol>
                                <button onclick="upsection();" class="btn btn-success btn-rounded"><i
                                        class="fa fa-plus-circle m-r-5"></i> Crear Ticket </button>
                                <br><br>
                               
                                <div class="card mb-4">
                                    <div class="card-header"><i class="fas fa-table mr-1"></i>Soporte</div>
                                    <div class="card-body">
                                        <div class="table-responsive" id="mission-container">
                                            <table id="mission"
                                                class="records_list table  table-bordered dt-responsive nowrap"
                                                cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>Ticket</th>
                                                        <th>Fecha Creación</th>
                                                        <th>OT</th>
                                                        <th>Mensaje Inicial</th>
                                                        <th>Estatus</th>
                                                        <th>Ver</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php
                                                    require_once 'conexion.php';

                                                    if ($_SESSION['permisos'] == "Administrador") {
                                                        $consulta = "SELECT * FROM  tickets";
                                                    }
                                                    if ($_SESSION['permisos'] == "Cliente") {
                                                        $id_user = $_SESSION['user_id'];

                                                        $consulta = "SELECT * FROM  tickets WHERE cliente_id_ticket = '$id_user'";
                                                    }

                                                    if ($resultado = $mysqli->query($consulta)) {
                                                        while ($obj = $resultado->fetch_object()) {
                                                            ?>
                                                            <tr>

                                                                <td style="max-width:30px;overflow:auto;">
                                                                    <h6>
                                                                        <?php
                                                                        echo $obj->id_ticket;
                                                                        ?>
                                                                    </h6>
                                                                </td>
                                                                <td>
                                                                    <h6>
                                                                        <?php
                                                                        echo $obj->fecha_alta_ticket;
                                                                        ?>
                                                                    </h6>
                                                                </td>
                                                                <td>
                                                                    <h6>
                                                                        <?php
                                                                        echo $obj->ot_ticket;
                                                                        ?>
                                                                    </h6>
                                                                </td>
                                                                <td>
                                                                    <h6>
                                                                        <?php
                                                                        echo $obj->mensaje_inicial;
                                                                        ?>
                                                                    </h6>
                                                                </td>
                                                                <td>
                                                                    <h6>
                                                                        <?php
                                                                        echo $obj->estatus_ticket;
                                                                        ?>
                                                                    </h6>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                    echo "<a href='contacto_mensajeria.php?id_ticket=$obj->id_ticket' style='width:20px;' aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Ver Mensaje'><i class='fa fa-eye'></i></a>";
                                                                    ?>

                                                                    <?php
                                                                    if ($_SESSION['permisos'] == 'Administrador') {
                                                                        echo "<a href='contacto_editar.php?id_ticket=$obj->id_ticket' style='width:20px;'  aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Editar'><i class='fa fa-edit'></i></a>";
                                                                    }
                                                                    ?>

                                                                    <?php
                                                                    if ($obj->estatus_ticket != 'Cerrado') {
                                                                        echo "<a href='contacto_chat.php?id_ticket=$obj->id_ticket' style='width:20px;'  aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Chat'><i class='fa fa-comment'></i></a>";
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
            var table = $('#mission').DataTable({
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
            window.location.assign("contacto_alta.php");
        }
    </script>
</body>

</html>