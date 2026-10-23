<?php
$id_rol = $_POST['rol'];
require_once('conexion.php');
$sql = "UPDATE roles SET seleccionado = 'Si' WHERE rol_id = '$id_rol'";
$mysqli->query($sql);
?>