<?php
$rol_id_orden_trabajo = $_POST['rolot'];
$hora  = $_POST['hora'];
require_once('conexion.php');
$sql = "UPDATE roles SET hora_programada_visita_rol = '$hora' WHERE rol_id_orden_trabajo = '$rol_id_orden_trabajo'";
$mysqli->query($sql);
?>