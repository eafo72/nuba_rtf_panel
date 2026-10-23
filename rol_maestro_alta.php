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
                            <div align="center" class="col-12">
                                <form method="post" enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']; ?>" >


                                    <br> 
                                    <h2 style="font-size:25px;">Alta de Item del Rol Maestro</h2>

                                    <h6><b>Empresa:</b></h6>     
                                    <select id="brand" name="id_marca" onchange="busca_tiendas(this.value)" required>
                                        <option value="" hidden>Seleccione</option>
                                        <?php
                                        require_once('conexion.php');
                                        $sql = "SELECT * FROM marcas";
                                        if ($resql = $mysqli->query($sql)){
                                            while ($obsql = $resql->fetch_object()){
                                                $sql_2 = "SELECT * FROM clientes WHERE cli_usuario_id = '$obsql->mar_cliente_id'";
                                                if ($resql_2 = $mysqli->query($sql_2)){
                                                    $obsql_2 = $resql_2->fetch_object();
                                                    $name_cliente = $obsql_2->nombre_cliente.''.$obsql_2->apellido_cliente;
                                                    $resql_2->close();
                                                }
                                        ?>
                                        <option value="<?php echo $obsql->marca_id; ?>" ><?php echo $name_cliente.' / '.$obsql->nombre_marca; ?></option>
                                        <?php
                                            }
                                            $resql->close();
                                        }
                                        ?>
                                    </select>
                                    <br><br>

                                    <div id="stores"></div>


                                    <h6><b>Fecha Programada:</b></h6>     
                                    <input type='date' name='fecha_programada_visita_rol' required/>
                                    <br><br>

                                    <h6><b>Hora Programada:</b></h6>     
                                    <input type="time" name='hora_programada_visita_rol' required/>
                                    <br><br>

                                    <h6><b>Técnico:</b></h6>     
                                    <select id="empleado" name="colaborador_id_asignado_rol"  required>
                                        <option value="" hidden>Seleccione</option>
                                        <?php
                                        $sql = "SELECT * FROM colaboradores";
                                        if ($resql = $mysqli->query($sql)){
                                            while ($obsql = $resql->fetch_object()){
                                        ?>
                                        <option value="<?php echo $obsql->col_usuario_id; ?>" ><?php echo $obsql->nombre_col.' '.$obsql->apellido_col; ?></option>
                                        <?php
                                            }
                                            $resql->close();
                                        }
                                        ?>
                                    </select>
                                    <br><br>


                                    <br>  
                                    <div class="text-center" >

                                        <input  class="btn btn-success btn-rounded" type='submit' name='Terminar' value='Terminar'/>
                                        <input  class="btn btn-success btn-rounded" type='submit' name='Otra' value='Otra'/>

                                    </div>
                                </form>
                            </div>    
                            <?php
                            if(isset($_REQUEST['Terminar'])){
                                require_once('conexion.php');

                                $id_marca = $_REQUEST['id_marca'];
                                $rol_id_tienda = $_REQUEST['rol_id_tienda'];   

                                //buscamos el id de orden de trabajo
                                $sql = "SELECT * FROM folio_orden_trabajo";
                                if ($resX = $mysqli->query($sql)){
                                    $obX = $resX->fetch_object();
                                    $rol_id_orden_trabajo = $obX->id_orden_trabajo;     
                                    $resX->close();
                                }

                                $fecha_programada_visita_rol = $_REQUEST['fecha_programada_visita_rol']; 
                                $hora_programada_visita_rol = $_REQUEST['hora_programada_visita_rol'];    
                                $usuario_id_creador_rol = $_SESSION['user_id'];
                                $colaborador_id_asignado_rol = $_REQUEST['colaborador_id_asignado_rol'];


                                $sql = "INSERT INTO rol_maestro_misiones SET
                                rol_marca_id = '$id_marca',
                                rol_id_tienda = '$rol_id_tienda',
                                rol_id_orden_trabajo = '$rol_id_orden_trabajo',
                                fecha_hora_creacion_visita_rol = now(),
                                fecha_programada_visita_rol = '$fecha_programada_visita_rol',
                                hora_programada_visita_rol = '$hora_programada_visita_rol',
                                usuario_id_creador_rol = '$usuario_id_creador_rol',
                                colaborador_id_asignado_rol = '$colaborador_id_asignado_rol'
                                ";
                                $mysqli->query($sql);


                                //actualizamos el id de orden de trabajo
                                $sql = "UPDATE folio_orden_trabajo SET id_orden_trabajo = id_orden_trabajo + 1";
                                $mysqli->query($sql)


                            ?>
                            <script type="text/javascript">
                                alert ('Se ha dado de alta el item.');
                                window.location.assign("rol_maestro_panel.php");
                            </script>
                            <?php

                            }

                            if(isset($_REQUEST['Otra'])){
                                require_once('conexion.php');

                                $id_marca = $_REQUEST['id_marca'];
                                $rol_id_tienda = $_REQUEST['rol_id_tienda'];   

                                //buscamos el id de orden de trabajo
                                $sql = "SELECT * FROM folio_orden_trabajo";
                                if ($resX = $mysqli->query($sql)){
                                    $obX = $resX->fetch_object();
                                    $rol_id_orden_trabajo = $obX->id_orden_trabajo;     
                                    $resX->close();
                                }

                                $fecha_programada_visita_rol = $_REQUEST['fecha_programada_visita_rol']; 
                                $hora_programada_visita_rol = $_REQUEST['hora_programada_visita_rol'];    
                                $usuario_id_creador_rol = $_SESSION['user_id'];
                                $colaborador_id_asignado_rol = $_REQUEST['colaborador_id_asignado_rol'];


                                $sql = "INSERT INTO rol_maestro_misiones SET
                                rol_marca_id = '$id_marca',
                                rol_id_tienda = '$rol_id_tienda',
                                rol_id_orden_trabajo = '$rol_id_orden_trabajo',
                                fecha_hora_creacion_visita_rol = now(),
                                fecha_programada_visita_rol = '$fecha_programada_visita_rol',
                                hora_programada_visita_rol = '$hora_programada_visita_rol',
                                usuario_id_creador_rol = '$usuario_id_creador_rol',
                                colaborador_id_asignado_rol = '$colaborador_id_asignado_rol'
                                ";
                                $mysqli->query($sql);


                            ?>
                            <script type="text/javascript">
                                
                                window.location.assign("rol_maestro_alta.php");
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
        <script>
            function busca_tiendas(valor)
            {
                $.ajax({
                    type: "POST",
                    url: 'busca_tiendas.php',
                    data:  {id_marca: valor},
                    success: function(resp){
                        $('#stores').html(resp);
                        $("#btn_store").select2( {
                            placeholder: "Selecciona",
                            allowClear: true
                        } );
                    }
                });
            }
        </script> 
        <script>
            $("#brand").select2( {
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