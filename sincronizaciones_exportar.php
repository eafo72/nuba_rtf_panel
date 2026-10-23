<?php // este php exporta a xls formato viejo
date_default_timezone_set('America/Mexico_City');         
$fecha = date('d-m-Y'); 
$hoy = date('Y-m-d');     
header("Pragma: public");
header("Expires: 0");
$filename = "sincronizaciones_".$fecha.".xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");


require_once ('conexion.php');

$sql = "SELECT * FROM sincronizaciones INNER JOIN colaboradores ON  sincronizaciones.id_colaborador = colaboradores.col_usuario_id ORDER BY fecha DESC, hora DESC"; 
if($resql = $mysqli->query($sql)){
    ?>
    <table class="table" bordered="1">  
        <thead>
            <tr style="background-color:#f2f2f2;">
                <th><?php echo utf8_decode('Técnico'); ?></th>
                <th>Fecha</th>
                <th>Hora</th>
            </tr>
        </thead>    
        <tbody>
            <?php
            while($obj = $resql->fetch_object()){ 
                ?>
                <tr>
                    
                    <td>
                        <?php
                        echo utf8_decode($obj->nombre_col." ".$obj->apellido_col);
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $obj->fecha;
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $obj->hora;
                        ?>
                    </td>

                </tr>
                <?php
            } 
            $resql->close();
            ?>
        </tbody>        
    </table>
    <?php
}
?>
<script type="text/javascript">
    window.location.assign('asistencia.php');
</script>