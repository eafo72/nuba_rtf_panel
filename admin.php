<?php include('pass.php');
if (isset($_GET['mes'])) {
    $mes = $_GET['mes'];
    $year = $_GET['year'];
} else {
    date_default_timezone_set('America/Mexico_City');
    $hoy = date('Y-m-d');
    $combo_hoy = explode("-", $hoy);
    $mes = $combo_hoy[1];
    $year = $combo_hoy[0];
}
?>
<?php
require_once 'conexion.php';
if ($_SESSION['permisos'] == "Cliente") {
    $id_user = $_SESSION['user_id'];

    $sql = "SELECT * FROM clientes WHERE cli_usuario_id = '$id_user'";
    if ($resql = $mysqli->query($sql)) {
        $obsql = $resql->fetch_object();
        $nom_cliente = $obsql->nombre_cliente;
        $ape_cliente = $obsql->apellido_cliente;
        $resql->close();
    }
    $num_total = 0;

    //PRIMER GRAFICA
    $dataPoints1 = [];

    if (isset($mes)) {
        $consultax = "SELECT COUNT(rol_maestro_id) AS total, rol_id_tienda, nombre_tienda FROM rol_maestro_misiones  INNER JOIN marcas on rol_maestro_misiones.rol_marca_id = marcas.marca_id INNER JOIN tienda ON rol_maestro_misiones.rol_id_tienda = tienda.tienda_id  WHERE fechayhorasubida != '0000-00-00 00:00:00' AND id_usuario = '$id_user' AND MONTH(rol_maestro_misiones.fecha_programada_visita_rol) = $mes AND YEAR(rol_maestro_misiones.fecha_programada_visita_rol) = $year GROUP by rol_id_tienda";
    } else {
        $consultax = "SELECT COUNT(rol_maestro_id) AS total, rol_id_tienda, nombre_tienda FROM rol_maestro_misiones  INNER JOIN marcas on rol_maestro_misiones.rol_marca_id = marcas.marca_id INNER JOIN tienda ON rol_maestro_misiones.rol_id_tienda = tienda.tienda_id  WHERE fechayhorasubida != '0000-00-00 00:00:00' AND id_usuario = '$id_user' GROUP by rol_id_tienda";
    }

    if ($resultadox = $mysqli->query($consultax)) {
        while ($objx = $resultadox->fetch_object()) {
            $dataPoints1[] = array("label" => $objx->nombre_tienda, "y" => $objx->total);
            $num_total = $num_total + $objx->total;
        }
        $resultadox->close();
    }

    //FIN PRIMER GRAFICA


    //SEGUNDA GRAFICA

    if (isset($mes)) {
        $consulta = "SELECT  rol_id_orden_trabajo FROM rol_maestro_misiones INNER JOIN marcas on rol_maestro_misiones.rol_marca_id = marcas.marca_id WHERE id_usuario = '$id_user' AND MONTH(rol_maestro_misiones.fecha_programada_visita_rol) = $mes AND YEAR(rol_maestro_misiones.fecha_programada_visita_rol) = $year ";
    } else {
        $consulta = "SELECT  rol_id_orden_trabajo FROM rol_maestro_misiones INNER JOIN marcas on rol_maestro_misiones.rol_marca_id = marcas.marca_id WHERE id_usuario = '$id_user' ";
    }
    if ($resultado = $mysqli->query($consulta)) {
        $programadas = $resultado->num_rows;
    }

    if (isset($mes)) {
        $consultas = "SELECT  DISTINCT rol_id_orden_trabajo, fechayhorasubida FROM rol_maestro_misiones INNER JOIN marcas on rol_maestro_misiones.rol_marca_id = marcas.marca_id WHERE id_usuario = '$id_user' AND fechayhorasubida != '0000-00-00 00:00:00' AND MONTH(rol_maestro_misiones.fecha_programada_visita_rol) = $mes AND YEAR(rol_maestro_misiones.fecha_programada_visita_rol) = $year ";
    } else {
        $consultas = "SELECT  DISTINCT rol_id_orden_trabajo, fechayhorasubida FROM rol_maestro_misiones INNER JOIN marcas on rol_maestro_misiones.rol_marca_id = marcas.marca_id WHERE id_usuario = '$id_user' AND fechayhorasubida != '0000-00-00 00:00:00' ";
    }

    if ($resultados = $mysqli->query($consultas)) {
        $entregadascon = $resultados->num_rows;
        if ($entregadascon > 0) {
            $entregadas = $entregadascon;
            $porentregadas = ($entregadas / $programadas) * 100;
        } else {
            $porentregadas = 0;
        }
    }


    $pornoentregadas = 100 - $porentregadas;

    //FIN SEGUNDA GRAFICA

}




