<?php include('pass.php');
if (!empty($_REQUEST['year']) && !empty($_REQUEST['month'])) {
    $year = intval($_REQUEST['year']);
    $month = intval($_REQUEST['month']);
    $lastday = intval(strftime('%d', mktime(0, 0, 0, ($month == 12 ? 1 : $month + 1), 0, ($month == 12 ? $year + 1 : $year))));
    
    //declaramos el arreglo
    $dates = array();
    
    //cargamos todas las citas del user
    require_once('conexion.php');

    if($_SESSION['permisos'] == 'Administrador'){
        $conY = "SELECT * from rol_maestro_misiones ORDER BY fecha_programada_visita_rol";
    }else if($_SESSION['permisos'] == 'Cliente'){
        $id_cliente = $_SESSION['user_id'];
        $conY = "SELECT * from rol_maestro_misiones INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id  WHERE marcas.id_usuario = $id_cliente ORDER BY fecha_programada_visita_rol";
    } 
    
    $resY = $mysqli->query($conY);
    $total = mysqli_num_rows($resY);
    if ($total > 0){
         $i = 0;  
         $olddate ='';
         $oldplace ='';
         while ($obY = $resY->fetch_object()){        
            $date = $obY->fecha_programada_visita_rol; 
            $lugar = $obY->hora_programada_visita_rol;
                            
            if ($olddate == $date) {
                $lugar = $oldplace.' / '.$obY->hora_programada_visita_rol;
                
            }else{
                $lugar = $obY->hora_programada_visita_rol;
                
            }
            $oldplace = $lugar; 
            $olddate = $date; 
             
            //agregamos cita al arreglo 
            $dates[$i] = array(
            'date' => $date,
            'badge' => true,    
            'title' => $lugar,
            'body' => $lugar);
             
            
            
             
        $i++;
        }
        
        
        
        $resY->close();
   }
    
    

    echo json_encode($dates);

} else {
    echo json_encode(array());
}