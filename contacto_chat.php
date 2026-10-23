<?php include('pass.php'); ?>
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

                            <h2 style="font-size:25px;">Chat:</h2>
                            <?php
                            $id_ticket = $_GET['id_ticket'];
                            ?>
                            <h6>Ticket :
                                <?php echo $id_ticket; ?>
                            </h6>

                            <a class="btn btn-success btn-rounded"
                                href="chat_alta.php?id_ticket=<?php echo $id_ticket; ?>"><i
                                    class="fa fa-plus-circle m-r-5"></i> Comentar</a>
                            <br><br>
                            <table id="chat" class="table  table-bordered dt-responsive nowrap"
                                cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><i>Fecha</i></th>
                                        <th><i>Usuario</i></th>
                                        <th><i>Comentario</i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $id_ticket = $_GET['id_ticket'];
                                    require_once 'conexion.php';
                                    $consulta = "SELECT * FROM chat WHERE chat_id_ticket = '$id_ticket' ORDER BY chat_fecha,chat_id DESC";
                                    if ($resultado = $mysqli->query($consulta)) {
                                        while ($obj = $resultado->fetch_object()) {
                                            ?>
                                            <tr>
                                                <td style="max-width:30px;overflow:auto;">
                                                    <h6>
                                                        <?php
                                                        echo "$obj->chat_fecha"; ?>
                                                    </h6>
                                                </td>
                                                <td style="max-width:30px;overflow:auto;">
                                                    <h6>
                                                        <?php
                                                        $sql = "SELECT * FROM usuarios WHERE usuario_id = '$obj->chat_usuario'";
                                                        if ($resql = $mysqli->query($sql)) {
                                                            $obsql = $resql->fetch_object();
                                                            $user_name = $obsql->nombre_usuario;
                                                            echo $user_name;
                                                            $resql->close();
                                                        }
                                                        ?>
                                                    </h6>
                                                </td>
                                                <td style="max-width:30px;overflow:auto;">
                                                    <h6>
                                                        <?php
                                                        echo "$obj->chat_comentario"; ?>
                                                    </h6>
                                                </td>

                                            </tr>
                                        <?php
                                        }
                                        $resultado->close();
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <div align="center">
                                <a class="btn btn-success btn-rounded" href="contacto_panel.php">Regresar</a>
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
            var table = $('#chat').DataTable({
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
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</body>

</html>