$num_imagenes = 0;
if (isset($mes)) {
    $consultaq = "SELECT DISTINCT rol_id_orden_trabajo FROM rol_maestro_misiones INNER JOIN marcas on rol_maestro_misiones.rol_marca_id = marcas.marca_id WHERE id_usuario = '$id_user' AND MONTH(rol_maestro_misiones.fecha_programada_visita_rol) = $mes AND YEAR(rol_maestro_misiones.fecha_programada_visita_rol) = $year";
} else {
    $consultaq = "SELECT DISTINCT rol_id_orden_trabajo FROM rol_maestro_misiones INNER JOIN marcas on rol_maestro_misiones.rol_marca_id = marcas.marca_id WHERE id_usuario = '$id_user' ";
}
if ($resultadoq = $mysqli->query($consultaq)) {
    while ($objx = $resultadoq->fetch_object()) {

        $consultay = "SELECT entrega_tipo_imagen, nombre_tienda FROM entregable INNER JOIN rol_maestro_misiones on entregable.entrega_rol_id = rol_maestro_misiones.rol_maestro_id INNER JOIN tienda on rol_maestro_misiones.rol_id_tienda = tienda.tienda_id WHERE entrega_nombre_elemento = 'Foto' AND rol_id_orden_trabajo = '$objx->rol_id_orden_trabajo' ";
        if ($resultadoy = $mysqli->query($consultay)) {
            $num_imag = $resultadoy->num_rows;
            $num_imagenes = $num_imagenes + $num_imag;
            $resultadoy->close();
        }

    }
    $resultadoq->close();
}




if (isset($mes)) {
    $consultaq = "SELECT DISTINCT rol_id_orden_trabajo FROM rol_maestro_misiones INNER JOIN marcas on rol_maestro_misiones.rol_marca_id = marcas.marca_id WHERE id_usuario = '$id_user' AND MONTH(rol_maestro_misiones.fecha_programada_visita_rol) = $mes AND YEAR(rol_maestro_misiones.fecha_programada_visita_rol) = $year";
} else {
    $consultaq = "SELECT DISTINCT rol_id_orden_trabajo FROM rol_maestro_misiones INNER JOIN marcas on rol_maestro_misiones.rol_marca_id = marcas.marca_id WHERE id_usuario = '$id_user' ";
}
if ($resultadoq = $mysqli->query($consultaq)) {
    $incidencias_total = 0;
    while ($objx = $resultadoq->fetch_object()) {
        if (isset($mes)) {
            $consultay = "SELECT entrega_objetivo_id FROM entregable INNER JOIN rol_maestro_misiones on entregable.entrega_rol_id = rol_maestro_misiones.rol_maestro_id INNER JOIN tienda on rol_maestro_misiones.rol_id_tienda = tienda.tienda_id WHERE entrega_nombre_elemento = 'Comentario' AND rol_id_orden_trabajo = '$objx->rol_id_orden_trabajo' AND entrega_objetivo_id = '3' AND MONTH(rol_maestro_misiones.fecha_programada_visita_rol) = $mes AND YEAR(rol_maestro_misiones.fecha_programada_visita_rol) = $year";
        } else {
            $consultay = "SELECT entrega_objetivo_id FROM entregable INNER JOIN rol_maestro_misiones on entregable.entrega_rol_id = rol_maestro_misiones.rol_maestro_id INNER JOIN tienda on rol_maestro_misiones.rol_id_tienda = tienda.tienda_id WHERE entrega_nombre_elemento = 'Comentario' AND rol_id_orden_trabajo = '$objx->rol_id_orden_trabajo' AND entrega_objetivo_id = '3' ";
        }

        if ($resultadoy = $mysqli->query($consultay)) {
            $num_incidencias = $resultadoy->num_rows;
            $incidencias_total = $incidencias_total + $num_incidencias;
            $resultadoy->close();
        }

    }
    $resultadoq->close();
}



