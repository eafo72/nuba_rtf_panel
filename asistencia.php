<?php include('pass.php');?>
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
                        <h1 class="mt-4">Asistencia</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="admin.php">Inicio </a></li>
                            <li class="breadcrumb-item active">Asistencia</li>
                        </ol>

                        <div class="row">
                            <div class="col-12 text-center">


                                <a class="btn btn-success" href="" data-toggle="modal" data-target="#selecciona"><i class="fa fa-download m-r-5"></i> Exportar a Excel</a>


                                <br><br>
                                <form method="get">

                                    <?php
                                    date_default_timezone_set('America/Mexico_City');  
                                    $hoy = date('Y-m-d');
                                    if(isset($_GET['fecha'])){
                                        $fecha = $_GET['fecha'];    
                                    }else{
                                        $fecha = $hoy;    
                                    }
                                    ?>



                                    <label class="control-label">Fecha</label>
                                    <input  type="date" name="fecha" 
                                           value="<?php echo $fecha; ?>"/>





                                    <div class="form-group"> <!-- Submit button -->
                                        <button class="btn btn-success"  type="submit">Filtrar</button>


                                    </div>
                                </form>
                                <br>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">

                            </div>
                            <div class="card-body">
                                <div class="table-responsive text-center">
                                    <table class="table " id="dataTable" width="100%" cellspacing="0">
                                        <thead>

                                            <tr>
                                                <th style="text-align:center">Técnico</th>
                                                <th style="text-align:center">Fecha</th>
                                                <th style="text-align:center">Hora</th>
												<th style="text-align:center">Lat./Long.</th>

                                            </tr> 
                                        </thead>
                                        
                                        <tbody>
                                            <?php 
                                            if(isset($_GET['fecha'])){
                                                $fecha = $_GET['fecha'];    
                                            }else{
                                                $fecha = $hoy;    
                                            }

                                            $id_user = $_SESSION['user_id'];
                                            require_once 'conexion.php'; 
                                            //$sql = "SELECT * FROM  usuarios WHERE permisos = 'Colaborador'";   

                                            $sql = "SELECT * FROM sincronizaciones INNER JOIN colaboradores ON  sincronizaciones.id_colaborador = colaboradores.col_usuario_id WHERE fecha = '$fecha' ORDER BY fecha DESC, hora DESC";


                                            if($resultado = $mysqli->query($sql)) {
                                                while ($obj = $resultado->fetch_object()){
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php 
                                                    echo $obj->nombre_col." ".$obj->apellido_col;
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                    echo $obj->fecha;
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                    echo $obj->hora;
                                                    ?>
                                                </td><td>
                                                    <?php 
                                                    echo $obj->latlong;
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
                            <div class="card-footer small text-muted">Actualizada <?php echo $hoy; ?></div>
                        </div>


                    </div>
                </main>

            </div>
        </div>
        <div class="modal fade" id="selecciona" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
            <div class="modal-dialog" role="document">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Desea Exportar a Excel</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body text-center" >
                        <form  method="get" action="sincronizaciones_exportar.php" target="_blank" onsubmit="javascript:$('#selecciona').modal('hide');">
                            <input class="btn btn-success" type="submit"   value="Sí">
                        </form>    

                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function() {
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
