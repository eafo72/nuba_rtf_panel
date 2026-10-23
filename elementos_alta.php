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
                                    <h2 style="font-size:25px;">Alta de Elemento</h2>

                                    <h6><b>Nombre:</b></h6>     
                                    <input type='text' name='nombre' size="20" required><br><br>

                                    <h6><b>Script:</b></h6>     
                                    <textarea name='script' cols="50" rows="5" required></textarea><br><br>

                                    <h6><b>Name:</b></h6>     
                                    <input type='text' name='name' required/><br><br>

                                    <h6><b>Tipo Entrega:</b></h6>     
                                    <select name="tipo_entrega" required>
                                        <option value="" hidden>Seleccione</option>
                                        <option>Archivo</option>
                                        <option>Dato Texto</option>
                                        <option>Dato Numero</option>
                                        <option>Dato Numero Inventario</option>
                                        <option>Dato Numero Venta</option>
                                        <option>Dato Fecha</option>
                                        <option>Dato Hora</option>
                                    </select>

                                    <br><br>

  
                                    <div class="text-center" >
                                        <input  class="btn btn-success btn-rounded" type='submit' name='Alta' value='Guardar'/>
                                    </div>
                                </form>
                            </div> 
                            <?php
                            if(isset($_REQUEST['Alta'])){
                                $nombre_nuevo = $_REQUEST['nombre'];
                                $script = $_REQUEST['script'];
                                $name = $_REQUEST['name'];
                                $tipo_entrega = $_REQUEST['tipo_entrega'];

                                require_once('conexion.php');
                                $sql = "INSERT INTO elementos_llegada SET
                                nombre_elemento = '$nombre_nuevo',
                                script_elemento = '$script',
                                tipo_entrega = '$tipo_entrega',
                                name = '$name'
                                ";
                                $mysqli->query($sql);

                            ?>
                            <script type="text/javascript">
                                alert ('Se ha dado de alta el elemento.');
                                window.location.assign("elementos_panel.php");
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
    </body>
</html>