//$cantidadDiasdelMes = cal_days_in_month(CAL_GREGORIAN, $mes, $year);



$dataPoints2 = array(
    array("label" => "Entregadas", "y" => $porentregadas, "color" => "#b8e9f4"),
    array("label" => "Pendientes", "y" => $pornoentregadas, "color" => "red")
);

?>
<!DOCTYPE html>
<html lang="en">
<?php include('cabecera_panel.php'); ?>
<style>
    .select2-container--default .select2-selection--single {
        height:40px;
    }   
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        padding-top:5px;
    }   
 </style>   

<body class="sb-nav-fixed">
    <?php include('preloader.php'); ?>
    <?php include('header.php'); ?>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include('menu_panel.php'); ?>
        </div>


        <div id="layoutSidenav_content" style="top:10px">
            <main>
                <div class="container-fluid" style="background-color:#f0f1f7;padding-top:10px">
                    <div class="row">
                        <div class="col-12" >
                            <h4>DashBoard:</h4>

                            <form method="GET">

                            <div align="center" style="padding-top:25px;" >
                                <select id="mes" name="mes" style="width:150px" required>
                                    <option value="01" <?php if ($mes == '01') {
                                        echo "selected";
                                    } ?>>Enero</option>
                                    <option value="02" <?php if ($mes == '02') {
                                        echo "selected";
                                    } ?>>Febrero</option>
                                    <option value="03" <?php if ($mes == '03') {
                                        echo "selected";
                                    } ?>>Marzo</option>
                                    <option value="04" <?php if ($mes == '04') {
                                        echo "selected";
                                    } ?>>Abril</option>
                                    <option value="05" <?php if ($mes == '05') {
                                        echo "selected";
                                    } ?>>Mayo</option>
                                    <option value="06" <?php if ($mes == '06') {
                                        echo "selected";
                                    } ?>>Junio</option>
                                    <option value="07" <?php if ($mes == '07') {
                                        echo "selected";
                                    } ?>>Julio</option>
                                    <option value="08" <?php if ($mes == '08') {
                                        echo "selected";
                                    } ?>>Agosto</option>
                                    <option value="09" <?php if ($mes == '09') {
                                        echo "selected";
                                    } ?>>Septiembre</option>
                                    <option value="10" <?php if ($mes == '10') {
                                        echo "selected";
                                    } ?>>Octubre</option>
                                    <option value="11" <?php if ($mes == '11') {
                                        echo "selected";
                                    } ?>>Noviembre</option>
                                    <option value="12" <?php if ($mes == '12') {
                                        echo "selected";
                                    } ?>>Diciembre</option>
                                </select>
                                <select id="year" name="year" style="width:150px" required>
                                    <option <?php if ($year == '2023') {
                                        echo "selected";
                                    } ?>>2023</option>
                                    <option <?php if ($year == '2024') {
                                        echo "selected";
                                    } ?>>2024</option>
                                    <option <?php if ($year == '2025') {
                                        echo "selected";
                                    } ?>>2025</option>
                                    <option <?php if ($year == '2026') {
                                        echo "selected";
                                    } ?>>2026</option>
                                </select>
                                <input type="submit" value="Filtrar"  class="btn btn-success btn-rounded">
                                <br><br>
                            </div>

                            </form>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-xl-3 col-md-6 text-center">
                            <div class="card mb-4">
                                <div class="card-body"><span style="color:#8c9097">Visitas Realizadas</span><br><br>
                                    <i style="font-size:70px;color:white;background-color:#26bf94;border-radius:65px;padding:30px" class="fa-regular fa-compass"></i>
                                    <br><br>
                                    <span style="color:#333335;font-family:OpenSansBold;font-size:20px">Totales:</span>
                                    <?php echo ($num_total); ?>
                                </div>
                                <!--
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                     <a style="color:#26bf94" class="small stretched-link" href="coberturas.php">Ver detalle</a>
                                    <div class="small"><i style="color:#26bf94" class="fas fa-angle-right"></i></div>
                                </div>
                                -->
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 text-center">
                            <div class="card mb-4">
                                <div class="card-body"><span style="color:#8c9097">Coberturas</span><br><br>
                                    <i style="font-size:55px;color:white;background-color:#129fd6;border-radius:92px;padding:35px" class="fa-regular fa-map"></i>
                                    <br><br>
                                    <span style="color:#333335;font-family:OpenSansBold;font-size:20px">%Coberturas =</span>
                                    <?php echo number_format($porentregadas, 2); ?>%
                                </div>
                                <!--
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                     <a style="color:#129fd6" class="small stretched-link" href="orden.php">Ver detalle</a>
                                    <div class="small"><i style="color:#129fd6" class="fas fa-angle-right"></i></div>
                                </div>
                                -->
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 text-center">
                            <div class="card mb-4">
                                <div class="card-body"><span style="color:#8c9097">Incidencias</span><br><br>
                                    <i style="font-size:70px;color:white;background-color:#845adf;border-radius:65px;padding:30px" class="fa-regular fa-circle-xmark"></i>
                                    <br><br>
                                    <span style="color:#333335;font-family:OpenSansBold;font-size:20px">Totales:</span>
                                    <?php echo ($incidencias_total); ?>
                                </div>
                                <!--
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                     <a style="color:#845adf" class="small stretched-link" href="incidencias.php">Ver detalle</a>
                                    <div class="small"><i style="color:#845adf" class="fas fa-angle-right"></i></div>
                                </div>
                                -->
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 text-center">
                            <div class="card mb-4">
                                <div class="card-body"><span style="color:#8c9097">Imágenes</span><br><br>
                                    <i style="font-size:55px;color:white;background-color:#f5b849;border-radius:92px;padding:35px"  class="fa-regular fa-image"></i>
                                    <br><br>
                                    <span style="color:#333335;font-family:OpenSansBold;font-size:20px">Tomadas:</span>
                                    <?php echo ($num_imagenes); ?>
                                </div>
                                <!--
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                     <a style="color:#f5b849" class="small stretched-link" href="imagenes.php">Ver detalle</a>
                                    <div  class="small"><i style="color:##f5b849" class="fas fa-angle-right"></i></div>
                                </div>
                                -->
                            </div>
                        </div>

                    </div>




                    <div class="row">
                        <div class="col-12 col-md-6 text-center">
                            <div id="chartContainer1"></div>
                        </div>
                        <div class="col-12 col-md-6 text-center">
                            <div id="chartContainer2"></div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>


    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>

    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

    <script>
        
        window.onload = function () {
            var chart1 = new CanvasJS.Chart("chartContainer1", {

                animationEnabled: true,
                title: {
                    text: ""
                },
                subtitles: [{
                    text: "Visitas realizadas: <?php echo $num_total ?>",
                    fontFamily:"OpenSansBold"


                }],
                data: [{
                    type: "bar",
                    yValueFormatString: "",
                    indexLabel: "{label} ({y})",
                    dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>,
                    color: '#b8e9f4',
                }],
                
            });

            chart1.render();

            var chart2 = new CanvasJS.Chart("chartContainer2", {
                animationEnabled: true,
                title: {
                    text: ""
                },
                subtitles: [{
                    text: "Visitas Programadas: <?php echo $programadas ?>",
                    fontFamily:"OpenSansBold"
                }],
                data: [{
                    type: "pie",
                    yValueFormatString: "#,##0.00\"%\"",
                    indexLabel: "{label} ({y})",
                    dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>,
                    color: '#b8e9f4',
                }],
                
            });

            chart2.render();
        }



    </script>
    <script src="js/select2.js"></script>
    <script>
        $("#mes").select2( {
            placeholder: "Selecciona",
            allowClear: false
        } );
        $("#year").select2( {
            placeholder: "Selecciona",
            allowClear: false
        } );
    </script>

</body>

</html>