<?php
$id_cliente = $_POST['id_cliente'];
$posicion = $_POST['posicion'];


require_once('conexion.php');
$sql = "SELECT * FROM marcas WHERE marca_id = '$id_cliente'";
if($resQ = $mysqli->query($sql)){
    $obQ = $resQ->fetch_object();
    $documentos = $obQ->documentos;
    $resQ->close();
}
$up = explode(',', $documentos);
$sizer = count($up);
$x = 0;
$nuevo = '';
while ($x < $sizer){
    if ($x != $posicion){
        if($nuevo == ''){
            
            $nuevo = $up[$x];
        }else{
            
            $nuevo = $nuevo.','.$up[$x];    
        }
        
    }
    $x++;
}

$sql = "UPDATE marcas SET documentos = '$nuevo' WHERE marca_id = '$id_cliente'";
$mysqli->query($sql);

?>