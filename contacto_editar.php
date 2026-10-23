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
                            require_once('conexion.php');
                            $consulta = "SELECT * FROM  tickets WHERE id_ticket = '$id_ticket_mensajeria'";
                            if ($resultado = $mysqli->query($consulta)) {
                                $obj = $resultado->fetch_object();
                                $mensaje_inicial = $obj->mensaje_inicial;
                                $status = $obj->estatus_ticket;
                                $resultado->close();
                            }
                            ?>
                            <!-- inicio contenido -->
                            <br>
                            <h2 style="font-size:25px;">Comunicación del Ticket :
                                <?php echo $id_ticket_mensajeria; ?>
                            </h2> <br>
                            <hr>

                            <form method="post" enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']; ?>">

                                <select name="estatus_ticket">
                                    <option <?php if ($status == 'Creado') {
                                        echo "selected";
                                    } ?>>Creado</option>
                                    <option <?php if ($status == 'Atendiendo') {
                                        echo "selected";
                                    } ?>>Atendiendo</option>
                                    <option <?php if ($status == 'Cerrado') {
                                        echo "selected";
                                    } ?>>Cerrado</option>
                                </select>

                                <br><br>
                                <div class="text-center">
                                    <input class="btn btn-success btn-rounded" type='submit' name='Alta'
                                        value='Guardar' />
                                    <a class="btn btn-success btn-rounded" href="contacto_panel.php">Regresar</a>
                                </div>


                            </form>
                            <?php
                            if (isset($_REQUEST['Alta'])) {
                                $id_ticket_mensajeria = $_GET['id_ticket'];
                                $estatus_ticket = $_REQUEST['estatus_ticket'];

                                require_once('conexion.php');
                                $sql = "UPDATE tickets SET
                                estatus_ticket = '$estatus_ticket'
                                WHERE id_ticket = '$id_ticket_mensajeria'";
                                $mysqli->query($sql);


                                ?>
                                <script type="text/javascript">
                                    window.location.assign("contacto_panel.php");
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
</body>

</html>