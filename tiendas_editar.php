<?php include('pass.php');
require_once 'conexion.php';
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
                                    <h2 style="font-size:25px;">Editar Cliente</h2>
                                    <?php
                                    require_once("conexion.php");
                                    $id=$_GET['id'];
                                    $consulta = "SELECT * FROM tienda WHERE tienda_id = $id";
                                    $resultado = $mysqli->query($consulta);
                                    $obj = $resultado->fetch_object();
                                    
                                    $nombre_tienda = $obj->nombre_tienda;
                                    $calle = $obj->calle;
                                    $numero_exterior = $obj->numero_exterior;
                                    $colonia = $obj->colonia;
                                    $codigo_postal = $obj->codigo_postal;
                                    $alcaldia_municipio = $obj->alcaldia_municipio;
                                    $ciudad = $obj->ciudad;
                                    $geo_tienda = $obj->geo_tienda;
                                    $encargado_tienda = $obj->encargado_tienda;
                                    $codigoqr = $obj->codigoqr;
                                    $id_administrador = $obj->id_administrador;

                                    
                                    $resultado->close();
                                    ?>

                                    
                                    <div class="form-group">
                                        <h6><b>Nombre:</b></h6>     
                                        <input class="form-control" type='text' name='nombre' value="<?php echo $nombre_tienda;?>"/>
                                    </div>
                                    
                                    <div class="form-group">
                                        <h6><b>Calle:</b></h6>     
                                        <input class="form-control" type='text' name='calle' value="<?php echo $calle;?>" />
                                    </div>
                                    
                                    <div class="form-group">
                                        <h6><b>Número Exterior:</b></h6>     
                                        <input class="form-control" type='text' name='numero_exterior' value="<?php echo $numero_exterior;?>"/>
                                    </div>
                                    
                                    <div class="form-group">
                                        <h6><b>Colonia:</b></h6>     
                                        <input class="form-control" type='text' name='colonia' value="<?php echo $colonia;?>"/>
                                    </div>

                                    <div class="form-group">
                                        <h6><b>Código Postal:</b></h6>     
                                        <input class="form-control" type='text' name='codigo_postal' value="<?php echo $codigo_postal;?>" />
                                    </div>
                                                                        
                                    <div class="form-group">
                                        <h6><b>Alcaldía o Municipio:</b></h6>     
                                        <input class="form-control" type='text' name='alcaldia_municipio' 
                                        value="<?php echo $alcaldia_municipio;?>"/>
                                    </div>
                                    
                                    <div class="form-group">
                                        <h6><b>Ciudad:</b></h6>     
                                        <input class="form-control" type='text' name='ciudad' value="<?php echo $ciudad;?>" />
                                    </div>
                                    
                                    <div class="form-group">
                                        <h6><b>Coordenadas:</b></h6>
                                        <h6>Ubica el lugar en el mapa y haz click sobre él para obtener las coordenadas</h6>
                                        <input class="form-control" type='text' id="coordenadas" name='coordenadas' value="<?php echo $geo_tienda;?>" required />
                                    </div>

                                    <div class="form-group">
                                        <h6><b>Encargado:</b></h6>     
                                        <input class="form-control" type='text' name='encargado' value="<?php echo $encargado_tienda;?>" />
                                    </div>  

                                    <br>
                                    <h6><b>Incluir Código QR:</b></h6>
                                    <select name='codigoqr' required>
                                        <option <?php if($codigoqr == 'Si'){echo "selected";} ?> value="Si">Sí</option>
                                        <option <?php if($codigoqr == 'No'){echo "selected";} ?> >No</option>
                                    </select>
                                    <br>

                                    
                                    <?php
                                    if($_SESSION['permisos'] == 'Administrador'){
                                    ?>
                                    <div class="form-group">
                                        <h6><b>Cliente:</b></h6>     
                                        <select class="form-control" name="id_administrador"  required>
                                            <option value="" hidden>Seleccione</option>
                                            <?php
                                            $sql = "SELECT * FROM marcas";
                                            if ($resql = $mysqli->query($sql)){
                                                while ($obsql = $resql->fetch_object()){
                                                    ?>
                                                    <option value="<?php echo $obsql->id_usuario; ?>" <?php if($id_administrador == $obsql->id_usuario){echo "selected";} ?> ><?php echo $obsql->nombre_marca; ?></option>
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
                                        <input  class="btn btn-success btn-rounded" type="submit" name="Editar"   value="Guardar"/>
                                    </div>    
                                    <br>
                                </form>
                            </div> 
                            <div align="center" class="col-12 col-md-6">
                                <!-- mapa de google -->
                                <div id="map"></div>
                            </div>
                            
                            <?php
                            if(isset($_REQUEST['Editar'])){
                                
                                $nombre = $_REQUEST['nombre'];
                                $calle = $_REQUEST['calle'];
                                $numero_exterior = $_REQUEST['numero_exterior'];
                                $colonia = $_REQUEST['colonia'];
                                $codigo_postal = $_REQUEST['codigo_postal'];
                                $alcaldia_municipio = $_REQUEST['alcaldia_municipio'];
                                $ciudad = $_REQUEST['ciudad'];   
                                $ubicacion = $calle.' '.$numero_exterior.' '.$codigo_postal.' '.$alcaldia_municipio.' '.$ciudad; 
                                $geo_tienda = $_REQUEST['coordenadas'];
                                $encargado = $_REQUEST['encargado'];
                                $cadena_id_tienda = 1;
                                $codigoqr = $_REQUEST['codigoqr'];

                                if($_SESSION['permisos'] == 'Administrador'){
                                    $id_administrador = $_REQUEST['id_administrador'];
                                }else{
                                    $id_administrador = $_SESSION['user_id'];
                                }  
                                
                                                                 
                                $sql = "UPDATE tienda SET
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
                                WHERE tienda_id = '$id'
                                ";
                                $mysqli->query($sql);    
                            ?>
                            <script type="text/javascript">
                                window.location.assign("tiendas_panel.php");
                            </script>
                            <?php
                            }
                            ?>    

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
        <!-- google maps -->
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDK-EMPUjLL13GqSTcLXNMFvfD5NjZeNKQ&callback=initMap&v=weekly"
        defer></script>
    <script>
        function initMap() {
            let coord = "<?php echo $geo_tienda;?>";
            let combocoord = coord.split(",");
            let actlat = parseFloat(combocoord[0]);
            let actlong = parseFloat(combocoord[1]);

            const myLatlng = { lat: actlat, lng: actlong };
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
                coordenadas = coordenadas.replace('{"lat":','');
                coordenadas = coordenadas.replace('"lng":','');
                coordenadas = coordenadas.replace('}','');
                
                               

                document.getElementById('coordenadas').value = coordenadas;
               
            });
        }

        window.initMap = initMap;
    </script>
    </body>
</html>