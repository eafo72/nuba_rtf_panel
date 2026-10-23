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
                                <h2 style="font-size:25px;" id="titulopagina">Roles:</h2>
                                <button onclick="upsection();" class="btn btn-success btn-rounded" ><i class="fa fa-plus-circle m-r-5"></i> Alta</button>
                                <br><br>
                                <table id="rol" class="table  table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th><i>Del</i></th>
                                            <th><i>Al</i></th>
                                            <th><i>Técnico</i></th>    
                                            <th><i>Opciones</i></th>               
                                        </tr> 
                                    </thead>     
                                    <tbody>
                                        <?php 
                                        require_once 'conexion.php'; 
                                        //agrupamos por rol_maestro_id
                                        $consulta = 'SELECT * FROM roles GROUP BY rol_maestro_id';
                                        if($resultado = $mysqli->query($consulta)) {
                                            while ($obj = $resultado->fetch_object()){
                                        ?>
                                        <tr>
                                            <td style="max-width:30px;overflow:auto;"><h6>
                                                <?php 
                                                //buscamos la fecha menor
                                                $sql = "SELECT MIN(DATE_FORMAT(fecha_programada_visita_rol, '%Y-%m-%d')) AS fecha_inicial FROM roles WHERE rol_maestro_id = '$obj->rol_maestro_id'";
                                                if($resQ = $mysqli->query($sql)) {
                                                    $obQ = $resQ->fetch_object();
                                                    $fecha_inicial = $obQ->fecha_inicial;   
                                                    $resQ->close();
                                                }
                                                echo $fecha_inicial;
                                                ?></h6>
                                            </td>
                                            <td style="max-width:30px;overflow:auto;"><h6>
                                                <?php 
                                                //buscamos la fecha mayor
                                                $sql = "SELECT MAX(DATE_FORMAT(fecha_programada_visita_rol, '%Y-%m-%d')) AS fecha_final FROM roles WHERE rol_maestro_id = '$obj->rol_maestro_id'";
                                                if($resQ = $mysqli->query($sql)) {
                                                    $obQ = $resQ->fetch_object();
                                                    $fecha_final = $obQ->fecha_final;   
                                                    $resQ->close();
                                                }
                                                echo $fecha_final;
                                                ?></h6>
                                            </td>
                                            <td style="max-width:30px;overflow:auto;">
                                                <h6 style="font-size:10px;">
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
                                                echo "<a href='roles_detalle.php?id=$obj->rol_maestro_id&id_col=$obj->colaborador_id_asignado_rol' style='width:20px;'  aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Ver'><i class='fa fa-list'></i></a>";
                                                ?>
                                                
                                                <?php
                                                $data = 'Actividades de : '.$nombre_colaborador.' del : '.$fecha_inicial.' al : '.$fecha_final; 
                                                echo "<a href='roles_guardar.php?id=$obj->rol_maestro_id&id_col=$obj->colaborador_id_asignado_rol&data=$data' style='width:20px;'  aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Guardar'><i class='fa fa-upload'></i></a>";
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
                window.location.assign("roles_alta.php"); 
            }
        </script>  
    </body>
</html>