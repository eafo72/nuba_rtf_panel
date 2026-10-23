<?php session_start();
header("Content-Type: application/json");

include('sanitizer.php');
include('validate.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $json = json_decode(file_get_contents('php://input'), true);
    $headers = apache_request_headers();

    $Authorization = $headers['Apikey'];

    
    $mision_rol_maestro_id = $json['misionrol_maestroid'];
    $mision_id_orden_trabajo = $json['misionidordentrabajo'];
    $mision_id_marca  = $json['misionidmarca'];
    $fecha_inicio_mision  = $json['fechainiciomision'];
    $hora_inicio_mision = $json['horainiciomision'];
    $geo_inicio_mision = $json['geoiniciomision'];
    $pausas_mision = $json['pausasmision'];
    $reinicios_mision = $json['reiniciosmision'];
    $prcomentarios = $json['prcomentarios'];
    $fecha_entrega_mision  = $json['fechaentregamision'];
    $hora_entrega_mision = $json['horaentregamision'];
    $geo_entrega_mision  = $json['geoentregamision'];
    $soscausa = $json['soscausa'];
    $soscomentario = $json['soscomentario'];
    $status = $json['status'];
    

    date_default_timezone_set('America/Mexico_City');
    $hoy = date('Y-m-d');
    $hora = date('H:i:s', time());

    //validamos las entradas
    $errores_en_entradas = false;

    $error = Validate::integer($mision_rol_maestro_id, 4);
    if ($error == true) {
        $errores_en_entradas = true;
        $resultado['error'] = true;
        $resultado['mensaje'] = "Error mision_rol_maestro_id inválido";
    }

    $error = Validate::integer($mision_id_orden_trabajo, 4);
    if ($error == true) {
        $errores_en_entradas = true;
        $resultado['error'] = true;
        $resultado['mensaje'] = "Error mision_id_orden_trabajo inválido";
    }

    $error = Validate::integer($mision_id_marca, 4);
    if ($error == true) {
        $errores_en_entradas = true;
        $resultado['error'] = true;
        $resultado['mensaje'] = "Error mision_id_marca inválido";
    }

    if ($errores_en_entradas == true) {

    } else {

        require_once('../conexion.php');

        if (isset($Authorization) && connection::apikey() == $Authorization) {

            $sql = "INSERT into misiones SET
            mision_rol_maestro_id = '$mision_rol_maestro_id',
            mision_id_orden_trabajo = '$mision_id_orden_trabajo',
            mision_id_marca = '$mision_id_marca',
            fecha_inicio_mision = '$fecha_inicio_mision',
            hora_inicio_mision = '$hora_inicio_mision',
            geo_inicio_mision = '$geo_inicio_mision',
            pausas_mision = '$pausas_mision',
            reinicios_mision = '$reinicios_mision',
            prcomentarios = '$prcomentarios',
            fecha_entrega_mision = '$fecha_entrega_mision',
            hora_entrega_mision = '$hora_entrega_mision',
            geo_entrega_mision = '$geo_entrega_mision',
            soscausa = '$soscausa',
            soscomentario = '$soscomentario',
            status = '$status'
            ";
            $mysqli->query($sql);

            //agregar fecha subida en rolmaestro misiones
            date_default_timezone_set('America/Mexico_City');
            $mysqli->query('SET time_zone = "-06:00"');

            $sql = "UPDATE rol_maestro_misiones SET fechayhorasubida = now() WHERE rol_maestro_id = '$mision_rol_maestro_id'";
            $mysqli->query($sql);


            $resultado['mensaje'] = "Misión agregada";
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