<?php include ('pass.php');
require_once ("conexion.php");
?>
<!DOCTYPE html>
<html lang="en">
<?php include ('cabecera_panel.php'); ?>

<body class="sb-nav-fixed">
    <?php include ('preloader.php'); ?>
    <?php include ('header.php'); ?>

    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>



    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include ('menu_panel.php'); ?>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container">
                    <div class="row">
                        <div class="col-12">

                            <br />
                            <h3>Ubicación en tiempo real</h3>
                            <div id="status"></div>
                            <br /><br />
                            <div id="map" class="text-center"></div>
                            <br /><br />

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


    </script>



    <script>
        /*Funcion para leer parametros de la url*/
        function getQueryVariable(variable) {
            var query = window.location.search.substring(1);
            var vars = query.split("&");
            for (var i = 0; i < vars.length; i++) {
                var pair = vars[i].split("=");
                if (pair[0] == variable) {
                    return pair[1];
                }
            }
            return false;
        }
    </script>

    <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-database.js"></script>



    <script>

        const firebaseConfig = {
            apiKey: "AIzaSyBtzCZaoVLWWFmB6yaPyfhjizIBi_PRN_Y",
            authDomain: "nubartf-92c12.firebaseapp.com",
            databaseURL: "https://nubartf-92c12-default-rtdb.firebaseio.com",
            projectId: "nubartf-92c12",
            storageBucket: "nubartf-92c12.appspot.com",
            messagingSenderId: "962508928465",
            appId: "1:962508928465:web:85c78f5bcfbb819a6ddcf0"
        };

        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);



    </script>





    <script>
        let map;
        let markers = [];

        async function initMap() {



            id_colaborador = getQueryVariable('id_colaborador');

            const db = firebase.database();
            const ref = await db.ref('geolocalizaciones/' + id_colaborador);

            let guideLat;
            let guideLong;
            let guideCoords = '';


            // The map, centered at CDMX
            var map = new google.maps.Map(
                document.getElementById('map'), { zoom: 19, center: { lat: 19.3909832, lng: -99.3084215 } });



            function addMarker(position, id) {
                const marker = new google.maps.Marker({
                    position: position,
                    map: map,
                });
                marker.set('id', id); // Asignar un ID al marker
                markers.push(marker);
            }

            function deleteAllMarkers() {
                // Recorrer el array de markers y eliminarlos del mapa
                for (let i = 0; i < markers.length; i++) {
                    markers[i].setMap(null);
                }
                // Vaciar el array de markers
                markers = [];
            }

            ref.on('value', (snapshot) => {
                console.log(snapshot.val());

                snapshot.forEach(element => {

                    if (element.key == 'latitud') {
                        guideLat = parseFloat(element.val());
                    }
                    if (element.key == 'longitud') {
                        guideLong = parseFloat(element.val());
                    }
                    guideCoords = { lat: parseFloat(guideLat), lng: parseFloat(guideLong) };

                    if (element.key == 'status' && element.val() == true) {
                        document.getElementById('status').innerHTML = "<btn class='btn' style='background-color: #26bf94; color:white'>Compartiendo posición</btn>";
                    } else if (element.key == 'status' && element.val() == false) {
                        document.getElementById('status').innerHTML = "<btn class='btn' style='background-color: #e55c6f; color:white'>Sin compartir posición</btn>";
                    }





                });
                console.log(guideCoords);


                // The location of Colaborator
                var place = { lat: parseFloat(guideLat), lng: parseFloat(guideLong) };


                deleteAllMarkers();
                addMarker({ lat: parseFloat(guideLat), lng: parseFloat(guideLong) }, "marker1");



                //volver a centrar el mapa
                map.setCenter(place);

            }, (errorObject) => {
                console.log('The read failed: ' + errorObject);
            });


        }


    </script>
    <!-- google maps  -->
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDK-EMPUjLL13GqSTcLXNMFvfD5NjZeNKQ&callback=initMap"></script>

</body>

</html>