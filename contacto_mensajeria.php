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

                            <?php
                            $id_ticket_mensajeria = $_GET['id_ticket'];
                            $id_mensaje_creador = $_SESSION['user_id'];
                            date_default_timezone_set('america/mexico_city');
                            $fecha_mensaje_creacion = date('Y/m/d', time());
                            $hora_mensaje = date('H:i:s', time());
                            require_once('conexion.php');
                            $consulta = "SELECT * FROM  tickets WHERE id_ticket = '$id_ticket_mensajeria'";
                            if ($resultado = $mysqli->query($consulta)) {
                                $obj = $resultado->fetch_object();
                                $mensaje_inicial = $obj->mensaje_inicial;
                                $resultado->close();
                            }
                            ?>
                            <!-- inicio contenido -->
                            <br>
                            <h2 style="font-size:25px;">Comunicación del Ticket :
                                <?php echo $id_ticket_mensajeria; ?>
                            </h2> <br>
                            <hr>
                            <div align="center">
                                <br>
                                <h2 style="font-size:25px;">Mensaje</h2>
                                <textarea name='texto_mensaje' cols="50" rows="5"
                                    readonly><?php echo $mensaje_inicial; ?></textarea>
                                <br><br>
                            </div>
                            <br>
                            <div class="text-center">
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
</body>

</html>