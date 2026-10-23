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
                        <div class="row">
                            <div align="center" class="col-12">
                                <br>
                                <h2 style="font-size:25px;" id="titulopagina">Rol Maestro:</h2>
                                <button onclick="upsection();" class="btn btn-success btn-rounded" ><i class="fa fa-plus-circle m-r-5"></i> Alta</button>
                                <br><br>
                                <table id="rol" class="table  table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th><i>Id</i></th>    
                                            <th><i>Cliente</i></th>    
                                            <th><i>Ubicación</i></th>    
                                            <th><i>OT</i></th>    
                                            <th><i>Fecha</i></th>
                                            <th><i>Hora</i></th>
                                            <th><i>Técnico</i></th>    
                                            <th><i>Opciones</i></th>               
                                        </tr> 
                                    </thead>     
                                    <tbody>
                                        <?php 
                                        require_once 'conexion.php'; 
                                        $consulta = 'SELECT * FROM rol_maestro_misiones';
                                        if($resultado = $mysqli->query($consulta)) {
                                            while ($obj = $resultado->fetch_object()){
                                        ?>
                                        <tr>
                                            <td style="max-width:30px;overflow:auto;"><h6>
                                                <?php 
                                                echo $obj->rol_maestro_id;
                                                ?></h6>
                                            </td>
                                            <td style="max-width:30px;overflow:auto;"><h6>

                                                <?php 
                                                $sql="SELECT * FROM marcas WHERE marca_id = '$obj->rol_marca_id'";
                                                if ($resql = $mysqli->query($sql)){
                                                    $obsql = $resql->fetch_object();
                                                    $nombre_marca = $obsql->nombre_marca;
                                                    $resql->close();
                                                }
                                                echo $nombre_marca;
                                                ?>
                                                </h6>
                                            </td>
                                            <td style="max-width:30px;overflow:auto;"><h6>

                                                <?php 
                                                $sql="SELECT * FROM tienda WHERE tienda_id = '$obj->rol_id_tienda'";
                                                if ($resql = $mysqli->query($sql)){
                                                    $obsql = $resql->fetch_object();
                                                    $nombre_tienda = $obsql->nombre_tienda;
                                                    $resql->close();
                                                }
                                                echo $nombre_tienda;
                                                ?>
                                                </h6>
                                            </td>
                                            <td style="max-width:30px;overflow:auto;"><h6>
                                                <?php 
                                                echo $obj->rol_id_orden_trabajo;
                                                ?></h6>
                                            </td>
                                            <td style="max-width:30px;overflow:auto;"><h6>
                                                <?php 
                                                echo $obj->fecha_programada_visita_rol;
                                                ?></h6>
                                            </td>
                                            <td style="max-width:30px;overflow:auto;"><h6>
                                                <?php 
                                                echo $obj->hora_programada_visita_rol;
                                                ?></h6>
                                            </td>
                                            <td style="max-width:30px;overflow:auto;"><h6>
                                                <?php 
                                                $sql="SELECT * FROM colaboradores WHERE col_usuario_id = '$obj->colaborador_id_asignado_rol'";
                                                if ($resql = $mysqli->query($sql)){
                                                    $obsql = $resql->fetch_object();
                                                    $nombre_colaborador = $obsql->nombre_col.' '.$obsql->apellido_col;
                                                    $resql->close();
                                                }
                                                echo $nombre_colaborador;
                                                ?>
                                                </h6>
                                            </td>
                                            <td>
                                                <?php
                                                echo "<a href='rol_maestro_editar.php?id=$obj->rol_maestro_id' style='width:20px;'  aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Editar'><i class='fa fa-edit'></i></a>";
                                                ?>
                                                <?php
                                                echo "<a href='rol_maestro_borrar.php?id=$obj->rol_maestro_id' style='width:20px;'  aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Borrar'><i class='fa fa-eraser'></i></a>";
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
                </main>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function() {
                var table = $('#rol').DataTable({
                "responsive": false,
                "stateSave": true,
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "order": [[0, "asc"]],
            });
            } );
        </script> 
        <script>
            function upsection(){ 
                window.location.assign("rol_maestro_alta.php"); 
            }
        </script> 
    </body>
</html>