<?php session_start();
header("Content-Type: application/json");

include('sanitizer.php');
include('validate.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $json = json_decode(file_get_contents('php://input'), true);
    $headers = apache_request_headers();

    $Authorization = $headers['Apikey'];

    $id_colaborador = $json['id_usuario'];
    $latlong = $json['latlong'];

    date_default_timezone_set('America/Mexico_City');
    $hoy = date('Y-m-d');
    $hora = date('H:i:s', time());

    //validamos las entradas
    $errores_en_entradas = false;

    $error = Validate::integer($id_colaborador, 4);
    if ($error == true) {
        $errores_en_entradas = true;
        $resultado['error'] = true;
        $resultado['mensaje'] = "Error id_colaborador ".$id_colaborador." inválido";
    }

    if ($errores_en_entradas == true) {

    } else {

        require_once('../conexion.php');

        if (isset($Authorization) && connection::apikey() == $Authorization) {

            $sql = "INSERT INTO sincronizaciones SET
                id_colaborador = '$id_colaborador',
                fecha = '$hoy',
                hora = '$hora',
                latlong = '$latlong'
                ";
            $mysqli->query($sql);

            $resultado['mensaje'] = "Sincronización existosa";
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