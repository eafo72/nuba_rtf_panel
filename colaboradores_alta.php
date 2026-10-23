<?php include('pass.php');
require_once('conexion.php');
?>
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
                                    <h2 style="font-size:25px;">Alta de Técnico</h2>

                                    <h6><b>Nombres:</b></h6>     
                                    <input type='text' name='nombre_col' required/>
                                    <br><br>

                                    <h6><b>Apellidos:</b></h6>     
                                    <input type='text' name='apellido_col' required/>
                                    <br><br>

                                    <h6><b>Dirección:</b></h6>     
                                    <input type='text' name='direccion' required/>
                                    <br><br>


                                    <h6><b>Edad:</b></h6>     
                                    <input type='number' name='edad' required/>
                                    <br><br>

                                    <h6><b>Género:</b></h6>     
                                    <select name="genero" required>
                                        <option value="" hidden>Seleccione</option>
                                        <option>Hombre</option>
                                        <option>Mujer</option>
                                    </select>
                                    <br><br>

                                    <h6><b>Estudios:</b></h6>     
                                    <textarea name='estudios' cols="50" rows="5"></textarea>
                                    <br><br>

                                    <h6><b>Contrato:</b></h6>     
                                    <input type='file' name='contrato'/>
                                    <br><br>

                                    <h6><b>Foto:</b></h6>     
                                    <input type='file' name='foto'/>
                                    <br><br> 

                                    <?php
                                if($_SESSION['permisos'] == 'Administrador'){
                                    ?>
                                    
                                        <h6><b>Cliente:</b></h6>     
                                        <select class="form-control" name="id_administrador" style="width:400px" required>
                                            <option value="" hidden>Seleccione</option>
                                            <?php
                                            $sql = "SELECT * FROM marcas";
                                            if ($resql = $mysqli->query($sql)){
                                                while ($obsql = $resql->fetch_object()){
                                                    ?>
                                                    <option value="<?php echo $obsql->id_usuario; ?>" ><?php echo $obsql->nombre_marca; ?></option>
                                                    <?php
                                                }
                                                $resql->close();
                                            }
                                            ?>
                                        </select>
                                   
                                    <?php
                                }
                                ?>
                                    
                                    <h4>Nombre de Usuario:</h4>
                                    <input type="text" name="username" maxlength="32" autocomplete ="new-password"  spellcheck="false" required>
                                    <br><br>

                                    <h4>Password: (8 caracteres)</h4>
                                    <input type="password" name="password" maxlength="8" autocomplete ="new-password"  spellcheck="false" required>
                                    <br><br>
                                    
                                    

                                    <br>  
                                    <div class="text-center" >
                                        <input  class="btn btn-success btn-rounded" type='submit' name='Alta' value='Guardar'/>
                                    </div>
                                    <br><br>
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
                                        window.location.assign("colaboradores_alta.php");
                                    </script>     
                                    <?php    
                                }else{

                                    //revisamos si tiene espacios disponibles
                                    if($_SESSION['permisos'] == 'Cliente'){
                                        $id_administrador = $_SESSION['user_id'];

                                        //buscamos el numero maximo permitido de colaboradores
                                        $sql="SELECT * FROM clientes_paquetes_actuales INNER JOIN paquetes ON clientes_paquetes_actuales.id_paquete = paquetes.id_paquete WHERE clientes_paquetes_actuales.id_cliente = $id_administrador";
                                        if($res = $mysqli->query($sql)){
                                            $obY = $res->fetch_object();
                                            $numero_max_colaboradores = $obY->colaboradores; 
                                            $res->close();
                                        }  
                                        
                                        //contamos el numero de colaboradores actuales
                                        $sql="SELECT COUNT(*) as total FROM colaboradores WHERE id_administrador = $id_administrador";
                                        if($res = $mysqli->query($sql)){
                                            $obY = $res->fetch_object();
                                            $numero_colaboradores_actuales = $obY->total; 
                                            $res->close();
                                        }  

                                        if(($numero_colaboradores_actuales + 1) > $numero_max_colaboradores){
                                            ?>  
                                            <script type="text/javascript">    
                                                alert ('Lo sentimos has alcanzado el número máximo de colaboradores permitidos en tu paquete.');
                                                window.location.assign("colaboradores_panel.php");
                                            </script>     
                                            <?php  
                                            return;
                                        }

                                    }    
                                
                                    $form_pass = $_POST['password'];
                                    $hash = password_hash($form_pass, PASSWORD_BCRYPT); 
                                    $permisos = 'Colaborador';      

                                    require_once 'conexion.php'; 
                                    $alta = "INSERT INTO usuarios SET 
                                    nombre_usuario = '$user_name',
                                    password = '$hash',
                                    estado = 'Activo',
                                    permisos = '$permisos'
                                    ";
                                    $mysqli->query($alta);
                                    
                                    //buscamos el id q acabamos de dar de alta
                                    $con7 = "SELECT MAX(usuario_id) AS id FROM usuarios";
                                    $res = $mysqli->query($con7);
                                    $obY = $res->fetch_object();
                                    $id_usuario = $obY->id; 
                                    $res->close();
                                

                                    
                                    $nombre_col = $_REQUEST['nombre_col'];
                                    $apellido_col = $_REQUEST['apellido_col'];
                                    $direccion = $_REQUEST['direccion'];
                                    $edad = $_REQUEST['edad'];
                                    $genero = $_REQUEST['genero'];
                                    $estudios = $_REQUEST['estudios'];

                                    if($_SESSION['permisos'] == 'Administrador'){
                                        $id_administrador = $_REQUEST['id_administrador'];
                                    }else{
                                        $id_administrador = $_SESSION['user_id'];
                                    }    


                                    $file_name = $_FILES['contrato']['name'];
                                    $file_tmp =$_FILES['contrato']['tmp_name'];
                                    move_uploaded_file($file_tmp,"assets/documentos/".$file_name);

                                    $file_name_2 = $_FILES['foto']['name'];
                                    $file_tmp_2 =$_FILES['foto']['tmp_name'];
                                    move_uploaded_file($file_tmp_2,"assets/images/".$file_name_2);


                                    
                                    $sql = "INSERT INTO colaboradores SET
                                    col_usuario_id = '$id_usuario',
                                    nombre_col = '$nombre_col',
                                    apellido_col = '$apellido_col',
                                    direccion = '$direccion',
                                    edad = '$edad',
                                    genero = '$genero',
                                    estudios = '$estudios',
                                    contrato = '$file_name',
                                    foto = '$file_name_2',
                                    id_administrador = $id_administrador
                                    ";
                                    $mysqli->query($sql);

                                    ?>
                                    <script type="text/javascript">
                                        window.location.assign("colaboradores_panel.php");
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
        <script>
            $("#user").select2( {
                placeholder: "Selecciona",
                allowClear: true
            } );
        </script>
    </body>
</html>