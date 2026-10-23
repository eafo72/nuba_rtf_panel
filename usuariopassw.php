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
                                <form method="post" enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']; ?>">


                                    <br>
                                    <?php
                                    require_once("conexion.php");
                                    $id=$_GET['id'];
                                    $consulta = "SELECT * FROM usuarios WHERE usuario_id = $id";
                                    $resultado = $mysqli->query($consulta);
                                    $obj = $resultado->fetch_object();
                                    ?>
                                    <h2 style="font-size:25px;">Cambiar password al Usuario : <i><u><?php printf ($obj->nombre_usuario); ?></u></i></h2>
                                    <h4>Password nuevo (8 caracteres max.):</h4>
                                    <input type="password" name="passw" maxlength="8" required>
                                    <h4>Repita el Password (8 caracteres max.):</h4>
                                    <input type="password" name="passw2" maxlength="8" required>
                                    <br><br> 


                                    <br>      
                                    <div class="text-center">
                                        <input  class="btn btn-success btn-rounded" type="submit" name="cambiar"   value="Cambiar"/>
                                    </div>    
                                    <br>

                                </form>
                            </div>
                            <?php
                            $resultado->close();
                            if (isset($_REQUEST['cambiar'])){
                                $id=$_GET['id'];
                                $passw = $_REQUEST['passw'];
                                $passw2 = $_REQUEST['passw2'];
                                if ($passw != $passw2){
                            ?>
                            <script type="text/javascript">
                                var js1 =  "<?php echo $id; ?>" ;
                                alert('Las contraseñas no coinciden, intentelo de nuevo...'); 
                                window.location.assign("usuariopassw.php?id="+js1);
                            </script>
                            <?php            
                                }else{
                                    $password = password_hash($passw, PASSWORD_BCRYPT); // lo encriptamos
                                    // lo guardamos
                                    require_once('conexion.php');
                                    $sql = "UPDATE usuarios SET password = '$password' WHERE usuario_id = '$id'";
                                    $mysqli->query($sql);
                            ?>
                            <script type="text/javascript">
                                alert('Listo, se ha cambiado la contraseña...'); 
                                window.location.assign("usuarios.php");
                            </script>
                            <?php            
                                }
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