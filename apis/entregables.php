<?php session_start();
header("Content-Type: application/json");

include('sanitizer.php');
include('validate.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $json = json_decode(file_get_contents('php://input'), true);
    $headers = apache_request_headers();

    $Authorization = $headers['Apikey'];


    $entrega_rol_id = $json['entrega_rol_id'];
    $entrega_nombre_elemento = $json['entrega_nombre_elemento'];
    $entrega_tipo_texto = $json['entrega_tipo_texto'];
    $entrega_tipo_numero = $json['entrega_tipo_numero'];
    $entrega_tipo_fecha = $json['entrega_tipo_fecha'];
    $entrega_tipo_hora = $json['entrega_tipo_hora'];
    $entrega_tipo_imagen = $json['entrega_tipo_imagen'];
    $entrega_fecha_llegada = $json['entrega_fecha_llegada'];
    $entrega_hora_llegada = $json['entrega_hora_llegada'];
    $entrega_objetivo_id = $json['entrega_objetivo_id'];
    $entrega_hora_cierre = $json['entrega_hora_cierre'];
    $entrega_fecha_cierre = $json['entrega_fecha_cierre'];



    date_default_timezone_set('America/Mexico_City');
    $hoy = date('Y-m-d');
    $hora = date('H:i:s', time());

    //validamos las entradas
    $errores_en_entradas = false;

    if ($errores_en_entradas == true) {

    } else {

        require_once('../conexion.php');

        if (isset($Authorization) && connection::apikey() == $Authorization) {


            if (empty($entrega_tipo_imagen) == false) {
                //convertimos de base64 a imagen
                $data = $entrega_tipo_imagen;
                if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
                    $data = substr($data, strpos($data, ',') + 1);
                    $type = strtolower($type[1]); // jpg, png, gif

                    if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                        throw new \Exception('invalid image type');
                    }

                    $data = base64_decode($data);

                    if ($data === false) {
                        throw new \Exception('base64_decode failed');
                    }
                } else {
                    throw new \Exception('did not match data URI with image data');
                }

                $archivo = "img.{$type}";
                if (file_exists("../tmp/img.{$type}")) {
                    $counter = 1;
                    while (@file_exists('../tmp/' . $counter . '_' . $archivo)) {
                        $counter++;
                    }
                    $archivo = $counter . '_' . $archivo;
                }

                file_put_contents('../tmp/' . $archivo, $data);
                $entrega_tipo_imagen = $archivo;
            }

            //para que no ponga vacios
            if ($entrega_rol_id != 0) {

                $sql = "INSERT into entregable SET
                    entrega_rol_id = '$entrega_rol_id',
                    entrega_nombre_elemento = '$entrega_nombre_elemento',
                    entrega_tipo_texto = '$entrega_tipo_texto',
                    entrega_tipo_numero = '$entrega_tipo_numero',
                    entrega_tipo_fecha = '$entrega_tipo_fecha',
                    entrega_tipo_hora = '$entrega_tipo_hora',
                    entrega_tipo_imagen = '$entrega_tipo_imagen',
                    entrega_fecha_llegada = '$entrega_fecha_llegada',
                    entrega_hora_llegada = '$entrega_hora_llegada',
                    entrega_objetivo_id = '$entrega_objetivo_id',
                    entrega_hora_cierre = '$entrega_hora_cierre',
                    entrega_fecha_cierre = '$entrega_fecha_cierre'
                    ";
                $mysqli->query($sql);
            }

            /*
            OJO lo pasamos a misiones.php pq cuando es SOS al no haber entregables no pasa por esta api y no se guarda que ya se subio la info

            //agregar fecha subida en rolmaestro misiones
            date_default_timezone_set('America/Mexico_City');
            $mysqli->query('SET time_zone = "-06:00"');

            $sql = "UPDATE rol_maestro_misiones SET fechayhorasubida = now() WHERE rol_maestro_id = '$entrega_rol_id'";
            $mysqli->query($sql);
            */



            $resultado['mensaje'] = "Entregable guardados";
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

}
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {

}
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
}
header("HTTP/1.1 400 Bad Request");
?>