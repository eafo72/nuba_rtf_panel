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
                            <div align="center" class="col-4"></div>
                            <div align="center" class="col-4">
                                <form method="post" enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']; ?>" >


                                    <div class="form-group">
                                        <h2 style="font-size:25px;">Alta de Item para Roles</h2>
                                        <h6><b>Fecha Programada:</b></h6>     
                                        <input class="form-control" type='date' name='fecha_programada_visita_rol' required/>
                                    </div> 

                                    <div class="form-group">
                                        <h6><b>Cliente:</b></h6>     
                                        <select class="form-control" id="btn_store" name="rol_id_tienda[]" multiple="multiple" required>
                                            <option value="" hidden>Seleccione</option>
                                            <?php
                                            require_once('conexion.php');
                                            $sql = "SELECT * FROM tienda ORDER BY nombre_tienda";
                                            if ($resQ = $mysqli->query($sql)){
                                                while ($obQ = $resQ->fetch_object()){
                                                    ?>
                                                    <option value="<?php echo $obQ->tienda_id; ?>" ><?php echo $obQ->nombre_tienda; ?></option>
                                                    <?php
                                                }
                                                $resQ->close();
                                            }
                                            ?>
                                        </select>
                                    </div>


                                    <div class="text-center" >
                                        <input  class="btn btn-success btn-rounded" type='submit' name='Terminar' value='Terminar'/>
                                    </div>
                                </form>
                            </div>
                            <div align="center" class="col-4"></div>
                            <?php
                            if(isset($_REQUEST['Terminar'])){
                                require_once('conexion.php');

                                $id_rol = $_GET['id'];
                                $id_colaborador = $_GET['id_col'];

                                //buscamos todas las marcas del idrol para crear el array marcas
                                $sql = "SELECT * FROM roles WHERE rol_maestro_id = '$id_rol' GROUP BY rol_marca_id ORDER BY rol_marca_id";
                                if ($resZ = $mysqli->query($sql)){
                                    $arreglo_id_marca = array();
                                    while ($obZ = $resZ->fetch_object()){
                                        $arreglo_id_marca[]=$obZ->rol_marca_id; 
                                    } 
                                    $resZ->close();
                                }
                                $arreglo_id_tienda = $_REQUEST['rol_id_tienda'];
                                $size_arreglo_id_tienda = count($arreglo_id_tienda);
                                $x = 0;
                                while ($x <= $size_arreglo_id_tienda-1){


                                    $size_arreglo_id_marca = count($arreglo_id_marca);
                                    //guardamos cada marca con la misma orden de trabajo
                                    $i = 0;
                                    while ($i <= $size_arreglo_id_marca-1){
                                        $id_marca =  $arreglo_id_marca[$i];   
                                        $id_tienda = $arreglo_id_tienda[$x];
                                        $fecha_programada_visita_rol = $_REQUEST['fecha_programada_visita_rol']; 
                                        $usuario_id_creador_rol = $_SESSION['user_id'];
                                        $colaborador_id_asignado_rol = $_GET['id_col'];
                                        //buscamos el id de orden de trabajo
                                        $sql = "SELECT * FROM folio_orden_trabajo";
                                        if ($resX = $mysqli->query($sql)){
                                            $obX = $resX->fetch_object();
                                            $rol_id_orden_trabajo = $obX->id_orden_trabajo;     
                                            $resX->close();
                                        }
                                        $sql = "INSERT INTO roles SET
                                        rol_maestro_id = '$id_rol',
                                        rol_marca_id = '$id_marca',
                                        rol_id_tienda = '$id_tienda',
                                        rol_id_orden_trabajo = '$rol_id_orden_trabajo',
                                        fecha_hora_creacion_visita_rol = now(),
                                        fecha_programada_visita_rol = '$fecha_programada_visita_rol',
                                        usuario_id_creador_rol = '$usuario_id_creador_rol',
                                        colaborador_id_asignado_rol = '$colaborador_id_asignado_rol'
                                        ";
                                        $mysqli->query($sql);
                                        $i++;
                                    }
                                    //actualizamos el id de orden de trabajo
                                    $sql = "UPDATE folio_orden_trabajo SET id_orden_trabajo = id_orden_trabajo + 1";
                                    $mysqli->query($sql);

                                    $x++;
                                }   

                            ?>
                            <script type="text/javascript">
                                alert ('Se han dado de alta los items.');
                                var js = "<?php echo $id_rol; ?>";
                                var js1 = "<?php echo $id_colaborador; ?>";
                                window.location.assign("roles_detalle.php?id="+js+"&id_col="+js1);
                            </script>
                            <?php

                            }
                            ?>    

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
        <script src="js/select2.js"></script>
        <script>
            $("#brand").select2( {
                placeholder: "Selecciona",
                allowClear: true
            } );

            $("#btn_store").select2( {
                placeholder: "Selecciona",
                allowClear: true
            } );

            $("#empleado").select2( {
                placeholder: "Selecciona",
                allowClear: true
            } );
        </script>
    </body>
</html>