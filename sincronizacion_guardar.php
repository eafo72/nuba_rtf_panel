<?php
date_default_timezone_set('America/Mexico_City'); 
$hoy = date('Y-m-d');
$hora = date('H:i:s', time()); 

$latlong = $_POST['latlong'];
$user_id = $_POST['user_id'];
require_once('conexion.php');
 
//guardamos el log de sincronizacion    
$sql = "INSERT INTO sincronizaciones SET
id_colaborador = '$user_id',
fecha = '$hoy',
hora = '$hora',
latlong = '$latlong'
";
$mysqli->query($sql);   
?>