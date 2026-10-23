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
                            <form method="post" enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']; ?>" >

                                <div align="center" class="col-12">
                                    <br> 
                                    <h2 style="font-size:25px;">Chat Alta</h2>

                                    <h6><b>Mensaje:</b></h6>     
                                    <textarea name='mensaje' cols="50" rows="5" required></textarea>
                                    <br><br>

                                </div>    
                                <br>  
                                <div class="text-center" >
                                    <input  class="btn btn-success btn-rounded" type='submit' name='Alta' value='Guardar'/>
                                </div>
                            </form>
                            <?php
                            if(isset($_REQUEST['Alta'])){
                                $id_ticket = $_GET['id_ticket'];
                                $id_user = $_SESSION['user_id'];
                                date_default_timezone_set('america/mexico_city');
                                $fecha_alta_ticket = date('Y/m/d');
                                $mensaje = $_REQUEST['mensaje'];

                                require_once('conexion.php');
                                $sql = "INSERT INTO chat SET
                                chat_id_ticket = '$id_ticket',
                                chat_fecha = '$fecha_alta_ticket',
                                chat_usuario = '$id_user',
                                chat_comentario = '$mensaje'
                                ";
                                $mysqli->query($sql);
                            ?>
                            <script type="text/javascript">
                                var js = "<?php echo $id_ticket; ?>";
                                window.location.assign("contacto_chat.php?id_ticket="+js);
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