<?php session_start();
header("Content-Type: application/json");

include('sanitizer.php');
include('validate.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $json = json_decode(file_get_contents('php://input'), true);
    $headers = apache_request_headers();

    $Authorization = $headers['Apikey'];


    $entrega_rol_id = $_POST['entrega_rol_id'];
    $entrega_nombre_elemento = $_POST['entrega_nombre_elemento'];
    $entrega_tipo_texto = $_POST['entrega_tipo_texto'];
    $entrega_tipo_numero = $_POST['entrega_tipo_numero'];
    $entrega_tipo_fecha = $_POST['entrega_tipo_fecha'];
    $entrega_tipo_hora = $_POST['entrega_tipo_hora'];
    $entrega_tipo_imagen = $_POST['entrega_tipo_imagen'];
    $entrega_fecha_llegada = $_POST['entrega_fecha_llegada'];
    $entrega_hora_llegada = $_POST['entrega_hora_llegada'];
    $entrega_objetivo_id = $_POST['entrega_objetivo_id'];
    $entrega_hora_cierre = $_POST['entrega_hora_cierre'];
    $entrega_fecha_cierre = $_POST['entrega_fecha_cierre'];



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

                //si es firma o foto
                if($entrega_nombre_elemento == 'Firma' || $entrega_nombre_elemento == 'Foto'){
                
                    $archivo = "img.jpg";
                    if (file_exists("../tmp/img.jpg")) {
                        $counter = 1;
                        while (@file_exists('../tmp/' . $counter . '_' . $archivo)) {
                            $counter++;
                        }
                        $archivo = $counter . '_' . $archivo;
                    }
                    $entrega_tipo_imagen = $archivo;
                
                    $file_name = $_FILES['imagen']['name'];
                    if (empty($file_name) == false){
                        $file_tmp =$_FILES['imagen']['tmp_name'];
                        move_uploaded_file($file_tmp,"../tmp/".$archivo);
                    }
                }

                //si es foto

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

                //agregar fecha subida en rolmaestro misiones
                date_default_timezone_set('America/Mexico_City');
                $mysqli->query('SET time_zone = "-06:00"');

                $sql = "UPDATE rol_maestro_misiones SET fechayhorasubida = now() WHERE rol_maestro_id = '$entrega_rol_id'";
                $mysqli->query($sql);


                $resultado['mensaje'] = "Entregable tipo file guardado";
                $resultado['error'] = false;


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

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

}
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {

}
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
}
header("HTTP/1.1 400 Bad Request");
?>