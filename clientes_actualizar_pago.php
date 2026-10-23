<?php
require_once("conexion.php");
$id_administrador = $_POST['id_cliente'];

//codigo de descuento
$codigo = $_POST['codigo_descuento'];
$consulta = "SELECT * FROM descuentos WHERE codigo = '$codigo'";
if ($resultado = $mysqli->query($consulta)) {
    $count = mysqli_num_rows($resultado);
    if($count > 0){
        $obj = $resultado->fetch_object();
        $porcentaje =  $obj->porcentaje;
        $resultado->close();
        
    }else{
        $porcentaje = 0;
    }
}


//buscamos info actual del paquete
$consulta = "SELECT * FROM clientes_paquetes_actuales INNER JOIN paquetes ON clientes_paquetes_actuales.id_paquete = paquetes.id_paquete  WHERE clientes_paquetes_actuales.id_cliente = $id_administrador";
if ($resultado = $mysqli->query($consulta)) {
    $obj = $resultado->fetch_object();

    $id_paquete =  $obj->id_paquete;
    $temporalidad_dias = $obj->temporalidad_dias;
    $precio = $obj->precio;
    $fecha_inicio = $obj->fecha_inicio;
    $fecha_final = $obj->fecha_final;

    $resultado->close();
}

if($porcentaje != 0){
    $descuento = $precio * ($porcentaje *.01);
    $pago = $pago - $descuento;
}else{
    $pago = $precio;
}

date_default_timezone_set('America/Mexico_City');  
$hoy = date('Y-m-d');

if($fecha_inicio == '0000-00-00' && $fecha_final == '0000-00-00'){
    //cliente nuevo

    //guardamos la info del paquete actual en historial
    $sql = "INSERT INTO clientes_paquetes_historial SET
    id_cliente = $id_administrador,
    id_paquete = $id_paquete,
    fecha_inicio = '$fecha_inicio',
    fecha_final = '$fecha_final',
    pago = $pago,
    fecha_pago = '$hoy'
    ";
    $mysqli->query($sql);
    
    //creamos la nueva fecha de caducidad
    $nuevafecha = strtotime ( '+'.$temporalidad_dias.' day' , strtotime ( $hoy ) ) ;
    $nuevafecha = date ( 'Y-m-d' , $nuevafecha );

    $sql = "UPDATE clientes_paquetes_actuales SET
    fecha_inicio = '$hoy',
    fecha_final = '$nuevafecha',
    status = 'Activo'
    WHERE id_cliente = $id_administrador";
    $mysqli->query($sql);

}else{

    //guardamos la info del paquete actual en historial
    $sql = "INSERT INTO clientes_paquetes_historial SET
    id_cliente = $id_administrador,
    id_paquete = $id_paquete,
    fecha_inicio = '$fecha_inicio',
    fecha_final = '$fecha_final',
    pago = $pago,
    fecha_pago = '$hoy'
    ";
    $mysqli->query($sql);

    //creamos la nueva fecha de caducidad
    $nuevafecha = strtotime ( '+'.$temporalidad_dias.' day' , strtotime ( $fecha_final ) ) ;
    $nuevafecha = date ( 'Y-m-d' , $nuevafecha );

    $sql = "UPDATE clientes_paquetes_actuales SET
    fecha_inicio = '$fecha_final',
    fecha_final = '$nuevafecha',
    status = 'Activo'
    WHERE id_cliente = $id_administrador";
    $mysqli->query($sql);
}    


?>