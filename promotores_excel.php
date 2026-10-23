<?php session_start();
require_once("conexion.php");
date_default_timezone_set('America/Mexico_City');         
$hoy = date('Y-m-d');     
$filename = "promotores_".$hoy.".xlsx";
$id_user = $_SESSION['user_id'];


require 'vendor/autoload.php';
 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
 
$spreadsheet = new Spreadsheet();

$sheet = $spreadsheet->getActiveSheet(); 
   
// Set the value of cell A1 
$columna1 = "A";
$columna2 = "B";
$columna3 = "C";
$columna4 = "D";
$columna5 = "E";
$columna6 = "F";
$columna7 = "G";
$columna8 = "H";


$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->getColumnDimension('D')->setAutoSize(true);
$sheet->getColumnDimension('E')->setAutoSize(true);
$sheet->getColumnDimension('F')->setAutoSize(true);
$sheet->getColumnDimension('G')->setAutoSize(true);
$sheet->getColumnDimension('H')->setAutoSize(true);

$fila = 1;

//header
$sheet->setCellValue($columna1.$fila, 'OT'); 
$sheet->setCellValue($columna2.$fila, 'Técnico'); 
$sheet->setCellValue($columna3.$fila, 'Cliente'); 
$sheet->setCellValue($columna4.$fila, 'Programada'); 
$sheet->setCellValue($columna5.$fila, 'Reporte');  
$sheet->setCellValue($columna6.$fila, 'Condición'); 
$sheet->setCellValue($columna7.$fila, 'UpLoad'); 



$fila = $fila + 1;


if ($_SESSION['permisos'] == "Administrador"){
    $sql = 'SELECT * FROM  rol_maestro_misiones  INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id INNER JOIN colaboradores ON rol_maestro_misiones.colaborador_id_asignado_rol = colaboradores.col_usuario_id INNER JOIN relacion_m_t_c ON rol_maestro_misiones.rol_marca_id = relacion_m_t_c.relacion_mtc_marca_id and rol_maestro_misiones.rol_id_tienda = relacion_m_t_c.relacion_mtc_tienda_id INNER JOIN tienda ON relacion_m_t_c.relacion_mtc_tienda_id = tienda.tienda_id INNER JOIN cadena ON tienda.cadena_id_tienda = cadena.cadena_id ORDER BY rol_id_orden_trabajo DESC';    
}
if ($_SESSION['permisos'] == "Cliente"){   
    $sql = "SELECT * FROM  rol_maestro_misiones  INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id INNER JOIN colaboradores ON rol_maestro_misiones.colaborador_id_asignado_rol = colaboradores.col_usuario_id INNER JOIN relacion_m_t_c ON rol_maestro_misiones.rol_marca_id = relacion_m_t_c.relacion_mtc_marca_id and rol_maestro_misiones.rol_id_tienda = relacion_m_t_c.relacion_mtc_tienda_id INNER JOIN tienda ON relacion_m_t_c.relacion_mtc_tienda_id = tienda.tienda_id INNER JOIN cadena ON tienda.cadena_id_tienda = cadena.cadena_id WHERE marcas.id_usuario = '$id_user' ORDER BY rol_id_orden_trabajo DESC";
}

if($resql = $mysqli->query($sql)){
    while($obj = $resql->fetch_object()){ 
			
            

            $sheet->setCellValue($columna1.$fila, $obj->rol_id_orden_trabajo); 

            $sheet->setCellValue($columna2.$fila, $obj->nombre_col." ".$obj->apellido_col);  
           
            $sheet->setCellValue($columna3.$fila, $obj->nombre_tienda); 
           
            $sheet->setCellValue($columna4.$fila, $obj->fecha_programada_visita_rol); 

            
            if ($obj->fechayhorasubida == "0000-00-00 00:00:00" || $obj->fechayhorasubida == null){
                $sheet->setCellValue($columna5.$fila, "Sin Iniciar"); 
            }else{
                $sheet->setCellValue($columna5.$fila, "Entregado"); 
                
            }  

            if ($obj->fechayhorasubida != '0000-00-00 00:00:00'){
                $fecha_subida = date('Y-m-d',strtotime($obj->fechayhorasubida));
                if ($fecha_subida == $obj->fecha_programada_visita_rol){
                    $sheet->setCellValue($columna6.$fila, "Oportunamente "); 
                }else{
                    $programada = strtotime($obj->fecha_programada_visita_rol);
                    $actividad = strtotime($obj->fechayhorasubida);
                    $dif = ($actividad - $programada);
                    if($dif < 0){
                        $sheet->setCellValue($columna6.$fila, "Adelantado "); 
                    }else if ($dif >0){
                        $sheet->setCellValue($columna6.$fila, "Retrasado  "); 
                    }
                }  
            }else{
                $sheet->setCellValue($columna6.$fila, "Sin realizar"); 
            }

            $sheet->setCellValue($columna7.$fila, $obj->fechayhorasubida);  
            
            $fila = $fila + 1;
        
    } 
    $resql->close();
}    


$writer = new Xlsx($spreadsheet); 
$writer->save($filename); 
//$writer->save('php://output');


    // Initialize a file URL to the variable
    $url = 
    'https://nubartf.com/'.$filename;

echo "Archivo creado exitosamente <br>";    
echo "<a href='".$url."'>Click aqui para descargarlo</a>" 

    
?>
