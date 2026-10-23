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
                                    <h2 style="font-size:25px;">Alta de Empresa</h2>

                                    <h6><b>Nombre:</b></h6>     
                                    <input type='text' name='nombre_marca' required/>
                                    <br><br>

                                    <?php /*
                                    <h6><b>Ubicación:</b></h6>     
                                    <select id="customer" name="mar_cliente_id" required>
                                        <option value="" hidden>Seleccione</option>
                                        <?php
                                        require_once('conexion.php');
                                        $sql = "SELECT * FROM tienda";
                                        if ($resql = $mysqli->query($sql)){
                                            while ($obsql = $resql->fetch_object()){
                                        ?>   
                                        <option value="<?php echo $obsql->tienda_id; ?>"><?php echo $obsql->nombre_tienda; ?></option>
                                        <?php
                                            }
                                            $resql->close();
                                        }
                                        ?>
                                    </select>
                                    <br><br>
                                    */
                                    ?>


                                    <h6><b>Descripción:</b></h6>     
                                    <textarea name='descripcion_marca' cols="50" rows="5"></textarea>
                                    <br><br>

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
                                        window.location.assign("marcas_alta.php");
                                    </script>     
                                    <?php    
                                }else{

                                    $form_pass = $_POST['password'];
                                    $hash = password_hash($form_pass, PASSWORD_BCRYPT); 
                                    $permisos = 'Cliente';      

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
                                    
                                    

                                    //$mar_cliente_id = $_REQUEST['mar_cliente_id'];
                                    $mar_cliente_id = 0;

                                    $nombre_marca = $_REQUEST['nombre_marca'];
                                    $descripcion_marca = $_REQUEST['descripcion_marca'];
                                    $tipo_marca = '';
                                    $no_marca = '';


                                    require_once('conexion.php');
                                    $sql = "INSERT INTO marcas SET
                                    mar_cliente_id = '$mar_cliente_id',
                                    id_usuario = '$id_usuario',
                                    nombre_marca = '$nombre_marca',
                                    descripcion_marca = '$descripcion_marca',
                                    tipo_marca = '$tipo_marca',
                                    no_marca = '$no_marca'
                                    ";
                                    $mysqli->query($sql);

                                    //buscamos el id q acabamos de dar de alta
                                    $con7 = "SELECT MAX(marca_id) AS id FROM marcas";
                                    $res = $mysqli->query($con7);
                                    $obY = $res->fetch_object();
                                    $id_marca = $obY->id; 
                                    $res->close();


                                    //creamos la relacion 
                                    $sql = "INSERT INTO relacion_m_t_c SET
                                    relacion_mtc_marca_id = '$id_marca', 
                                    relacion_mtc_cadena_id = 1,
                                    relacion_mtc_tienda_id = '$mar_cliente_id'
                                    ";
                                    $mysqli->query($sql);



                                    ?>
                                    <script type="text/javascript">
                                        window.location.assign("marcas_panel.php");
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
            $("#customer").select2( {
                placeholder: "Selecciona",
                allowClear: true
            } );
        </script>
    </body>
</html>