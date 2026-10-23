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
                                    <h2 style="font-size:25px;">Alta de Ticket</h2>

                                    <?php  $id_user = $_SESSION['user_id'];
                                    date_default_timezone_set('america/mexico_city');
                                    $fecha_alta_ticket = date('Y/m/d');
                                    ?>  
                                    <input type='hidden' name='cliente_id_ticket' value='<?php echo $id_user; ?>' required/>
                                    <input type='hidden' name='fecha_alta_ticket' value='<?php echo $fecha_alta_ticket; ?>' required/> 
                                    <input type='hidden' name='estatus_ticket' value='Creado' required/>                       
                                    <h6><b>Orden de trabajo:</b></h6>     
                                    <input type='number' name='ot_ticket'/>
                                    <br><br>

                                    <h6><b>Mensaje:</b></h6>     
                                    <textarea name='mensaje_inicial' cols="50" rows="5" required></textarea>
                                    <br><br>


                                    <br>  
                                    <div class="text-center" >
                                        <input  class="btn btn-success btn-rounded" type='submit' name='Alta' value='Guardar'/>
                                    </div>
                                </form>
                            </div>    
                            <?php
                            if(isset($_REQUEST['Alta'])){

                                $cliente_id_ticket = $_REQUEST['cliente_id_ticket'];
                                $fecha_alta_ticket = $_REQUEST['fecha_alta_ticket'];
                                $ot_ticket = $_REQUEST['ot_ticket'];
                                $mensaje_inicial = $_REQUEST['mensaje_inicial'];
                                $estatus_ticket = $_REQUEST['estatus_ticket'];


                                require_once('conexion.php');
                                $sql = "INSERT INTO tickets SET
                                cliente_id_ticket = '$cliente_id_ticket',
                                fecha_alta_ticket = '$fecha_alta_ticket',
                                ot_ticket = '$ot_ticket',
                                mensaje_inicial = '$mensaje_inicial',
                                estatus_ticket = '$estatus_ticket'
                                ";
                                $mysqli->query($sql);


                            ?>
                            <script type="text/javascript">
                                alert ('Se ha dado de alta el Ticket. En un máximo de 24 hrs hábiles nos pondremos en contacto');
                                window.location.assign("contacto_panel.php");
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