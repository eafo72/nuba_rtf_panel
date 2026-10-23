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
                                    <h2 align="center" style="font-size:25px;">Alta de Usuario:</h2>
                                    <br>
                                    <h4>Nombre de Usuario:</h4>
                                    <input type="text" name="username" maxlength="32" autocomplete ="new-password"  spellcheck="false" required>
                                    <br><br>

                                    <h4>Password: (8 caracteres)</h4>
                                    <input type="password" name="password" maxlength="8" autocomplete ="new-password"  spellcheck="false" required>
                                    <br><br>

                                    <?php 
                                    require_once 'conexion.php';   
                                    ?>
                                    <h4>Permiso:</h4>
                                    <select name='permisos' required>
                                        <option value="" hidden>Seleccione</option>
                                        <?php
                                        $consult = "SELECT * FROM permisos"; 
                                        $result = $mysqli->query($consult);
                                        if($result = $mysqli->query($consult)) {
                                            while ($ivj = $result->fetch_object()){?>
                                        <option value="<?php printf($ivj->nombre);?>"><?php printf($ivj->nombre);?></option>
                                        <?php 
                                                                                  }
                                            $result->close();
                                        }
                                        ?>
                                    </select>
                                    <br/><br/>

                                    <br>
                                    <div class="text-center">
                                        <input class="btn btn-success btn-rounded" type="submit" name="Alta" value="Guardar">
                                    </div>
                                </form>
                            </div> 
                            <?php 
                            if(isset($_REQUEST['Alta'])){
                                $user_name = $_REQUEST['username'];           
                                require_once 'conexion.php'; 
                                $buscarUsuario = "SELECT * FROM usuarios WHERE nombre_usuario = '$user_name'";
                                $result = $mysqli->query($buscarUsuario);
                                $count = mysqli_num_rows($result);
                                if ($count == 1) {
                            ?>  
                            <script type="text/javascript">    
                                alert ('El Nombre de usuario ya ha sido tomado.Por favor escoga otro Nombre.');
                            </script>     
                            <?php    
                                }else{

                                    $form_pass = $_POST['password'];
                                    $hash = password_hash($form_pass, PASSWORD_BCRYPT); 
                                    $permisos = $_REQUEST['permisos'];      

                                    require_once 'conexion.php'; 
                                    $alta = "INSERT INTO usuarios SET 
                                    nombre_usuario = '$user_name',
                                    password = '$hash',
                                    estado = 'Activo',
                                    permisos = '$permisos'
                                    ";
                                    $mysqli->query($alta);


                                    if($permisos == 'Cliente'){
                                        //buscamos el id q acabamos de dar de alta
                                        $con7 = "SELECT MAX(usuario_id) AS id FROM usuarios";
                                        $res = $mysqli->query($con7);
                                        $obY = $res->fetch_object();
                                        $id_usuario = $obY->id; 
                                        $res->close();

                                        $sql = "INSERT INTO clientes_paquetes_actuales SET
                                        id_cliente = $id_usuario,
                                        status = 'Pausado'";
                                        $mysqli->query($sql);

                                    }


                            ?>
                            <script type="text/javascript">
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