<?php session_start();
header("Content-Type: application/json");

include('sanitizer.php');
include('validate.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $json = json_decode(file_get_contents('php://input'), true);
    $headers = apache_request_headers();

    $Authorization = $headers['Apikey'];

    $username = $_GET['username'];
    $password = $_GET['password'];
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
        $error = Validate::alfanumerico($username, 20);
        if ($error == true) {
            $errores_en_entradas = true;
            $resultado['error'] = true;
            $resultado['mensaje'] = "Error usuario inválido";
        }

        $error = Validate::alfanumerico($password, 20);
        if ($error == true) {
            $errores_en_entradas = true;
            $resultado['error'] = true;
            $resultado['mensaje'] = "Error contraseña inválida";
        }
    }


    if ($errores_en_entradas == true) {

    } else {

        require_once('../conexion.php');

        if (isset($Authorization) && connection::apikey() == $Authorization) {


            if ($opcion == 1) {
                $sql = "SELECT * FROM usuarios WHERE BINARY nombre_usuario = '$username'";
                if ($resX = $mysqli->query($sql)) {
                    $count = mysqli_num_rows($resX);
                    if ($count > 0) {
                        $obX = $resX->fetch_object();

                        $passBD = $obX->password;
                        $permisos = $obX->permisos;
                        $user_id = $obX->usuario_id;

                        $resX->close();

                        if (password_verify($password, $passBD)) {

                            if ($permisos == 'Colaborador') {

                                //revisamos que el colaborador este activo
                                $sql = "SELECT * FROM usuarios WHERE usuario_id = $user_id";
                                if ($resql = $mysqli->query($sql)) {
                                    $count = mysqli_num_rows($resql);
                                    if ($count > 0) {
                                        $obsql = $resql->fetch_object();
                                        $status_colaborador = $obsql->estado;
                                        $resql->close();

                                        if ($status_colaborador == 'Inactivo') {
                                            $resultado['error'] = true;
                                            $resultado['mensaje'] = "Lo sentimos tu administrador desactivó tu cuenta.";

                                        } else {

                                            //ir a buscar en colaboradores la sig info    
                                            $sql = "SELECT * FROM colaboradores WHERE col_usuario_id = '$user_id'";
                                            if ($resql = $mysqli->query($sql)) {
                                                $count = mysqli_num_rows($resql);
                                                if ($count > 0) {
                                                    $obsql = $resql->fetch_object();
                                                    $user_nombre = $obsql->nombre_col . " " . $obsql->apellido_col;
                                                    $user_address = $obsql->direccion;
                                                    $user_photo = $obsql->foto;
                                                    /*
                                                    if ($user_photo != ''){
                                                        $imagen = file_get_contents('assets/images/'.$user_photo);
                                                        $imagendata = base64_encode($imagen);    
                                                    }else{
                                                        $imagendata = '';    
                                                    }
                                                    */
                                                    $resql->close();
                                                }
                                            }

                                            $resultado['mensaje'] = "Acceso existoso";
                                            $resultado['error'] = false;
                                            $resultado[] = array(
                                                "id_usuario" => $user_id,
                                                "nombre_usuario" => $user_nombre,
                                                "direccion_usuario" => $user_address,
                                                "foto_usuario" => $user_photo
                                            );


                                        }
                                    } else {
                                        $resultado['error'] = true;
                                        $resultado['mensaje'] = "Error usuario no encontrado";
                                    }
                                }



                            } else {
                                header("HTTP/1.1 401");
                                $resultado['mensaje'] = "Ésta aplicación es sólo para colaboradores.";
                                $resultado['error'] = true;

                            }

                        } else {
                            header("HTTP/1.1 401");
                            $resultado['mensaje'] = "Password incorrecto.";
                            $resultado['error'] = true;

                        }


                    } else {
                        header("HTTP/1.1 401");
                        $resultado['mensaje'] = "Nombre de Usuario incorrecto.";
                        $resultado['error'] = true;


                    }
                }

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