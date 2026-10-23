<?php session_start();
header("Content-Type: application/json");

include ('sanitizer.php');
include ('validate.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $json = json_decode(file_get_contents('php://input'), true);
    $headers = apache_request_headers();

    $Authorization = $headers['Apikey'];

    $id_ot = $_POST['id_ot']; 
    $fecha = $_POST['fecha'];
    $concepto = $_POST['concepto'];
    $importe = $_POST['importe'];



    //validamos las entradas
    $errores_en_entradas = false;

    if ($errores_en_entradas == true) {

    } else {

        require_once ('../conexion.php');

        if (isset($Authorization) && connection::apikey() == $Authorization) {


            $archivo = "img.jpg";
            if (file_exists("../assets/comprobantes/img.jpg")) {
                $counter = 1;
                while (@file_exists('../assets/comprobantes/' . $counter . '_' . $archivo)) {
                    $counter++;
                }
                $archivo = $counter . '_' . $archivo;
            }

            $file_name = $_FILES['imagen']['name'];
            if (empty($file_name) == false) {
                $file_tmp = $_FILES['imagen']['tmp_name'];
                move_uploaded_file($file_tmp, "../assets/comprobantes/" . $archivo);
            }


            $sql = "INSERT INTO viaticos_comprobantes SET
                    id_ot = '$id_ot',
                    archivo = '$archivo',
                    concepto = '$concepto',
                    fecha = '$fecha',
                    importe = '$importe',
                    status = 'Pendiente'
                    ";
            $mysqli->query($sql);



            $resultado['mensaje'] = "Viáticos guardados";
            $resultado['error'] = false;


            header("HTTP/1.1 200");


        } else {
            header("HTTP/1.1 401");
            $resultado['mensaje'] = "Error de autenticación";
            $resultado['error'] = true;
        }

    }
    echo json_encode($resultado);

}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $json = json_decode(file_get_contents('php://input'), true);
    $headers = apache_request_headers();

    $Authorization = $headers['Apikey'];

    $id_ot = $_GET['idot'];
    $opcion = $_GET['opcion'];

    //validamos las entradas
    $errores_en_entradas = false;

    $resultado = array();

    $error = Validate::integer($opcion, 2);
    if ($error == true) {
        $errores_en_entradas = true;
        $resultado['error'] = true;
        $resultado['mensaje'] = "Error opcion inválida";
    }

    if ($opcion == 1) {
        $error = Validate::integer($id_ot, 5);
        if ($error == true) {
            $errores_en_entradas = true;
            $resultado['error'] = true;
            $resultado['mensaje'] = "Error idot inválido";
        }
        
    }


    if ($errores_en_entradas == true) {

    } else {

        require_once('../conexion.php');

        if (isset($Authorization) && connection::apikey() == $Authorization) {


            if ($opcion == 1) {
                $total = 0;
                $sql = "SELECT * FROM viaticos_comprobantes WHERE id_ot = '$id_ot' ORDER BY fecha ASC";
                if ($resX = $mysqli->query($sql)) {
                    while($obX = $resX->fetch_object()){
                        $resultado[] = array(
                            "fecha" => $obX->fecha,
                            "concepto" => $obX->concepto,
                            "importe" => $obX->importe,
                            "status" => $obX->status
                        );
                        if($obX->status == "Aceptado"){
                            $total = $total + $obX->importe;
                        }    
                    }
                    $resX->close();
                }

                $resultado[] = array(
                    "fecha" => "",
                    "concepto" => "Total",
                    "importe" => "$total"
                );
                header("HTTP/1.1 200");
            }


        } else {
            header("HTTP/1.1 401");
            $resultado['mensaje'] = "Error de autenticación";
            $resultado['error'] = true;
        }

    }
    echo json_encode($resultado);
}
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {

}
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
}
header("HTTP/1.1 400 Bad Request");
?>