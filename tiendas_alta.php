<?php include('pass.php');
require_once('conexion.php');
?>
<!DOCTYPE html>
<html lang="en">
<?php include('cabecera_panel.php'); ?>
<style>
    #map {
        height: 100%;
    }
</style>

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

                        <div align="center" class="col-12 col-md-6">
                            <form method="post" enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']; ?>">

                                <br>
                                <h2 style="font-size:25px;">Alta de Cliente</h2>

                                <div class="form-group">
                                    <h6><b>Nombre:</b></h6>
                                    <input class="form-control" type='text' name='nombre' required />
                                </div>

                                <div class="form-group">
                                    <h6><b>Calle:</b></h6>
                                    <input class="form-control" type='text' name='calle' required />
                                </div>

                                <div class="form-group">
                                    <h6><b>Número Exterior:</b></h6>
                                    <input class="form-control" type='text' name='numero_exterior' required />
                                </div>

                                <div class="form-group">
                                    <h6><b>Colonia:</b></h6>
                                    <input class="form-control" type='text' name='colonia' required />
                                </div>

                                <div class="form-group">
                                    <h6><b>Código Postal:</b></h6>
                                    <input class="form-control" type='text' name='codigo_postal' required />
                                </div>

                                <div class="form-group">
                                    <h6><b>Alcaldía o Municipio:</b></h6>
                                    <input class="form-control" type='text' name='alcaldia_municipio' required />
                                </div>

                                <div class="form-group">
                                    <h6><b>Ciudad:</b></h6>
                                    <input class="form-control" type='text' name='ciudad' required />
                                </div>

                                <div class="form-group">
                                    <h6><b>Coordenadas:</b></h6>
                                    <h6>Ubica el lugar en el mapa y haz click sobre él para obtener las coordenadas</h6>
                                    <input class="form-control" type='text' id="coordenadas" name='coordenadas'
                                        required />
                                </div>

                                <div class="form-group">
                                    <h6><b>Encargado:</b></h6>
                                    <input class="form-control" type='text' name='encargado' />
                                </div>

                                <br>
                                <h6><b>Incluir Código QR:</b></h6>
                                <select name='codigoqr' required>
                                    <option value="" hidden>Seleccione</option>
                                    <option value="Si">Sí</option>
                                    <option>No</option>
                                </select>
                                <br>

                                <?php
                                if ($_SESSION['permisos'] == 'Administrador') {
                                    ?>
                                    <div class="form-group">
                                        <h6><b>Cliente:</b></h6>
                                        <select class="form-control" name="id_administrador" required>
                                            <option value="" hidden>Seleccione</option>
                                            <?php
                                            $sql = "SELECT * FROM marcas";
                                            if ($resql = $mysqli->query($sql)) {
                                                while ($obsql = $resql->fetch_object()) {
                                                    ?>
                                                    <option value="<?php echo $obsql->id_usuario; ?>"><?php echo $obsql->nombre_marca; ?></option>
                                                    <?php
                                                }
                                                $resql->close();
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <?php
                                }
                                ?>


                                <br>
                                <div class="text-center">
                                    <input class="btn btn-success btn-rounded" type='submit' name='Alta'
                                        value='Guardar' />
                                </div>
                                <br><br>
                            </form>
                        </div>
                        <div align="center" class="col-12 col-md-6">
                            <!-- mapa de google -->
                            <div id="map"></div>
                        </div>
                        <?php
                        if (isset($_REQUEST['Alta'])) {

                            if ($_SESSION['permisos'] == 'Cliente') {

                            $nombre = $_REQUEST['nombre'];
                            $calle = $_REQUEST['calle'];
                            $numero_exterior = $_REQUEST['numero_exterior'];
                            $colonia = $_REQUEST['colonia'];
                            $codigo_postal = $_REQUEST['codigo_postal'];
                            $alcaldia_municipio = $_REQUEST['alcaldia_municipio'];
                            $ciudad = $_REQUEST['ciudad'];
                            $ubicacion = $calle . ' ' . $numero_exterior . ' ' . $codigo_postal . ' ' . $alcaldia_municipio . ' ' . $ciudad;
                            $geo_tienda = $_REQUEST['coordenadas'];
                            $encargado = $_REQUEST['encargado'];
                            $cadena_id_tienda = 1;
                            $codigoqr = $_REQUEST['codigoqr'];

                            if ($_SESSION['permisos'] == 'Administrador') {
                                $id_administrador = $_REQUEST['id_administrador'];
                            } else {
                                $id_administrador = $_SESSION['user_id'];
                            }




                            //revisamos si existe ese nombre
                            $sql = "SELECT * FROM tienda WHERE nombre_tienda = '$nombre'";
                            if ($resX = $mysqli->query($sql)) {
                                $count = mysqli_num_rows($resX);
                            }
                            if ($count > 0) {
                                $resX->close();
                                ?>
                                <script type="text/javascript">
                                    alert('Ya existe una tienda con ese nombre, inténtelo nuevamente.');
                                    window.location.assign("tiendas_alta.php");
                                </script>
                                <?php

                            } else {



                                //revisamos si tiene espacios disponibles
                                if ($_SESSION['permisos'] == 'Cliente') {
                                    $id_administrador = $_SESSION['user_id'];

                                    //buscamos el numero maximo permitido de ubicaciones
                                    $sql = "SELECT * FROM clientes_paquetes_actuales INNER JOIN paquetes ON clientes_paquetes_actuales.id_paquete = paquetes.id_paquete WHERE clientes_paquetes_actuales.id_cliente = $id_administrador";
                                    if ($res = $mysqli->query($sql)) {
                                        $obY = $res->fetch_object();
                                        $numero_max_ubicaciones = $obY->ubicaciones;
                                        $res->close();
                                    }

                                    //contamos el numero de ubicaciones actuales
                                    $sql = "SELECT COUNT(*) as total FROM tienda WHERE id_administrador = $id_administrador";
                                    if ($res = $mysqli->query($sql)) {
                                        $obY = $res->fetch_object();
                                        $numero_ubicaciones_actuales = $obY->total;
                                        $res->close();
                                    }

                                    if (($numero_ubicaciones_actuales + 1) > $numero_max_ubicaciones) {
                                        ?>
                                        <script type="text/javascript">
                                            alert('Lo sentimos has alcanzado el número máximo de ubicaciones permitidas en tu paquete.');
                                            window.location.assign("tiendas_panel.php");
                                        </script>
                                        <?php
                                        return;
                                    }

                                }





                                $sql = "INSERT INTO tienda SET
                                    nombre_tienda = '$nombre',
                                    calle = '$calle',
                                    numero_exterior = '$numero_exterior',
                                    colonia = '$colonia',
                                    codigo_postal = '$codigo_postal',
                                    alcaldia_municipio = '$alcaldia_municipio',
                                    ciudad = '$ciudad',
                                    ubicacion_tienda = '$ubicacion',
                                    geo_tienda = '$geo_tienda',
                                    encargado_tienda = '$encargado',
                                    cadena_id_tienda = '$cadena_id_tienda',
                                    codigoqr = '$codigoqr',
                                    id_administrador = $id_administrador
                                    ";
                                $mysqli->query($sql);

                                 //buscamos el id q acabamos de dar de alta
                                 $con7 = "SELECT MAX(tienda_id) AS id FROM tienda";
                                 $res = $mysqli->query($con7);
                                 $obY = $res->fetch_object();
                                 $id_tienda = $obY->id; 
                                 $res->close();

                                 //buscamos el id de la marca
                                 $id_administrador = $_SESSION['user_id'];
                                 $con7 = "SELECT * FROM marcas WHERE id_usuario = $id_administrador";
                                 $res = $mysqli->query($con7);
                                 $obY = $res->fetch_object();
                                 $id_marca = $obY->marca_id; 
                                 $res->close();

                                //creamos la relacion 
                                $sql = "INSERT INTO relacion_m_t_c SET
                                relacion_mtc_marca_id = '$id_marca', 
                                relacion_mtc_cadena_id = 1,
                                relacion_mtc_tienda_id = '$id_tienda'
                                ";
                                $mysqli->query($sql);

                                //creamos la relacion con el objetivo por el momento es fijo (el que yo elija)
                                $sql = "INSERT INTO relacion_o_t SET
                                relacion_ot_tienda_id = '$id_tienda',
                                relacion_ot_objetivo_id = 12
                                ";
                                $mysqli->query($sql);




                                ?>
                                <script type="text/javascript">
                                    window.location.assign("tiendas_panel.php");
                                </script>
                                <?php





                            }

                        }else{
                            ?>
                                <script type="text/javascript">
                                    //aca sale esto pq necesitamos el id de la marca y para eso tendria que preguntar la marca
                                    alert("Necesita loguearse como cliente");
                                    window.location.assign("tiendas_panel.php");
                                </script>
                                <?php

                        }
                        }
                        ?>

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
    <!-- google maps -->
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDK-EMPUjLL13GqSTcLXNMFvfD5NjZeNKQ&callback=initMap&v=weekly"
        defer></script>
    <script>
        function initMap() {
            const myLatlng = { lat: 23.2129626, lng: -107.9813495 };
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 6,
                center: myLatlng,
            });
            markers = [];
            //agregamos marker
            let marker = new google.maps.Marker({
                position: { lat: 19.3907918, lng: -99.4554412 },
                map: map,
                title: 'Clicked place',
            });
            markers.push(marker);

            // Configure the click listener.
            map.addListener("click", (mapsMouseEvent) => {
                for (let i = 0; i < markers.length; i++) {
                    markers[i].setMap(null);
                }
                markers = [];
                let marker = new google.maps.Marker({
                    position: mapsMouseEvent.latLng,
                    map: map,
                });
                markers.push(marker);

                let coordenadas = JSON.stringify(mapsMouseEvent.latLng);
                coordenadas = coordenadas.replace('{"lat":', '');
                coordenadas = coordenadas.replace('"lng":', '');
                coordenadas = coordenadas.replace('}', '');



                document.getElementById('coordenadas').value = coordenadas;

            });
        }

        window.initMap = initMap;
    </script>

</body>

</html>