<?php include('pass.php');?>
<?php include('cabecera_panel.php'); ?>

<?php 
if ($_SESSION['permisos'] == "Cliente"){
    $id_user = $_SESSION['user_id'];
    $test = array();

    $odi = array();

    require_once 'conexion.php'; 
    $consulta = "SELECT  DISTINCT rol_id_orden_trabajo FROM rol_maestro_misiones INNER JOIN marcas on rol_maestro_misiones.rol_marca_id = marcas.marca_id WHERE mar_cliente_id = '$id_user' "; 
    if($resultado = $mysqli->query($consulta)) {
        $programadas = $resultado->num_rows;  
    }

    $consultas = "SELECT  DISTINCT rol_id_orden_trabajo, fechayhorasubida FROM rol_maestro_misiones INNER JOIN marcas on rol_maestro_misiones.rol_marca_id = marcas.marca_id WHERE mar_cliente_id = '$id_user' AND fechayhorasubida != '0000-00-00 00:00:00' "; 
    if($resultados = $mysqli->query($consultas)) {
        $entregadascon = $resultados->num_rows;  
        if($entregadascon > 0){
            $entregadas = $entregadascon;
            $porentregadas = ($entregadas / $programadas) * 100;
        }else {
            $porentregadas = 0;
        }
    }


    $pornoentregadas = 100 - $porentregadas;

    $dataPoints2 = array(
        array("label"=>"Entregadas", "y"=>$porentregadas),
        array("label"=>"Pendientes", "y"=>$pornoentregadas)
    ); 

    $dataPoints3 = array();
    $consultal = "SELECT DISTINCT colaborador_id_asignado_rol FROM rol_maestro_misiones INNER JOIN marcas on rol_maestro_misiones.rol_marca_id = marcas.marca_id WHERE mar_cliente_id = '$id_user' "; 
    if($resultado = $mysqli->query($consultal)) {
        while ($obj = $resultado->fetch_object()){
            $consultan = "SELECT  DISTINCT rol_id_orden_trabajo, fechayhorasubida FROM rol_maestro_misiones INNER JOIN marcas on rol_maestro_misiones.rol_marca_id = marcas.marca_id WHERE mar_cliente_id = '$id_user' AND colaborador_id_asignado_rol = '$obj->colaborador_id_asignado_rol' "; 
            if($resultadon = $mysqli->query($consultan)) {
                $asignaciones  = $resultadon->num_rows;
                $resultadon->close();
            }
            $consultay = "SELECT  DISTINCT nombre_col, apellido_col FROM colaboradores WHERE  col_usuario_id = '$obj->colaborador_id_asignado_rol' "; 
            if($resultadoy = $mysqli->query($consultay)) {
                while ($obj = $resultadoy->fetch_object()){
                    $nom_col = $obj->nombre_col;
                    $ape_col = $obj->apellido_col;
                    $nombre_completo = $nom_col." ".$ape_col;
                }
                $resultadoy->close();
            }
            $sinentregar = $programadas - $entregadas;
            $point = array("label" => $nombre_completo , "y" => $asignaciones);
            $points = array("label" => $nombre_completo , "y" => $sinentregar);
            $t20 = array(
                array("label"=> "$nombre_completo", "y"=> $entregadas)
            );

            array_push($dataPoints3, $point);  
            array_push($odi, $points);  
        }
        $resultado->close();
    } 

    $dataPoints4 = array();
    $consultaM = "SELECT DISTINCT colaborador_id_asignado_rol FROM rol_maestro_misiones INNER JOIN marcas on rol_maestro_misiones.rol_marca_id = marcas.marca_id WHERE mar_cliente_id = '$id_user' "; 
    if($resultadoM = $mysqli->query($consultaM)) {
        while ($objM = $resultadoM->fetch_object()){
            $consultanM = "SELECT  DISTINCT rol_id_orden_trabajo, fechayhorasubida FROM rol_maestro_misiones INNER JOIN marcas on rol_maestro_misiones.rol_marca_id = marcas.marca_id WHERE mar_cliente_id = '$id_user' AND colaborador_id_asignado_rol = '$obj->colaborador_id_asignado_rol' AND fechayhorasubida != '0000-00-00 00:00:00' "; 
            if($resultadonM = $mysqli->query($consultanM)) {
                $colentregascon  = $resultadonM->num_rows;
                if($colentregascon > 0){
                    $colentregas = $colentregascon;
                }else {
                    $colentregas = 0;
                }
                $resultadonM->close();
            }
            $consultayM = "SELECT  DISTINCT nombre_col, apellido_col FROM colaboradores WHERE  col_usuario_id = '$obj->colaborador_id_asignado_rol' "; 
            if($resultadoyM = $mysqli->query($consultayM)) {
                while ($objM = $resultadoyM->fetch_object()){
                    $nom_col = $objM->nombre_col;
                    $ape_col = $objM->apellido_col;
                    $nombre_completo = $nom_col." ".$ape_col;
                }
                $resultadoyM->close();
            }

            $point = array("label" => $nombre_completo , "y" => $asignaciones, "link"=>"misiones_panel.php?prom=$nombre_completo");
            $pointss = array("label" => $nombre_completo , "y" => $entregadas);

            array_push($dataPoints4, $pointss);  
            array_push($test, $point);

        }
        $resultadoM->close();
    }

    $dataPoints5 = array();
    $consultax = "SELECT DISTINCT rol_marca_id FROM rol_maestro_misiones INNER JOIN marcas on rol_maestro_misiones.rol_marca_id = marcas.marca_id WHERE mar_cliente_id = '$id_user' "; 
    if($resultadox = $mysqli->query($consultax)) {
        while ($objx = $resultadox->fetch_object()){

            $consultam = "SELECT DISTINCT tienda_id, nombre_tienda FROM tienda INNER JOIN rol_maestro_misiones on rol_maestro_misiones.rol_id_tienda = tienda.tienda_id WHERE rol_marca_id = '$objx->rol_marca_id'  ";
            if($resultadom = $mysqli->query($consultam)) {
                while ($objm = $resultadom->fetch_object()){
                    $nom_marca = $objm->nombre_tienda;
                    $id_tienda_cli = $objm->tienda_id;

                }
                $resultadom->close();
            }

            $consultav = "SELECT  DISTINCT rol_id_orden_trabajo FROM rol_maestro_misiones INNER JOIN marcas on rol_maestro_misiones.rol_marca_id = marcas.marca_id WHERE mar_cliente_id = '$id_user' AND marca_id = '$objx->rol_marca_id' AND rol_id_tienda = '$id_tienda_cli'  AND fechayhorasubida != '0000-00-00 00-00-00'"; 
            if($resultadov = $mysqli->query($consultav)) {
                $num_asig = $resultadov->num_rows;  
            }
            $pormarca = array("label" => $nom_marca , "y" => $num_asig);

            array_push($dataPoints5, $pormarca);  

        }
        $resultadox->close();   
    }
}
?>

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
                        <h1 class="mt-4">Rutas Ejecutadas</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="admin.php">Inicio </a></li>
                            <li class="breadcrumb-item active">Rutas</li>
                        </ol>
                        <div class="row">
                            <div class="col-12">
                                <form>
                                    <div class="row">
                                        <div class="col-6">


                                            <div class="form-group"> <!-- Date input -->
                                                <label class="control-label" for="date">Fecha Inicio</label>
                                                <input class="form-control" id="date" name="date" placeholder="MM/DD/YYY" type="text"/>
                                            </div>

                                        </div>   
                                        <div class="col-6">          

                                            <div class="form-group"> <!-- Date input -->
                                                <label class="control-label" for="date">Fecha Final</label>
                                                <input class="form-control" id="date" name="date" placeholder="MM/DD/YYY" type="text"/>
                                            </div>


                                        </div>
                                    </div>
                                    <div class="form-group"> <!-- Submit button -->
                                        <button class="btn btn-info " name="submit" type="submit">Filtrar</button>

                                    </div>
                                </form>
                                <br>
                            </div>

                            <div class="col-12">

                                <br>
                                <div class="col-12 text-center">
                                    <a href="#" class="btn btn-info"> Exportar Excel</a>
                                    <br><br>
                                </div>

                                <div class="card mb-4">
                                    <div class="card-header"><i class="fas fa-table mr-1"></i>DataTable Rutas ejecutadas</div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table " id="dataTable" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>OT</th> 
                                                        <th>Cadena</th>
                                                        <th>Nombre de Tienda</th>
                                                        <th>Marcas</th>
                                                        <th>Promotor</th>
                                                        <th>Programada</th>
                                                        <th>Reporte</th> 
                                                        <th>Condición</th> 
                                                        <th>Ver</th>               
                                                    </tr> 
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>OT</th> 
                                                        <th>Cadena</th>
                                                        <th>Nombre de Tienda</th>
                                                        <th>Marcas</th>
                                                        <th>Promotor</th>
                                                        <th>Programada</th>
                                                        <th>Reporte</th> 
                                                        <th>Condición</th> 
                                                        <th>Ver</th>               
                                                    </tr> 
                                                </tfoot>
                                                <tbody>
                                                    <?php 
                                                    require_once 'conexion.php'; 

                                                    if ($_SESSION['permisos'] == "Administrador"){
                                                        $consulta = 'SELECT * FROM  rol_maestro_misiones  INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id INNER JOIN colaboradores ON rol_maestro_misiones.colaborador_id_asignado_rol = colaboradores.col_usuario_id INNER JOIN relacion_m_t_c ON rol_maestro_misiones.rol_marca_id = relacion_m_t_c.relacion_mtc_marca_id and rol_maestro_misiones.rol_id_tienda = relacion_m_t_c.relacion_mtc_tienda_id INNER JOIN tienda ON relacion_m_t_c.relacion_mtc_tienda_id = tienda.tienda_id INNER JOIN cadena ON tienda.cadena_id_tienda = cadena.cadena_id';    
                                                    } 
                                                    if ($_SESSION['permisos'] == "Cliente"){   
                                                        $id_user = $_SESSION['user_id'];



                                                        $consulta = "SELECT * FROM  rol_maestro_misiones  INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id INNER JOIN colaboradores ON rol_maestro_misiones.colaborador_id_asignado_rol = colaboradores.col_usuario_id INNER JOIN relacion_m_t_c ON rol_maestro_misiones.rol_marca_id = relacion_m_t_c.relacion_mtc_marca_id and rol_maestro_misiones.rol_id_tienda = relacion_m_t_c.relacion_mtc_tienda_id INNER JOIN tienda ON relacion_m_t_c.relacion_mtc_tienda_id = tienda.tienda_id INNER JOIN cadena ON tienda.cadena_id_tienda = cadena.cadena_id WHERE marcas.mar_cliente_id = '$id_user'";
                                                    } 

                                                    if($resultado = $mysqli->query($consulta)) {
                                                        while ($obj = $resultado->fetch_object()){
                                                    ?>
                                                    <tr>

                                                        <td >
                                                            <?php 
                                                            echo $obj->rol_id_orden_trabajo;
                                                            ?>
                                                        </td>
                                                        <td >
                                                            <?php 
                                                            echo $obj->nombre_cadena;
                                                            ?>
                                                        </td>
                                                        <td >
                                                            <?php
                                                            $sql = "SELECT * FROM tienda WHERE tienda_id = '$obj->rol_id_tienda'";
                                                            if ($resql = $mysqli->query($sql)){
                                                                $obsql = $resql->fetch_object();
                                                                echo $obsql->nombre_tienda;
                                                                $resql->close();
                                                            }
                                                            ?>

                                                        <td >


                                                            <?php
                                                            $sql = "SELECT * FROM rol_maestro_misiones INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id INNER JOIN colaboradores ON rol_maestro_misiones.colaborador_id_asignado_rol = colaboradores.col_usuario_id INNER JOIN relacion_m_t_c ON rol_maestro_misiones.rol_marca_id = relacion_m_t_c.relacion_mtc_marca_id and rol_maestro_misiones.rol_id_tienda = relacion_m_t_c.relacion_mtc_tienda_id INNER JOIN tienda ON relacion_m_t_c.relacion_mtc_tienda_id = tienda.tienda_id INNER JOIN cadena ON tienda.cadena_id_tienda = cadena.cadena_id WHERE rol_id_orden_trabajo = '$obj->rol_id_orden_trabajo'";
                                                            if($resultados = $mysqli->query($sql)) {
                                                                while ($objs = $resultados->fetch_object()){ 
                                                                    echo $objs->nombre_marca.", &nbsp;";

                                                                }
                                                                $resultados->close();
                                                            }
                                                            ?>

                                                        </td>
                                                        <td >
                                                            <?php 
                                                            echo $obj->nombre_col." ".$obj->apellido_col;
                                                            ?>
                                                        </td>
                                                        <td >
                                                            <?php 
                                                            echo $obj->fecha_programada_visita_rol;
                                                            ?>
                                                        </td>
                                                        <td >
                                                            <?php

                                                            if ($obj->fechayhorasubida == "0000-00-00 00:00:00" || $obj->fechayhorasubida == null){
                                                            ?>

                                                            <p>Sin Iniciar</p>

                                                            <?php 
                                                            }  else {
                                                            ?>

                                                            <p>Entregado</p>

                                                            <?php 
                                                            }  



                                                            ?>

                                                        </td>
                                                        <td >
                                                            <?php
                                                            if ($obj->fechayhorasubida != '0000-00-00 00:00:00'){


                                                                $fecha_subida = date('Y-m-d',strtotime($obj->fechayhorasubida));
                                                                if ($fecha_subida == $obj->fecha_programada_visita_rol){
                                                            ?>
                                                            <p>Oportunamente </p>
                                                            <?php 
                                                                }else{
                                                                    $programada = strtotime($obj->fecha_programada_visita_rol);
                                                                    $actividad = strtotime($obj->fechayhorasubida);
                                                                    $dif = ($actividad - $programada);
                                                                    if($dif < 0){
                                                            ?>
                                                            <p>Adelantado</p>
                                                            <?php     
                                                                    } else if ($dif >0){
                                                            ?>
                                                            <p>Retrasado  </p>
                                                            <?php  
                                                                    }
                                                                }  

                                                            }else{
                                                            ?>
                                                            <p>Sin realizar</p>
                                                            <?php
                                                            }


                                                            ?>                                       

                                                        </td>
                                                        <td>
                                                            <?php


                                                            if ($obj->fechayhorasubida != '0000-00-00 00:00:00'){
                                                                echo "<a href='misiones_marcas.php?id_ot=$obj->rol_id_orden_trabajo&tid=$obj->rol_id_tienda' style='width:20px;' class='fa fa-eye' aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Ver Marcas'></a>"; 

                                                            }else{ }


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
                                    <div class="card-footer small text-muted">Actualizada 19/02/2020</div>
                                </div>

                            </div>
                        </div>
                    </div>
                </main>

            </div>
        </div>

        <script>
            window.onload = function() {

                var chart2 = new CanvasJS.Chart("chartContainer2", {
                    animationEnabled: true,
                    title: {
                        text: ""
                    },
                    subtitles: [{
                        text: "Totales: <?php echo $programadas ?>"
                    }],
                    data: [{
                        type: "pie",
                        yValueFormatString: "#,##0.00\"%\"",
                        indexLabel: "{label} ({y})",
                        dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
                    }]
                    });

                           var chart3 = new CanvasJS.Chart("chartContainer3", {
                           animationEnabled: true,
                           title:{
                           text: ""
                           },
                           legend:{
                           cursor: "pointer",
                           verticalAlign: "center",
                           horizontalAlign: "right",
                           itemclick: toggleDataSeries
                           },
                           toolTip:{
                           enabled: false   //enable here
                           },

                           data: [{
                           type: "bar",
                           name: "Asignadas",
                           indexLabel: "{y}",
                           yValueFormatString: "#0.##",
                           showInLegend: true,
                           dataPoints: <?php echo json_encode($dataPoints3, JSON_NUMERIC_CHECK); ?>
                           },{
                           type: "bar",
                           name: "Entregadas",
                           indexLabel: "{y}",
                           yValueFormatString: "#0.##",
                           showInLegend: true,
                           dataPoints: <?php echo json_encode($dataPoints4, JSON_NUMERIC_CHECK); ?>
                           },


                          ]
                });


                var chart4 = new CanvasJS.Chart("chartContainer4", {
                    animationEnabled: true,
                    theme: "light1", // "light1", "light2", "dark1", "dark2"
                    title:{
                        text: " "
                    },
                    axisX:{
                        reversed: true
                    },
                    toolTip:{
                        shared: true
                    },
                    data: [{
                        type: "stackedBar",
                        name: "Programadas",
                        cursor:"pointer",
                        click: onClick, 
                        dataPoints: <?php echo json_encode($test, JSON_NUMERIC_CHECK); ?>
                    },{
                        type: "stackedBar",
                        name: "Sin Entregar",
                        dataPoints: <?php echo json_encode($odi, JSON_NUMERIC_CHECK); ?>
                    },{
                        type: "stackedBar",
                        name: "Entregadas",
                        dataPoints: <?php echo json_encode($t20, JSON_NUMERIC_CHECK); ?>
                    }]
                    });


                           var chart5 = new CanvasJS.Chart("chartContainer5", {
                           animationEnabled: true,
                           title:{
                           text: ""
                           },
                           legend:{
                           cursor: "pointer",
                           verticalAlign: "center",
                           horizontalAlign: "right",
                           itemclick: toggleDataSeries
                           },
                           toolTip:{
                           enabled: false   //enable here
                           },
                           data: [{
                           type: "bar",

                           indexLabel: "{y}",
                           yValueFormatString: "#0.##",

                           dataPoints: <?php echo json_encode($dataPoints5, JSON_NUMERIC_CHECK); ?>
                           }]
                });



                function toggleDataSeries(e){
                    if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                        e.dataSeries.visible = false;
                    }
                    else{
                        e.dataSeries.visible = true;
                    }

                } 


                chart5.render();
            }

            function onClick(e){ 
                window.location.replace(e.dataPoint.link,'_blank');  
            };       

        </script>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        
        
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        
        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    </body>
</html>
