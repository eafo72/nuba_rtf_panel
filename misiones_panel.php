<?php include('pass.php');?>
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
                        <div class="row">
                        <div align="center">
                                <br>
                                <h2 style="font-size:25px;" id="titulopagina">Mis Rutas <?php echo $_SESSION['user_id'];?></h2>

                                <?php
                                if(isset($_GET['prom'])){
                                    $prom = $_GET['prom'];
                                }
                                
                                if(isset($_GET['ser'])){
                                    $ser = $_GET['ser'];
                                }
                                if(isset($_GET['mar'])){
                                    $mar = $_GET['mar'];
                                }
                                if(isset($_GET['tie'])){
                                    $tie = $_GET['tie'];
                                }
                                if(isset($_GET['cad'])){
                                    $cad = $_GET['cad'];
                                }
                                require_once 'conexion.php'; 
                                if(isset($_GET['ser']) && $ser != false){

                                    $sql = "SELECT * FROM colaboradores WHERE colaborador_id = '$ser'";
                                    if ($resql = $mysqli->query($sql)){
                                        $obsql = $resql->fetch_object();
                                        $nom_bus = $obsql->nombre_col;
                                        $ape_bus = $obsql->apellido_col;
                                        $valor = 4;
                                        $resql->close();
                                    } 
                                ?>
                                <p>Del Promotor</p>
                                <input id="mytext" type="text" value="<?php echo $nom_bus." ".$ape_bus; ?>" style="display:block;"  />
                                <?php
                                }else if(isset($_GET['mar']) && $mar != false){

                                    $sql = "SELECT * FROM marcas WHERE marca_id = '$mar'";
                                    if ($resql = $mysqli->query($sql)){
                                        $obsql = $resql->fetch_object();
                                        $nom_mar = $obsql->nombre_marca;
                                        $valor = 3;
                                        $resql->close();
                                    } 

                                ?>
                                <p>De la Marca</p>
                                <input id="mytext" type="text" value="<?php echo $nom_mar; ?>" style="display:block;"  />
                                <?php         

                                }else if(isset($_GET['tie']) && $tie != false){

                                    $sql = "SELECT * FROM tienda WHERE tienda_id = '$tie'";
                                    if ($resql = $mysqli->query($sql)){
                                        $obsql = $resql->fetch_object();
                                        $nom_tie = $obsql->nombre_tienda;
                                        $valor = 2;
                                        $resql->close();
                                    } 

                                ?>
                                <p>De la Tienda</p>
                                <input id="mytext" type="text" value="<?php echo $nom_tie; ?>" style="display:block;"  />
                                <?php         

                                }else if(isset($_GET['cad']) && $cad != false){

                                    $sql = "SELECT * FROM cadena WHERE cadena_id = '$cad'";
                                    if ($resql = $mysqli->query($sql)){
                                        $obsql = $resql->fetch_object();
                                        $nom_cad = $obsql->nombre_cadena;
                                        $valor = 1;
                                        $resql->close();
                                    } 

                                ?>
                                <p>De la cadena</p>
                                <input id="mytext" type="text" value="<?php echo $nom_cad; ?>" style="display:block;"  />
                                <?php         

                                }

                                ?>

                                <br>
                                <div class="table-responsive" id="mission-container">  
                                    <table id="mission" class="records_list table  table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th><i>OT</i></th> 
                                                <th><i>Cadena</i></th>
                                                <th><i>Nombre de Tienda</i></th>
                                                <th><i>Marcas</i></th>
                                                <th><i>Promotor</i></th>
                                                <th><i>Programada</i></th>
                                                <th><i>Reporte</i></th> 
                                                <th><i>Condición</i></th> 
                                                <th><i>Ver</i></th>               
                                            </tr> 
                                        </thead> 
                                        <tfoot>
                                            <tr>
                                                <th style="max-width:30px;overflow:auto;">Filter..</th>
                                                <th style="max-width:30px;overflow:auto;">Filter..</th>
                                                <th style="max-width:30px;overflow:auto;">Filter..</th>
                                                <th style="max-width:30px;overflow:auto;">Filter..</th>
                                                <th style="max-width:30px;overflow:auto;">Filter..</th>
                                                <th style="max-width:30px;overflow:auto;">Filter..</th>
                                                <th style="max-width:30px;overflow:auto;">Filter..</th>
                                                <th style="max-width:30px;overflow:auto;">Filter..</th>
                                                <th style="max-width:30px;overflow:auto;">Filter..</th>
                                            </tr>
                                        </tfoot>

                                        <tbody>
                                            <?php 
                                            require_once 'conexion.php'; 

                                            if ($_SESSION['permisos'] == "Administrador"){
                                                $consulta = 'SELECT * FROM  rol_maestro_misiones  INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id INNER JOIN colaboradores ON rol_maestro_misiones.colaborador_id_asignado_rol = colaboradores.col_usuario_id INNER JOIN relacion_m_t_c ON rol_maestro_misiones.rol_marca_id = relacion_m_t_c.relacion_mtc_marca_id and rol_maestro_misiones.rol_id_tienda = relacion_m_t_c.relacion_mtc_tienda_id INNER JOIN tienda ON relacion_m_t_c.relacion_mtc_tienda_id = tienda.tienda_id INNER JOIN cadena ON tienda.cadena_id_tienda = cadena.cadena_id';    
                                            } 
                                            if ($_SESSION['permisos'] == "Cliente"){   
                                                $id_user = $_SESSION['user_id'];



                                                $consulta = "SELECT * FROM  rol_maestro_misiones  INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id INNER JOIN colaboradores ON rol_maestro_misiones.colaborador_id_asignado_rol = colaboradores.col_usuario_id INNER JOIN relacion_m_t_c ON rol_maestro_misiones.rol_marca_id = relacion_m_t_c.relacion_mtc_marca_id and rol_maestro_misiones.rol_id_tienda = relacion_m_t_c.relacion_mtc_tienda_id INNER JOIN tienda ON relacion_m_t_c.relacion_mtc_tienda_id = tienda.tienda_id INNER JOIN cadena ON tienda.cadena_id_tienda = cadena.cadena_id WHERE marcas.mar_cliente_id = '$id_user'";
                                            } 

                                            if($resultado = $mysqli->query($consulta)) {
                                                while ($obj = $resultado->fetch_object()){
                                            ?>
                                            <tr>

                                                <td style="max-width:30px;overflow:auto;"><h6>
                                                    <?php 
                                                    echo $obj->rol_id_orden_trabajo;
                                                    ?></h6>
                                                </td>
                                                <td style="max-width:30px;overflow:auto;"><h6>
                                                    <?php 
                                                    echo $obj->nombre_cadena;
                                                    ?></h6>
                                                </td>
                                                <td style="max-width:30px;overflow:auto;"><h6>
                                                    <?php
                                                    $sql = "SELECT * FROM tienda WHERE tienda_id = '$obj->rol_id_tienda'";
                                                    if ($resql = $mysqli->query($sql)){
                                                        $obsql = $resql->fetch_object();
                                                        echo $obsql->nombre_tienda;
                                                        $resql->close();
                                                    }
                                                    ?>
                                                    </h6>
                                                <td style="max-width:30px;overflow:auto;">
                                                    <h6>

                                                        <?php
                                                    $sql = "SELECT * FROM rol_maestro_misiones INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id INNER JOIN colaboradores ON rol_maestro_misiones.colaborador_id_asignado_rol = colaboradores.col_usuario_id INNER JOIN relacion_m_t_c ON rol_maestro_misiones.rol_marca_id = relacion_m_t_c.relacion_mtc_marca_id and rol_maestro_misiones.rol_id_tienda = relacion_m_t_c.relacion_mtc_tienda_id INNER JOIN tienda ON relacion_m_t_c.relacion_mtc_tienda_id = tienda.tienda_id INNER JOIN cadena ON tienda.cadena_id_tienda = cadena.cadena_id WHERE rol_id_orden_trabajo = '$obj->rol_id_orden_trabajo'";
                                                    if($resultados = $mysqli->query($sql)) {
                                                        while ($objs = $resultados->fetch_object()){ 
                                                            echo $objs->nombre_marca.", &nbsp;";

                                                        }
                                                        $resultados->close();
                                                    }
                                                        ?>
                                                    </h6>
                                                </td>
                                                <td style="max-width:30px;overflow:auto;"><h6>
                                                    <?php 
                                                    echo $obj->nombre_col." ".$obj->apellido_col;
                                                    ?></h6>
                                                </td>
                                                <td style="max-width:30px;overflow:auto;"><h6>
                                                    <?php 
                                                    echo $obj->fecha_programada_visita_rol;
                                                    ?></h6>
                                                </td>
                                                <td style="max-width:30px;overflow:auto;"><h6>
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
                                                    </h6>
                                                </td>
                                                <td style="max-width:30px;overflow:auto;"><h6>
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
                                                    </h6>
                                                </td>
                                                <td>
                                                    <?php


                                                    if ($obj->fechayhorasubida != '0000-00-00 00:00:00'){
                                                        echo "<a href='misiones_marcas.php?id_ot=$obj->rol_id_orden_trabajo&tid=$obj->rol_id_tienda' style='width:20px;' class='fa fa-eye' aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Ver Marcas'></a>"; 
                                                        
                                                    }else{ }


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
                </main>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function() {
                var table = $('#mission').DataTable({
                "responsive": false,
                "stateSave": true,
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "order": [[0, "asc"]],
            });


            });  
        </script>
        <script>
            $('#mission').dataTable( {
                "oSearch": {
                    "sSearch": "<?php echo $prom; ?>"
                }
            } );
        </script>
    </body>
</html>