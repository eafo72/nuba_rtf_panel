<?php include('pass.php');?>
<?php // este php exporta a xls formato viejo
date_default_timezone_set('America/Mexico_City');         
$fecha = date('d-m-Y'); 
$hoy = date('Y-m-d');     
header("Pragma: public");
header("Expires: 0");
$filename = "imagenes_".$hoy.".xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");


require_once ('conexion.php');
$id_user = $_SESSION['user_id'];

?>
<table class="table" bordered="1"> 
    <tr> 
        <th>OT</th> 
        
        <th><?php echo utf8_decode('Ubicación'); ?></th>
        <th>Cliente</th>
        <th><?php echo utf8_decode('Técnico'); ?></th>
        <th>Programada</th>
        <th>Reporte</th> 
        <th><?php echo utf8_decode('Condición'); ?></th> 
    </tr>
    <?php

    if ($_SESSION['permisos'] == "Administrador"){
        $consulta = 'SELECT * FROM  rol_maestro_misiones  INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id INNER JOIN colaboradores ON rol_maestro_misiones.colaborador_id_asignado_rol = colaboradores.col_usuario_id INNER JOIN relacion_m_t_c ON rol_maestro_misiones.rol_marca_id = relacion_m_t_c.relacion_mtc_marca_id and rol_maestro_misiones.rol_id_tienda = relacion_m_t_c.relacion_mtc_tienda_id INNER JOIN tienda ON relacion_m_t_c.relacion_mtc_tienda_id = tienda.tienda_id INNER JOIN cadena ON tienda.cadena_id_tienda = cadena.cadena_id';    
    } 
    if ($_SESSION['permisos'] == "Cliente"){   

        $consulta = "SELECT * FROM  rol_maestro_misiones  INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id INNER JOIN colaboradores ON rol_maestro_misiones.colaborador_id_asignado_rol = colaboradores.col_usuario_id INNER JOIN relacion_m_t_c ON rol_maestro_misiones.rol_marca_id = relacion_m_t_c.relacion_mtc_marca_id and rol_maestro_misiones.rol_id_tienda = relacion_m_t_c.relacion_mtc_tienda_id INNER JOIN tienda ON relacion_m_t_c.relacion_mtc_tienda_id = tienda.tienda_id INNER JOIN cadena ON tienda.cadena_id_tienda = cadena.cadena_id WHERE marcas.mar_cliente_id = '$id_user'";
    } 

    if($resultado = $mysqli->query($consulta)) {
        while ($obj = $resultado->fetch_object()){

            echo "<tr>";
    ?>

    <td >
        <?php 
            echo utf8_decode($obj->rol_id_orden_trabajo);
        ?>
    </td>
   
    <td >
        <?php
            $sql = "SELECT * FROM tienda WHERE tienda_id = '$obj->rol_id_tienda'";
            if ($resql = $mysqli->query($sql)){
                $obsql = $resql->fetch_object();
                echo utf8_decode($obsql->nombre_tienda);
                $resql->close();
            }
        ?>

    <td >


        <?php
            $sql = "SELECT * FROM rol_maestro_misiones INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id INNER JOIN colaboradores ON rol_maestro_misiones.colaborador_id_asignado_rol = colaboradores.col_usuario_id INNER JOIN relacion_m_t_c ON rol_maestro_misiones.rol_marca_id = relacion_m_t_c.relacion_mtc_marca_id and rol_maestro_misiones.rol_id_tienda = relacion_m_t_c.relacion_mtc_tienda_id INNER JOIN tienda ON relacion_m_t_c.relacion_mtc_tienda_id = tienda.tienda_id INNER JOIN cadena ON tienda.cadena_id_tienda = cadena.cadena_id WHERE rol_id_orden_trabajo = '$obj->rol_id_orden_trabajo'";
            if($resultados = $mysqli->query($sql)) {
                while ($objs = $resultados->fetch_object()){ 
                    echo utf8_decode($objs->nombre_marca).", &nbsp;";

                }
                $resultados->close();
            }
        ?>

    </td>
    <td >
        <?php 
            echo utf8_decode($obj->nombre_col)." ".utf8_decode($obj->apellido_col);
        ?>
    </td>
    <td >
        <?php 
            echo $obj->fecha_programada_visita_rol;
        ?>
    </td>
    <td >
        <?php

            if ($obj->fechayhorasubida == "0000-00-00 00:00:00" || $obj->fechayhorasubida == null){
        ?>

        <p>Sin Iniciar</p>

        <?php 
            }  else {
        ?>

        <p>Entregado</p>

        <?php 
            }  



        ?>

    </td>
    <td >
        <?php
            if ($obj->fechayhorasubida != '0000-00-00 00:00:00'){


                $fecha_subida = date('Y-m-d',strtotime($obj->fechayhorasubida));
                if ($fecha_subida == $obj->fecha_programada_visita_rol){
        ?>
        <p>Oportunamente </p>
        <?php 
                }else{
                    $programada = strtotime($obj->fecha_programada_visita_rol);
                    $actividad = strtotime($obj->fechayhorasubida);
                    $dif = ($actividad - $programada);
                    if($dif < 0){
        ?>
        <p>Adelantado</p>
        <?php     
                    } else if ($dif >0){
        ?>
        <p>Retrasado  </p>
        <?php  
                    }
                }  

            }else{
        ?>
        <p>Sin realizar</p>
        <?php
            }


        ?>                                       

    </td>
    <td>
        <?php


            if ($obj->fechayhorasubida != '0000-00-00 00:00:00'){
                echo "<a href='misiones_marcas.php?id_ot=$obj->rol_id_orden_trabajo&tid=$obj->rol_id_tienda' style='width:20px;' class='fa fa-eye' aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Ver Marcas'></a>"; 

            }else{ }


        ?>  
    </td>



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
    window.location.assign("imagenes.php");
</script>




