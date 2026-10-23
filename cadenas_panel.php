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

                            <br>
                            <div align="center" class="col-12">
                                <br>
                                <h2 style="font-size:25px;" id="titulopagina">Mis Cadenas:</h2>
                                
                                <button onclick="upsection();" class="btn btn-success btn-rounded" ><i class="fa fa-plus-circle m-r-5"></i>Alta</button>
                                <br><br>
                                
                                <br><br>
                                <div class="table-responsive" id="cadenas-container">  
                                    <table id="cadenas" class="records_list table  table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                        <!-- Inicio de tabla Admin -->  
                                        <?php 
                                        if ($_SESSION['permisos'] == "Administrador" OR $_SESSION['permisos'] == "Cliente"){
                                        ?>
                                        <thead>
                                            <tr>
                                                <th><i>Id</i></th>    
                                                <th><i>Nombre</i></th>    
                                                <th><i>Opciones</i></th>               
                                            </tr> 
                                        </thead>     
                                        <tbody>
                                            <?php 
                                            require_once 'conexion.php'; 
                                            $consulta = "SELECT * FROM cadena"; 
                                            if($resultado = $mysqli->query($consulta)) {
                                                while ($obj = $resultado->fetch_object()){
                                            ?>
                                            <tr>
                                                <td style="max-width:30px;overflow:auto;"><h6>
                                                    <?php 
                                                    echo $obj->cadena_id;
                                                    ?></h6>
                                                </td>
                                                <td style="max-width:30px;overflow:auto;"><h6>
                                                    <?php 
                                                    echo $obj->nombre_cadena;
                                                    ?></h6>
                                                </td>
                                                <td>

                                                    <?php
                                                    echo "<a href='cadenas_editar.php?id=$obj->cadena_id' style='width:20px;'  aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Editar'><i class='fa fa-edit'></i></a>";
                                                    ?>
                                                    
                                                    <?php
                                                    echo "<a href='cadenas_borrar.php?id=$obj->cadena_id' style='width:20px;'  aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Borrar'><i class='fa fa-eraser'></i></a>";
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
                                        <!-- Inicio de tabla Cliente -->  
                                        <?php 
                                        if ($_SESSION['permisos'] == "Veremos_luego"){
                                            $id_user = $_SESSION['user_id'];

                                            require_once 'conexion.php'; 
                                            $sql="SELECT * FROM marcas WHERE mar_cliente_id = '$id_user'";
                                            if ($resql = $mysqli->query($sql)){
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

                                            <?php   require_once 'conexion.php'; 
                                            $consulta = "SELECT DISTINCT relacion_mtc_cadena_id, cadena_id, nombre_cadena, marca_id FROM `marcas` INNER JOIN relacion_m_t_c on marcas.marca_id = relacion_m_t_c.relacion_mtc_marca_id INNER JOIN cadena on relacion_m_t_c.relacion_mtc_cadena_id = cadena.cadena_id WHERE mar_cliente_id = '$id_user' "; 
                                            if($resultado = $mysqli->query($consulta)) {
                                                while ($obj = $resultado->fetch_object()){
                                            ?>
                                            <tr>
                                                <td style="max-width:30px;overflow:auto;"><h6>
                                                    <?php   echo $obj->cadena_id; ?></h6>
                                                </td>
                                                <td style="max-width:30px;overflow:auto;"><h6>
                                                    <?php  echo $obj->nombre_cadena;  ?></h6>
                                                </td>
                                                <td style="max-width:30px;overflow:auto;"><h6>
                                                    <?php 

                                                    $consultas = "SELECT * FROM `rol_maestro_misiones` INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id WHERE mar_cliente_id = '$id_user' AND rol_marca_id = '$obj->marca_id' "; 
                                                    if($resultados = $mysqli->query($consultas)) {
                                                        $numasignaciones = $resultados->num_rows;
                                                        $resultados->close();
                                                    }  
                                                    echo $numasignaciones;  



                                                    ?></h6>
                                                </td>
                                                <td style="max-width:30px;overflow:auto;"><h6>
                                                    <?php    
                                                    $consultas = "SELECT * FROM `rol_maestro_misiones` INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id INNER JOIN misiones ON rol_maestro_misiones.rol_id_orden_trabajo = misiones.mision_id_orden_trabajo WHERE mar_cliente_id = '$id_user' AND rol_marca_id = '$obj->marca_id' "; 
                                                    if($resultados = $mysqli->query($consultas)) {
                                                        $numentregas = $resultados->num_rows;
                                                        $resultados->close();
                                                    }  
                                                    $porentregas = ($numasignaciones / $numentregas) * 100;
                                                    if ($numentregas == 0){
                                                        echo "sin entregas";
                                                    }else{
                                                        echo $porentregas."%";   
                                                    }

                                                    ?></h6>
                                                </td>
                                                <td style="max-width:30px;overflow:auto;"><h6>
                                                    <?php  

                                                    $consultas = "SELECT * FROM `rol_maestro_misiones` INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id INNER JOIN misiones ON rol_maestro_misiones.rol_id_orden_trabajo = misiones.mision_id_orden_trabajo WHERE mar_cliente_id = '$id_user' AND rol_marca_id = '$obj->marca_id' AND fecha_inicio_mision <= fecha_programada_visita_rol "; 
                                                    if($resultados = $mysqli->query($consultas)) {
                                                        $numenfecha = $resultados->num_rows;
                                                        $resultados->close();
                                                    }  
                                                    $porenfecha = ($numasignaciones / $numenfecha) * 100;
                                                    if ($numenfecha == 0){
                                                        echo "sin entregas";
                                                    }else{
                                                        echo $porenfecha."%";   
                                                    }


                                                    ?></h6>
                                                </td>
                                                <td>
                                                    <?php
                                                    echo "<a href='misiones_panel.php?cad=$obj->cadena_id' style='width:20px;' class='fa fa-eye' aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Ver Misiones'></a>";
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
                            <br> 

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
        <script type="text/javascript">
            $(document).ready(function() {
                var table = $('#cadenas').DataTable({
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
            function upsection(){ 
                window.location.assign("cadenas_alta.php"); 
            }
        </script>   
    </body>
</html>