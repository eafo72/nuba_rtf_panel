<?php
$mision_rol_maestro_id = $_POST['dat1'];
$mision_id_orden_trabajo = $_POST['dat2'];
$mision_id_marca  = $_POST['dat3'];
$fecha_inicio_mision  = $_POST['dat4'];
$hora_inicio_mision = $_POST['dat5'];
$geo_inicio_mision = $_POST['dat6'];
$pausas_mision = $_POST['dat7'];
$reinicios_mision = $_POST['dat8'];
$prcomentarios = $_POST['dat9'];    
$fecha_entrega_mision  = $_POST['dat10'];
$hora_entrega_mision = $_POST['dat11'];
$geo_entrega_mision  = $_POST['dat12'];
$soscausa = $_POST['dat13'];
$soscomentario = $_POST['dat14'];   

require_once('conexion.php');
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
soscomentario = '$soscomentario'
";
$mysqli->query($sql);

?>