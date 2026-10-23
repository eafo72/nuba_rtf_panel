<?php include('pass.php');?>
<!DOCTYPE html>
<html lang="en">
    <?php include('cabecera_panel.php'); ?>
    <body class="sb-nav-fixed">
        <?php include('preloader.php'); ?>
        <?php include('header.php'); ?>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <?php 
                include('menu_panel.php'); 
                $id_rol = $_GET['id'];
                $id_colaborador = $_GET['id_col'];
                ?>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <div class="row">
                            <div align="center" class="col-12">
                                <br>
                                <h2 style="font-size:25px;" id="titulopagina">Rol Detalle:</h2>
                                <button onclick="upsection();" class="btn btn-success btn-rounded" ><i class="fa fa-plus-circle m-r-5"></i> Alta de Ruta</button>
                                <br><br>
                                <table id="rol" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th style="background-color:rgb(31,78,120);color:white">Fecha</th>
                                            <th style="background-color:rgb(31,78,120);color:white" >Tienda</th>   
                                            <th style="background-color:rgb(31,78,120);color:white" >Atiende</th> 
                                            <th style="background-color:rgb(31,78,120);color:white" >Hora</th> 

                                            <?php 
                                            //buscamos SOLO las marcas q tenga el rol
                                            require_once 'conexion.php'; 
                                            $consulta = "SELECT * FROM roles INNER JOIN marcas ON roles.rol_marca_id = marcas.marca_id WHERE roles.rol_maestro_id = '$id_rol' GROUP BY marcas.nombre_marca ORDER BY marcas.nombre_marca";    
                                            if($resultado = $mysqli->query($consulta)) {
                                                $numero_marcas=mysqli_num_rows($resultado);
                                                $arreglo = array();
                                                while ($obj = $resultado->fetch_object()){
                                                    ?>
                                                    <th style="background-color:rgb(31,78,120);color:white;max-width:30px;min-width:29px;overflow:auto;font-size:10px;" ><?php echo $obj->nombre_marca; ?></th>   
                                                    <?php
                                                    $arreglo []=array("id" => $obj->marca_id,"marca" => $obj->nombre_marca);
                                                }
                                                $resultado->close();
                                            }
                                            ?>

                                            <th style="background-color:rgb(31,78,120);color:white">Opciones</th> 
                                        </tr> 
                                    </thead>     
                                    <tbody>
                                        <?php 
                                        $consulta = "SELECT * FROM roles WHERE rol_maestro_id = '$id_rol' GROUP BY rol_id_orden_trabajo ORDER BY fecha_programada_visita_rol";
                                        if($resultado = $mysqli->query($consulta)) {
                                            while ($obj = $resultado->fetch_object()){
                                                ?>
                                        <tr>
                                            <td style="max-width:30px;overflow:auto;"><h6>
                                                <?php 
                                                echo $obj->fecha_programada_visita_rol;
                                                ?></h6>
                                            </td>
                                            <td style="max-width:30px;overflow:auto;">
                                                <h6 style="font-size:10px;">

                                                    <?php 
                                                $sql="SELECT * FROM tienda WHERE tienda_id = '$obj->rol_id_tienda'";
                                                if ($resql = $mysqli->query($sql)){
                                                    $obsql = $resql->fetch_object();
                                                    $nombre_tienda = $obsql->nombre_tienda;
                                                    $resql->close();
                                                }
                                                echo $nombre_tienda;
                                                    ?>
                                                </h6>
                                            </td>
                                            <td style="max-width:30px;overflow:auto;">
                                                <h6 style="font-size:10px;">
                                                    <?php 
                                                $sql="SELECT * FROM colaboradores WHERE col_usuario_id = '$obj->colaborador_id_asignado_rol'";
                                                if ($resql = $mysqli->query($sql)){
                                                    $obsql = $resql->fetch_object();
                                                    $nombre_colaborador = $obsql->nombre_col.' '.$obsql->apellido_col;
                                                    $resql->close();
                                                }
                                                echo $nombre_colaborador;
                                                    ?>
                                                </h6>
                                            </td>
                                            <td style="max-width:30px;overflow:auto;">
                                                <a href='javascript:void(0);' onclick='hora(<?php echo $obj->rol_id_orden_trabajo;?>)'>
                                                <h6>    
                                                <?php 
                                                echo $obj->hora_programada_visita_rol;
                                                ?>
                                                </h6>
                                                </a>
                                            </td>
                                            

                                            <?php
                                                $sql = "SELECT * FROM roles INNER JOIN marcas ON roles.rol_marca_id = marcas.marca_id WHERE rol_maestro_id = '$id_rol' AND roles.fecha_programada_visita_rol = '$obj->fecha_programada_visita_rol' AND roles.rol_id_tienda = '$obj->rol_id_tienda' AND roles.colaborador_id_asignado_rol = '$obj->colaborador_id_asignado_rol' AND roles.rol_id_orden_trabajo = '$obj->rol_id_orden_trabajo' ORDER BY marcas.nombre_marca";    
                                                if ($resX = $mysqli->query($sql)){
                                                    $i = 0;
                                                    while ($obX = $resX->fetch_object()){ 

                                            ?>
                                            <td class="text-center" style="max-width:30px;overflow:auto;padding:0;border:.5px solid #a2a2a2;vertical-align:middle;">
                                                <?php 

                                                        if ($obX->seleccionado == 'Si'){
                                                            while ($i < $numero_marcas){    


                                                                //vemos si es la columna correcta
                                                                if ($obX->nombre_marca == $arreglo[$i]['marca'] && $obX->seleccionado == 'Si'){
                                                                    $role = $obX->rol_id;
                                                                    $marcaX = '"'.$obX->nombre_marca.'"';
                                                                    $fechaX = '"'.$obj->fecha_programada_visita_rol.'"';
                                                                    $idtiendaX = $obj->rol_id_tienda;
                                                                    $idcolaboradorX = $obj->colaborador_id_asignado_rol;
                                                                    echo "<a href='javascript:void(0);' onclick='borra($role,$marcaX,$fechaX,$idtiendaX,$idcolaboradorX)'>";
                                                                    //echo "<img src='assets/images/fondo_blanco.png' style='width:100%;'>";
                                                                    echo "<i class='fa fa-check' style='color:black'></i>";
                                                                    echo "</a>";
                                                                    $i++;
                                                                    break;
                                                                }

                                                                $i++;
                                                            }
                                                        }else{

                                                            $role = $obX->rol_id;
                                                            $marcaX = '"'.$arreglo[$i]['marca'].'"';
                                                            $fechaX = '"'.$obj->fecha_programada_visita_rol.'"';
                                                            $idtiendaX = $obj->rol_id_tienda;
                                                            $idcolaboradorX = $obj->colaborador_id_asignado_rol;
                                                            echo "<a href='javascript:void(0)' onclick='agrega($role,$marcaX,$fechaX,$idtiendaX,$idcolaboradorX)'>";
                                                            echo "<img src='assets/images/fondo_verde.png' style='width:100%'>";
                                                            echo "</a>";


                                                        }

                                                ?>
                                            </td>
                                            <?php

                                                    }
                                                    $resX->close();
                                                }
                                                //terminamos de llenar columnas vacias 
                                                /*    

                                            while ($i < $numero_marcas){    
                                            ?>
                                                <td class="text-center" style="max-width:30px;overflow:auto;padding:0;border:.5px solid #a2a2a2">
                                                    <?php
                                                    $marcaX = '"'.$arreglo[$i]['marca'].'"';
                                                    $fechaX = '"'.$obj->fecha_programada_visita_rol.'"';
                                                    $idtiendaX = $obj->rol_id_tienda;
                                                    $idcolaboradorX = $obj->colaborador_id_asignado_rol;
                echo "<a href='javascript:void(0)' onclick='agrega($marcaX,$fechaX,$idtiendaX,$idcolaboradorX)'>";
                                                    echo "<img src='assets/images/fondo_verde.png' style='width:100%'>";
                                                    echo "</a>";
                                            ?>
                                                </td>
                                                <?php
                                                $i++;
                                            }
                                            */    

                                            ?>    
                                            <td>
                                                <?php
                                                echo "<a href='roles_borrar.php?id_ot=$obj->rol_id_orden_trabajo&id=$id_rol&id_col=$id_colaborador' style='width:20px;'  aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Borrar'><i class='fa fa-eraser'></i></a>";

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
                                <br>
                                <a href="rol_main_panel.php" class="btn btn-success btn-rounded" >Terminar</a>
                                <br><br>
                                
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
                $('#rol').DataTable({
                    "paging":   false,
                    "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },

                });
                var posY = localStorage.getItem('top');
                if (posY != null && posY != undefined){
                    window.scroll({
                        top: posY,
                        behavior: 'smooth'
                    });
                }
            } );
        </script> 
        <script>
            function upsection(){ 
                var js = "<?php echo $id_rol; ?>";
                var js1 = "<?php echo $id_colaborador; ?>";

                window.location.assign("roles_alta_inner.php?id="+js+"&id_col="+js1); 
            }
        </script>   
        <script>
            //$marcaX,$fechaX,$idtiendaX,$idcolaboradorX
            function borra(rolid,marca,fecha,idtienda,idcolaborador){
                //alert('Eliminar :'+marca+'/'+fecha+'/Tienda :'+idtienda+'/Colaborador :'+idcolaborador);
                var windowTop = $(window).scrollTop();
                localStorage.setItem('top', windowTop);
                
                $.ajax({
                    type: "POST",
                    url: 'deselecciona_mision.php',
                    data:  {rol: rolid},
                    success: function(resp){
                        var js = "<?php echo $id_rol; ?>";
                        var js1 = "<?php echo $id_colaborador; ?>";
                        
                        window.location.assign('roles_detalle.php?id='+js+'&id_col='+js1);    
                    }
                });
            }

            function agrega(rolid,marca,fecha,idtienda,idcolaborador){
                //alert('Agregar :'+marca+'/'+fecha+'/Tienda :'+idtienda+'/Colaborador :'+idcolaborador);
                    var windowTop = $(window).scrollTop();
                    localStorage.setItem('top', windowTop);
                
                    $.ajax({
                    type: "POST",
                    url: 'selecciona_mision.php',
                    data:  {rol: rolid},
                    success: function(resp){
                        var js = "<?php echo $id_rol; ?>";
                        var js1 = "<?php echo $id_colaborador; ?>";
                        window.location.assign('roles_detalle.php?id='+js+'&id_col='+js1);    
                    }
                    });
            }
            
            function hora(rolidot){
                var opcion = prompt("Introduzca la hora :", "00:00:00");
                var size = opcion.length;
                var combohora = opcion.split(":");
                var horas = combohora[0];
                var minutos = combohora[1];
                var segundos = combohora[2];
                
                if (opcion == null || opcion == "" || opcion == "00:00:00" || size != 8 || horas > 23 || minutos > 59 || segundos > 59) {
                    alert ("Has cancelado o introducido la hora vacía o el formato no corresponde");
                } else {
                    var windowTop = $(window).scrollTop();
                    localStorage.setItem('top', windowTop);
                    $.ajax({
                    type: "POST",
                    url: 'guarda_hora.php',
                    data:  {rolot: rolidot, hora : opcion},
                    success: function(resp){
                        var js = "<?php echo $id_rol; ?>";
                        var js1 = "<?php echo $id_colaborador; ?>";
                        window.location.assign('roles_detalle.php?id='+js+'&id_col='+js1);    
                    }
                    });
                    
                }
                    
            }
            
        </script>
    </body>
</html>