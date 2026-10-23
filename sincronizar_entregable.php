<?php
$entrega_rol_id = $_POST['dat1'];
$entrega_nombre_elemento = $_POST['dat2'];
$entrega_tipo_texto = $_POST['dat3'];
$entrega_tipo_numero = $_POST['dat4'];
$entrega_tipo_fecha = $_POST['dat5'];
$entrega_tipo_hora = $_POST['dat6'];
$entrega_tipo_imagen = $_POST['dat7'];
$entrega_fecha_llegada = $_POST['dat8'];
$entrega_hora_llegada = $_POST['dat9'];
$entrega_objetivo_id = $_POST['dat10'];
$entrega_hora_cierre = $_POST['dat11'];
$entrega_fecha_cierre = $_POST['dat12'];


//vemos si el objetivo es de tipo venta
require_once('conexion.php');
$sql = "SELECT * FROM objetivos WHERE objetivo_id = '$entrega_objetivo_id'";
if ($resql = $mysqli->query($sql)){
    $obsql = $resql->fetch_object();
    $tipo_objetivo = $obsql->tipo_objetivo;
    $resql->close();
}
if ($tipo_objetivo == "Venta"){
    $sql = "UPDATE objetivos SET
    entregados = entregados + $entrega_tipo_numero    
    WHERE objetivo_id = '$entrega_objetivo_id'";
    $mysqli->query($sql);
}

if (empty($entrega_tipo_imagen) == false){
    //convertimos de base64 a imagen
    $data = $entrega_tipo_imagen;
    if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
        $data = substr($data, strpos($data, ',') + 1);
        $type = strtolower($type[1]); // jpg, png, gif

        if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
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
    if(file_exists("tmp/img.{$type}")){
        $counter = 1;
        while(@file_exists('tmp/'.$counter.'_'.$archivo)) { $counter++;  }
        $archivo = $counter.'_'.$archivo;
    }

    file_put_contents('tmp/'.$archivo, $data);
    $entrega_tipo_imagen = $archivo;
}


require_once('conexion.php');
//para que no ponga vacios
if($entrega_rol_id != 0){

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





if ($entrega_nombre_elemento == 'Cantidad Inventario'){
    //con $entrega_objetivo_id buscamos en objetivos el sku
    $sql = "SELECT * FROM objetivos WHERE objetivo_id = '$entrega_objetivo_id'";
    if ($resql = $mysqli->query($sql)){
        $obsql = $resql->fetch_object();
        $codigo_sku = explode(":", $obsql->nombre_objetivo);
        $sku = $codigo_sku[1];
        $resql->close();
    }
    
    //con $entrega_rol_id buscamos en rol y marcas el id tienda y el id cliente
    $sql = "SELECT * FROM rol_maestro_misiones INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id 
    WHERE rol_maestro_misiones.rol_maestro_id = '$entrega_rol_id'";
    if ($resql = $mysqli->query($sql)){
        $obsql = $resql->fetch_object();
        $tienda_id = $obsql->rol_id_tienda;
        $cliente_id = $obsql->mar_cliente_id;
        $resql->close();
    }
    
    $sql = "INSERT INTO inventario  SET
    inv_tienda_id = '$tienda_id',
    inv_sku = '$sku',
    inv_cantidad = '$entrega_tipo_numero',
    inv_fecha = '$entrega_fecha_cierre',
    inv_cliente_id = '$cliente_id'
    ";
    $mysqli->query($sql);
    
}

date_default_timezone_set('America/Mexico_City');


$mysqli->query('SET time_zone = "-06:00"');

//tambien guardamos fechayhora de la subida de info en rolmaestro
$sql = "UPDATE rol_maestro_misiones SET
fechayhorasubida = now()
WHERE rol_maestro_id = '$entrega_rol_id'";
$mysqli->query($sql);


?>





