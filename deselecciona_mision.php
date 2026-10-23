<?php
$id_rol = $_POST['rol'];
require_once('conexion.php');
$sql = "UPDATE roles SET seleccionado = '', hora_programada_visita_rol = '00:00:00' WHERE rol_id = '$id_rol'";
$mysqli->query($sql);
?>