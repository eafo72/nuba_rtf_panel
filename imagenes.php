<?php include('pass.php');?>
<?php 
 $id_user = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
    <?php include('cabecera_panel.php'); ?>

    <body class="sb-nav-fixed">
        <?php include('preloader.php'); ?>
        <?php include('header.php'); ?>

        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <?php include('menu_panel.php'); ?>
            </div>


            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Imágenes</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="admin.php">Inicio </a></li>
                            <li class="breadcrumb-item active">Imágenes</li>
                        </ol>
                        <div class="row">
                            <div class="col-12 text-center">
                                <form method="get">


                                        <label class="control-label" >Orden de Trabajo</label>
                                        <input  type="number" name="orden" value="<?php if(isset($_GET['orden'])){echo $_GET['orden'];}  ?>"/>


                                    <div class="form-group"> <!-- Submit button -->
                                        <button class="btn btn-info " type="submit">Filtrar</button>

                                    </div>
                                </form>
                                <br>
                            </div>

                            <div class="col-12">

                                <br>



                                <div class="card mb-4">
                                    <div class="card-header"><i class="fas fa-chart-area mr-1"></i>Imágenes</div>
                                    <div class="card-body">
                                        <div class="row align-items-center">  
                                            <?php 
                                            require_once('conexion.php');                                       

                                                    if(isset($_GET['orden'])){
                                                        $orden = $_GET['orden'];
                                                        $consultay = "SELECT rol_id_tienda, rol_maestro_id, entrega_tipo_imagen, nombre_tienda, rol_id_orden_trabajo FROM entregable INNER JOIN rol_maestro_misiones on entregable.entrega_rol_id = rol_maestro_misiones.rol_maestro_id
                                                        INNER JOIN marcas on rol_maestro_misiones.rol_marca_id = marcas.marca_id INNER JOIN tienda on rol_maestro_misiones.rol_id_tienda = tienda.tienda_id WHERE entrega_nombre_elemento = 'Foto' AND rol_id_orden_trabajo = '$orden' AND id_usuario = '$id_user' OR entrega_nombre_elemento = 'Firma' AND rol_id_orden_trabajo = '$orden' AND id_usuario = '$id_user'"; 
                                                    }else{
                                                        $consultay = "SELECT rol_id_tienda, rol_maestro_id, entrega_tipo_imagen, nombre_tienda, rol_id_orden_trabajo FROM entregable INNER JOIN rol_maestro_misiones on entregable.entrega_rol_id = rol_maestro_misiones.rol_maestro_id 
                                                        INNER JOIN marcas on rol_maestro_misiones.rol_marca_id = marcas.marca_id INNER JOIN tienda on rol_maestro_misiones.rol_id_tienda = tienda.tienda_id WHERE entrega_nombre_elemento = 'Foto' AND id_usuario = '$id_user' OR entrega_nombre_elemento = 'Firma' AND mid_usuario = '$id_user' "; 
                                                    }
                                                    
                                                    
                                                    if($resultadoy = $mysqli->query($consultay)) {
                                                        $i=1;
                                                        while ($objy = $resultadoy->fetch_object()){
                                            ?> <div class="col-4 text-center">
                                            <a href="tmp/<?php echo $objy->entrega_tipo_imagen;?>" target="_blank">
                                                <img  id="imagen" class="example-image img-fluid" src="tmp/<?php echo $objy->entrega_tipo_imagen;?>" alt="Ejemplo de imagen" style="image-orientation: from-image;"><br>
                                                <a style="margin-top:-67px;" class="btn btn-info" href="consultar_tienda_info.php?id=<?php echo $objy->rol_maestro_id; ?>&ot=<?php echo $objy->rol_id_orden_trabajo;?>&tid=<?php echo $objy->rol_id_tienda;?>">OT: <?php echo $objy->rol_id_orden_trabajo;?></a>
                                                </a>    

                                            </div>
                                            <?php
                                                            if($i == 3){
                                                                ?>
                                                                <div class="col-12" style="height:10px"></div>
                                                                <?php
                                                                $i=1;
                                                            }else{
                                                                $i++;    
                                                            }
                                                        }
                                                        $resultadoy->close();   
                                                    }

                                                

                                            ?>
                                        </div>    
                                    </div>
                                   
                                </div>

                                <div class="col-12">
                                    <form method="get">
                                        <div class="row">
                                            <div class="col-6">


                                                <div class="form-group"> <!-- Date input -->
                                                    <label class="control-label" >Fecha Inicio</label>
                                                    <input class="form-control" type="date" name="fecha_inicial" value="<?php if(isset($_GET['fecha_inicial'])){echo $_GET['fecha_inicial'];}  ?>"/>
                                                </div>

                                            </div>   
                                            <div class="col-6">          

                                                <div class="form-group"> <!-- Date input -->
                                                    <label class="control-label" >Fecha Final</label>
                                                    <input class="form-control" type="date" name="fecha_final" value="<?php if(isset($_GET['fecha_final'])){echo $_GET['fecha_final']; } ?>"/>
                                                </div>


                                            </div>
                                        </div>
                                        <div class="form-group"> <!-- Submit button -->
                                            <button class="btn btn-info " name="submit" type="submit">Filtrar</button>

                                        </div>
                                    </form>
                                    <br>
                                </div>
                                <div class="col-12 text-center">
                                    <a href="imagenes_excel.php" class="btn btn-info"> Exportar Excel</a>
                                    <br><br>
                                </div>
                                <div class="card mb-4">
                                    <div class="card-header"><i class="fas fa-table mr-1"></i>DataTable Imágenes</div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table " id="dataTable" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>OT</th> 
                                                        
                                                        <th>Ubicación</th>
                                                        <th>Cliente</th>
                                                        <th>Técnico</th>
                                                        <th>Programada</th>
                                                        <th>Reporte</th> 
                                                        <th>Condición</th> 
                                                                  
                                                    </tr> 
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>OT</th> 
                                                        
                                                        <th>Ubicación</th>
                                                        <th>Cliente</th>
                                                        <th>Técnico</th>
                                                        <th>Programada</th>
                                                        <th>Reporte</th> 
                                                        <th>Condición</th> 
                                                              
                                                    </tr> 
                                                </tfoot>
                                                <tbody>
                                                    <?php 
                                                    require_once 'conexion.php'; 

                                                    if(isset($_GET['fecha_inicial']) && isset($_GET['fecha_final'])){
                                                        $fecha_inicial = $_GET['fecha_inicial'];
                                                        $fecha_final = $_GET['fecha_final']; 

                                                        if ($_SESSION['permisos'] == "Administrador"){
                                                            $consulta = "SELECT * FROM  rol_maestro_misiones  INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id INNER JOIN colaboradores ON rol_maestro_misiones.colaborador_id_asignado_rol = colaboradores.col_usuario_id INNER JOIN relacion_m_t_c ON rol_maestro_misiones.rol_marca_id = relacion_m_t_c.relacion_mtc_marca_id and rol_maestro_misiones.rol_id_tienda = relacion_m_t_c.relacion_mtc_tienda_id INNER JOIN tienda ON relacion_m_t_c.relacion_mtc_tienda_id = tienda.tienda_id INNER JOIN cadena ON tienda.cadena_id_tienda = cadena.cadena_id WHERE rol_maestro_misiones.fecha_programada_visita_rol BETWEEN '$fecha_inicial' AND '$fecha_final'";    
                                                        } 
                                                        if ($_SESSION['permisos'] == "Cliente"){   
                                                            $id_user = $_SESSION['user_id'];


                                                            $consulta = "SELECT * FROM  rol_maestro_misiones  INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id INNER JOIN colaboradores ON rol_maestro_misiones.colaborador_id_asignado_rol = colaboradores.col_usuario_id INNER JOIN relacion_m_t_c ON rol_maestro_misiones.rol_marca_id = relacion_m_t_c.relacion_mtc_marca_id and rol_maestro_misiones.rol_id_tienda = relacion_m_t_c.relacion_mtc_tienda_id INNER JOIN tienda ON relacion_m_t_c.relacion_mtc_tienda_id = tienda.tienda_id INNER JOIN cadena ON tienda.cadena_id_tienda = cadena.cadena_id WHERE marcas.id_usuario = '$id_user' AND rol_maestro_misiones.fecha_programada_visita_rol BETWEEN '$fecha_inicial' AND '$fecha_final'";
                                                        } 

                                                    }else{
                                                        if ($_SESSION['permisos'] == "Administrador"){
                                                            $consulta = 'SELECT * FROM  rol_maestro_misiones  INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id INNER JOIN colaboradores ON rol_maestro_misiones.colaborador_id_asignado_rol = colaboradores.col_usuario_id INNER JOIN relacion_m_t_c ON rol_maestro_misiones.rol_marca_id = relacion_m_t_c.relacion_mtc_marca_id and rol_maestro_misiones.rol_id_tienda = relacion_m_t_c.relacion_mtc_tienda_id INNER JOIN tienda ON relacion_m_t_c.relacion_mtc_tienda_id = tienda.tienda_id INNER JOIN cadena ON tienda.cadena_id_tienda = cadena.cadena_id';    
                                                        } 
                                                        if ($_SESSION['permisos'] == "Cliente"){   
                                                            $id_user = $_SESSION['user_id'];


                                                            $consulta = "SELECT * FROM  rol_maestro_misiones  INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id INNER JOIN colaboradores ON rol_maestro_misiones.colaborador_id_asignado_rol = colaboradores.col_usuario_id INNER JOIN relacion_m_t_c ON rol_maestro_misiones.rol_marca_id = relacion_m_t_c.relacion_mtc_marca_id and rol_maestro_misiones.rol_id_tienda = relacion_m_t_c.relacion_mtc_tienda_id INNER JOIN tienda ON relacion_m_t_c.relacion_mtc_tienda_id = tienda.tienda_id INNER JOIN cadena ON tienda.cadena_id_tienda = cadena.cadena_id WHERE marcas.id_usuario = '$id_user'";
                                                        }



                                                    }




                                                    if($resultado = $mysqli->query($consulta)) {
                                                        while ($obj = $resultado->fetch_object()){
                                                    ?>
                                                    <tr>

                                                        <td >
                                                            <?php 
                                                            echo $obj->rol_id_orden_trabajo;
                                                            ?>
                                                        </td>
                                                        
                                                        <td >
                                                            <?php
                                                            $sql = "SELECT * FROM tienda WHERE tienda_id = '$obj->rol_id_tienda'";
                                                            if ($resql = $mysqli->query($sql)){
                                                                $obsql = $resql->fetch_object();
                                                                echo $obsql->nombre_tienda;
                                                                $resql->close();
                                                            }
                                                            ?>

                                                        <td >


                                                            <?php
                                                            $sql = "SELECT * FROM rol_maestro_misiones INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id INNER JOIN colaboradores ON rol_maestro_misiones.colaborador_id_asignado_rol = colaboradores.col_usuario_id INNER JOIN relacion_m_t_c ON rol_maestro_misiones.rol_marca_id = relacion_m_t_c.relacion_mtc_marca_id and rol_maestro_misiones.rol_id_tienda = relacion_m_t_c.relacion_mtc_tienda_id INNER JOIN tienda ON relacion_m_t_c.relacion_mtc_tienda_id = tienda.tienda_id INNER JOIN cadena ON tienda.cadena_id_tienda = cadena.cadena_id WHERE rol_id_orden_trabajo = '$obj->rol_id_orden_trabajo'";
                                                            if($resultados = $mysqli->query($sql)) {
                                                                while ($objs = $resultados->fetch_object()){ 
                                                                    echo $objs->nombre_marca.", &nbsp;";

                                                                }
                                                                $resultados->close();
                                                            }
                                                            ?>

                                                        </td>
                                                        <td >
                                                            <?php 
                                                            echo $obj->nombre_col." ".$obj->apellido_col;
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
                                                        

                                                    </tr>     
                                                    <?php 
                                                        } 
                                                        $resultado->close();
                                                    }
                                                    ?>               
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                </div>

                            </div>
                        </div>
                    </div>
                </main>

            </div>
        </div>

        
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        
       
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        
   



    </body>
</html>
