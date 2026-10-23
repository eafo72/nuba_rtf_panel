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
                                    <h2 style="font-size:25px;">Alta de Cliente</h2>

                                    <h6><b>Usuario:</b></h6>     
                                    <select id="user" name="cli_usuario_id" required>
                                        <option value="" hidden>Seleccione</option>
                                        <?php
                                        require_once('conexion.php');
                                        $sql = "SELECT * FROM usuarios";
                                        if ($resql = $mysqli->query($sql)){
                                            while ($obsql = $resql->fetch_object()){
                                        ?>
                                        <option value="<?php echo $obsql->usuario_id; ?>"><?php echo $obsql->usuario_id.' / '.$obsql->nombre_usuario; ?></option>
                                        <?php
                                            }
                                            $resql->close();
                                        }
                                        ?>
                                    </select>
                                    <br><br>

                                    <h6><b>Nombres:</b></h6>     
                                    <input type='text' name='nombre_cliente' required/>
                                    <br><br>

                                    <h6><b>Apellidos:</b></h6>     
                                    <input type='text' name='apellido_cliente' required/>
                                    <br><br>

                                    <h6><b>Empresa:</b></h6>     
                                    <input type='text' name='nombre_empresa' required/>
                                    <br><br>

                                    <h6><b>Teléfono:</b></h6>     
                                    <input type='text' name='telefono_empresa'/>
                                    <br><br>

                                    <h6><b>Ubicación:</b></h6>     
                                    <input type='text' name='ubicacion_empresa'/>


                                    <br><br> 

                                    <br>  
                                    <div class="text-center" >
                                        <input  class="btn btn-success btn-rounded" type='submit' name='Alta' value='Guardar'/>
                                    </div>
                                </form>
                            </div>
                            <?php
                            if(isset($_REQUEST['Alta'])){

                                $cli_usuario_id = $_REQUEST['cli_usuario_id'];
                                $nombre_cliente = $_REQUEST['nombre_cliente'];
                                $apellido_cliente = $_REQUEST['apellido_cliente'];
                                $nombre_empresa = $_REQUEST['nombre_empresa'];
                                $telefono_empresa = $_REQUEST['telefono_empresa'];
                                $ubicacion_empresa = $_REQUEST['ubicacion_empresa'];


                                require_once('conexion.php');
                                $sql = "INSERT INTO clientes SET
                                cli_usuario_id = '$cli_usuario_id',
                                nombre_cliente = '$nombre_cliente',
                                apellido_cliente = '$apellido_cliente',
                                nombre_empresa = '$nombre_empresa',
                                telefono_empresa = '$telefono_empresa',
                                ubicacion_empresa = '$ubicacion_empresa'
                                ";
                                $mysqli->query($sql);

                            ?>
                            <script type="text/javascript">
                                alert ('Se ha dado de alta el cliente.');
                                window.location.assign("clientes_panel.php");
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
            $("#user").select2( {
                placeholder: "Selecciona",
                allowClear: true
            } );
        </script>
    </body>
</html>