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
                            <br>
                            <h2 style="font-size:25px;" id="titulopagina">Códigos de descuento:</h2>

                            <button onclick="upsection();" class="btn btn-success btn-rounded"><i
                                    class="fa fa-plus-circle m-r-5"></i> Alta</button>
                            <br><br>

                            <br><br>
                            <div class="table-responsive" id="colaboradores-container">
                                <table id="descuentos"
                                    class="records_list table  table-bordered dt-responsive nowrap"
                                    cellspacing="0" width="100%">


                                    <?php
                                    require_once 'conexion.php';
                                    if ($_SESSION['permisos'] == "Administrador" or $_SESSION['permisos'] == "Cliente") {
                                        ?>
                                        <thead>
                                            <tr>
                                                <th><i>Id</i></th>
                                                <th><i>Código</i></th>
                                                <th><i>Porcentaje</i></th>
                                                <th><i>Status</i></th>
                                                <th><i>Opciones</i></th>
                                            </tr>
                                        </thead>
                                      
                                        <tbody>
                                            <?php
                                            
                                            $consulta = "SELECT * FROM descuentos";
                                            


                                            if ($resultado = $mysqli->query($consulta)) {
                                                while ($obj = $resultado->fetch_object()) {
                                                    ?>
                                                    <tr>
                                                        <td style="max-width:30px;overflow:auto;">
                                                            <h6>
                                                                <?php echo $obj->id_descuentos; ?>
                                                            </h6>
                                                        </td>
                                                        <td style="max-width:30px;overflow:auto;">
                                                            <h6>
                                                                <?php echo $obj->codigo; ?>
                                                            </h6>
                                                        </td>
                                                        <td style="max-width:30px;overflow:auto;">
                                                            <h6>
                                                                <?php echo $obj->porcentaje; ?>
                                                            </h6>
                                                        </td>
                                                        <td style="max-width:30px;overflow:auto;">
                                                            <h6>
                                                                <?php echo $obj->status; ?>
                                                            </h6>
                                                        </td>
                                                        
                                                        <td>
                                                            <?php
                                                            echo "<a href='descuentos_editar.php?id=$obj->id_descuentos' style='width:20px;' aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Editar'><i class='fa fa-edit'></i></a>"; 
                                                            ?>

                                                            <?php
                                                            echo "<a href='descuentos_borrar.php?id=$obj->id_descuentos' style='width:20px;'  aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Borrar'><i class='fa fa-eraser'></i></a>"; 
                                                            ?>


                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                $resultado->close();
                                            }
                                        }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <br>
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
            var table = $('#descuentos').DataTable({
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
            window.location.assign("descuentos_alta.php");
        }
    </script>
</body>

</html>