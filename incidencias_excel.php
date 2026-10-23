<?php include('pass.php');?>
<?php // este php exporta a xls formato viejo
date_default_timezone_set('America/Mexico_City');         
$fecha = date('d-m-Y'); 
$hoy = date('Y-m-d');     
header("Pragma: public");
header("Expires: 0");
$filename = "incidencias_".$hoy.".xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");


require_once ('conexion.php');
$id_user = $_SESSION['user_id'];

?>
<table class="table" bordered="1"> 
    <tr> 
        <th ><?php echo utf8_decode('Ubicación'); ?></th>
        <th >Cliente</th>
        <th >Orden de Trabajo</th>
        <th >Fecha</th>
        <th >Comentario</th>
    </tr>
    <?php

    $consulta = "SELECT * FROM entregable INNER JOIN rol_maestro_misiones ON  entregable.entrega_rol_id =  rol_maestro_misiones.rol_maestro_id INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id WHERE entregable.entrega_objetivo_id = 3 AND marcas.mar_cliente_id = '$id_user' ORDER BY entregable.entrega_fecha_cierre DESC"; 

    if($resultado = $mysqli->query($consulta)) {
        while ($obj = $resultado->fetch_object()){

            echo "<tr>";
    ?>

    <td><?php
            $sqlX="SELECT * FROM tienda WHERE tienda_id = '$obj->rol_id_tienda'";
            if ($resX = $mysqli->query($sqlX)){
                $obX = $resX->fetch_object();
                echo utf8_decode($obX->nombre_tienda);     
                $resX->close();
            }    
        ?>
    </td>
    <td><?php echo utf8_decode($obj->nombre_marca); ?></td>
    <td><?php echo $obj->rol_id_orden_trabajo; ?></td>
    <td><?php echo $obj->entrega_fecha_cierre; ?></td>
    <td><?php echo utf8_decode($obj->entrega_tipo_texto); ?></td>



    <?php
            echo "</tr>";
        } 
    ?>

    <?php

        $resultado->close();
    }  
    ?>
    <tr></tr>
    <tr></tr>

</table>


<script>
    window.location.assign("incidencias.php");
</script>




