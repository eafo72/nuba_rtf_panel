<?php
require_once("conexion.php");
date_default_timezone_set('America/Mexico_City');  
$hoy = date('Y-m-d');

$fecha_actual = strtotime($hoy);
$cuentas_revisadas = 0;
$cuentas_pausadas = 0;

$consulta = "SELECT * FROM clientes_paquetes_actuales";
if ($resultado = $mysqli->query($consulta)) {
    while($obj = $resultado->fetch_object()){;
        $fecha_cad = strtotime($obj->fecha_final);
        $id = $obj->id;
        $cuentas_revisadas++;
        if($fecha_actual > $fecha_cad ){    
            $sql = "UPDATE clientes_paquetes_actuales SET
            status = 'Pausado'
            WHERE id = $id";
            $mysqli->query($sql);
            $cuentas_pausadas++;
        }        
    }
    $resultado->close();
}
echo "Cuentas revisadas: ".$cuentas_revisadas."<br>";
echo "Cuentas pausadas: ".$cuentas_pausadas."<br>";
?>