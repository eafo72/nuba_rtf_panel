<?php
require_once("conexion.php");
$codigo = $_POST['codigo'];

//buscamos el codigo
$consulta = "SELECT * FROM descuentos WHERE codigo = '$codigo'";
if ($resultado = $mysqli->query($consulta)) {
    $count = mysqli_num_rows($resultado);
    if($count > 0){
        $obj = $resultado->fetch_object();
        $porcentaje =  $obj->porcentaje;
        $resultado->close();
        echo "Descuento del ".$porcentaje." porciento";
    }else{
        echo "El código no existe";
    }
}
?>