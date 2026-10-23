<?php session_start();
header("Content-Type: application/json");

include('sanitizer.php');
include('validate.php');
require_once('../conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $json = json_decode(file_get_contents('php://input'), true);
    $headers = apache_request_headers();

    $Authorization = $headers['Apikey'];

    $id_usuario = $_GET['id_usuario'];

    //validamos las entradas
    $errores_en_entradas = false;

    $resultado = array();

    $relacionOM = array();
    $objetivos = array();
    $relacionEO = array();
    $elementosLlegada = array();
    $rolMaestroMisiones = array();
    $tienda = array();
    $marcas = array();
    $rolMaestroMisionesUnique = array();



    $error = Validate::integer($id_usuario, 4);
    if ($error == true) {
        $errores_en_entradas = true;
        $mensaje = "Error id_usuario " . $id_usuario . " inválido";
    }

    //buscamos el administrador del colaborador
    $sql = "SELECT * FROM colaboradores WHERE col_usuario_id = $id_usuario";
    if ($resql = $mysqli->query($sql)) {
        $count = mysqli_num_rows($resql);
        if ($count > 0){
            $obsql = $resql->fetch_object();
            $id_administrador = $obsql->id_administrador;
            $resql->close();
        }else{
            $errores_en_entradas = true;
            $mensaje = "Error no se encontró el administrador del colaborador";
        }    
    }


    //revisamos el status del paquete del cliente
    $sql = "SELECT * FROM clientes_paquetes_actuales WHERE id_cliente = $id_administrador";
    if ($resql = $mysqli->query($sql)) {
        $count = mysqli_num_rows($resql);
        if ($count > 0){
            $obsql = $resql->fetch_object();
            $status = $obsql->status;
            $resql->close();

            if($status == 'Pausado'){
                $errores_en_entradas = true;
                $mensaje = "Lo sentimos tu cuenta está en pausa, por favor contacta a tu administrador";    
            }
        }else{
            $errores_en_entradas = true;
            $mensaje = "Error no se encontró el paquete actual del cliente";
        }                
    }

    //revisamos que el colaborador este activo
    $sql = "SELECT * FROM usuarios WHERE usuario_id = $id_usuario";
    if ($resql = $mysqli->query($sql)) {
        $count = mysqli_num_rows($resql);
        if ($count > 0){
            $obsql = $resql->fetch_object();
            $status_colaborador = $obsql->estado;
            $resql->close();

            if($status_colaborador == 'Inactivo'){
                $errores_en_entradas = true;
                $mensaje = "Lo sentimos tu administrador desactivó tu cuenta.";    
            }
        }else{
            $errores_en_entradas = true;
            $mensaje = "Error usuario no encontrado";
        }                
    }


    if ($errores_en_entradas == true) {

            $resultado[] = array(
                "error" => $errores_en_entradas,
                "mensaje" => $mensaje
            );

    } else {

        

        if (isset($Authorization) && connection::apikey() == $Authorization) {


            /*
            $sql = "SELECT * FROM relacion_o_m";
            if ($resql = $mysqli->query($sql)) {
                while ($obsql = $resql->fetch_object()) {

                    $relacionOM[] = array(
                        "relacion_om_id" => $obsql->relacion_om_id,
                        "relacion_om_mtc_id" => $obsql->relacion_om_mtc_id,
                        "relacion_om_objetivo_id" => $obsql->relacion_om_objetivo_id
                    );

                }
                $resql->close();
            }
            */

            $sql = "SELECT * FROM relacion_o_t";
            if ($resql = $mysqli->query($sql)) {
                while ($obsql = $resql->fetch_object()) {

                    $relacionOT[] = array(
                        "relacion_ot_id" => $obsql->relacion_ot_id,
                        "relacion_ot_tienda_id" => $obsql->relacion_ot_tienda_id,
                        "relacion_ot_objetivo_id" => $obsql->relacion_ot_objetivo_id
                    );

                }
                $resql->close();
            }

            $sql = "SELECT * FROM objetivos";
            if ($resql = $mysqli->query($sql)) {
                while ($obsql = $resql->fetch_object()) {

                    $objetivos[] = array(
                        "objetivo_id" => $obsql->objetivo_id,
                        "nombre_objetivo" => $obsql->nombre_objetivo,
                        "imagen_objetivo" => $obsql->imagen_objetivo,
                        "tipo_objetivo" => $obsql->tipo_objetivo,
                        "meta" => $obsql->meta,
                        "entregados" => $obsql->entregados,
                        "firma" => $obsql->firma
                    );
                }
                $resql->close();
            }

            $sql = "SELECT * FROM relacion_e_o";
            if ($resql = $mysqli->query($sql)) {
                while ($obsql = $resql->fetch_object()) {

                    $relacionEO[] = array(
                        "relacion_eo_id" => $obsql->relacion_eo_id,
                        "relacion_eo_objetivo_id" => $obsql->relacion_eo_objetivo_id,
                        "relacion_eo_elementos_id" => $obsql->relacion_eo_elementos_id,
                        "orden_aparicion" => $obsql->orden_aparicion
                    );

                }
                $resql->close();
            }

            $sql = "SELECT * FROM elementos_llegada";
            if ($resql = $mysqli->query($sql)) {
                while ($obsql = $resql->fetch_object()) {

                    $elementosLlegada[] = array(
                        "elemento_id" => $obsql->elemento_id,
                        "nombre_elemento" => $obsql->nombre_elemento,
                        "script_elemento" => $obsql->script_elemento,
                        "name" => $obsql->name,
                        "tipo_entrega" => $obsql->tipo_entrega
                    );

                }
                $resql->close();
            }

            $sql = "SELECT * FROM rol_maestro_misiones WHERE colaborador_id_asignado_rol = '$id_usuario'";
            if ($resql = $mysqli->query($sql)) {
                while ($obsql = $resql->fetch_object()) {

                    $rolMaestroMisiones[] = array(

                        "rol_maestro_id" => $obsql->rol_maestro_id,
                        "rol_marca_id" => $obsql->rol_marca_id,
                        "rol_id_tienda" => $obsql->rol_id_tienda,
                        "rol_id_orden_trabajo" => $obsql->rol_id_orden_trabajo,
                        "fecha_hora_creacion_visita_rol" => $obsql->fecha_hora_creacion_visita_rol,
                        "fecha_programada_visita_rol" => $obsql->fecha_programada_visita_rol,
                        "hora_programada_visita_rol" => $obsql->hora_programada_visita_rol,
                        "usuario_id_creador_rol" => $obsql->usuario_id_creador_rol,
                        "colaborador_id_asignado_rol" => $obsql->colaborador_id_asignado_rol,
                        "fechayhorasubida" => $obsql->fechayhorasubida,
                        "geosubida" => $obsql->geosubida

                    );



                    //tambien agrega solo la tienda del rol maestro
                    $sqlQ = "SELECT * FROM tienda WHERE tienda_id = '$obsql->rol_id_tienda'";
                    if ($resqlQ = $mysqli->query($sqlQ)) {
                        while ($obsqlQ = $resqlQ->fetch_object()) {
                            $doc = $obsqlQ->documento;
                            if ($doc == null) {
                                $doc = '';
                            }

                            $tienda[] = array(
                                "tienda_id" => $obsqlQ->tienda_id,
                                "nombre_tienda" => $obsqlQ->nombre_tienda,
                                "ubicacion_tienda" => $obsqlQ->ubicacion_tienda,
                                "geo_tienda" => $obsqlQ->geo_tienda,
                                "encargado_tienda" => $obsqlQ->encargado_tienda,
                                "documento" => $doc,
                                "codigoqr" => $obsqlQ->codigoqr,
                                "cadena_id_tienda" => $obsqlQ->cadena_id_tienda
                            );

                        }
                        $resqlQ->close();
                    }

                    //tambien agrega solo la marca del rol maestro
                    $sqlM = "SELECT * FROM marcas WHERE marca_id = '$obsql->rol_marca_id'";
                    if ($resqlM = $mysqli->query($sqlM)) {
                        while ($obsqlM = $resqlM->fetch_object()) {

                            $marcas[] = array(
                                "marca_id" => $obsqlM->marca_id,
                                "mar_cliente_id" => $obsqlM->mar_cliente_id,
                                "nombre_marca" => $obsqlM->nombre_marca,
                                "descripcion_marca" => $obsqlM->descripcion_marca,
                                "tipo_marca" => $obsqlM->tipo_marca,
                                "no_marca" => $obsqlM->no_marca,
                                "documentos" => $obsqlM->documentos,
                                "incluye_inventario" => $obsqlM->incluye_inventario
                            );

                        }
                        $resqlM->close();
                    }

                }
                $resql->close();
            }

            $sql = "SELECT * FROM rol_maestro_misiones WHERE colaborador_id_asignado_rol = '$id_usuario' GROUP BY rol_id_orden_trabajo";

            if ($resql = $mysqli->query($sql)) {
                while ($obsql = $resql->fetch_object()) {

                    $rolMaestroMisionesUnique[] = array(

                        "rol_maestro_id" => $obsql->rol_maestro_id,
                        "rol_marca_id" => $obsql->rol_marca_id,
                        "rol_id_tienda" => $obsql->rol_id_tienda,
                        "rol_id_orden_trabajo" => $obsql->rol_id_orden_trabajo,
                        "fecha_hora_creacion_visita_rol" => $obsql->fecha_hora_creacion_visita_rol,
                        "fecha_programada_visita_rol" => $obsql->fecha_programada_visita_rol,
                        "hora_programada_visita_rol" => $obsql->hora_programada_visita_rol,
                        "usuario_id_creador_rol" => $obsql->usuario_id_creador_rol,
                        "colaborador_id_asignado_rol" => $obsql->colaborador_id_asignado_rol,
                        "fechayhorasubida" => $obsql->fechayhorasubida,
                        "geosubida" => $obsql->geosubida

                    );

                }
                $resql->close();
            }


            $mensaje = "Exportación existosa";
            $error = false;

            $resultado[] = array(
                "relacionOM" => $relacionOM,
                "relacionOT" => $relacionOT,
                "objetivos" => $objetivos,
                "relacionEO" => $relacionEO,
                "elementosLlegada" => $elementosLlegada,
                "rolMaestroMisiones" => $rolMaestroMisiones,
                "tienda" => $tienda,
                "marcas" => $marcas,
                "rolMaestroMisionesUnique" => $rolMaestroMisionesUnique,
                "error" => $error,
                "mensaje" => $mensaje
            );

            header("HTTP/1.1 200");

        } else {
            header("HTTP/1.1 401");
            $mensaje = "Error de autenticación";
            $error = true;

            $resultado[] = array(
                "error" => $error,
                "mensaje" => $mensaje
            );
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