<?php include('pass.php');
require_once("conexion.php");
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
                                <form method="post" enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']; ?>">

                                    <br>
                                    <h2 style="font-size:25px;">Editar técnico</h2>
                                    <?php
                                    $id=$_GET['id'];
                                    $consulta = "SELECT * FROM colaboradores WHERE colaborador_id = $id";
                                    $resultado = $mysqli->query($consulta);
                                    $obj = $resultado->fetch_object();
                                    $col_usuario_id = $obj->col_usuario_id; 
                                    $nombre_col = $obj->nombre_col;
                                    $apellido_col = $obj->apellido_col;
                                    $direccion = $obj->direccion;
                                    $edad = $obj->edad;
                                    $genero = $obj->genero;
                                    $estudios = $obj->estudios;
                                    $contrato = $obj->contrato;
                                    $foto = $obj->foto;
                                    $id_administrador = $obj->id_administrador;
                                    
                                    $resultado->close();
                                    ?>


                                    
                                    <h6><b>Nombres:</b></h6>     
                                    <input type='text' name='nombre_col' value="<?php echo $nombre_col; ?>">
                                    <br><br>

                                    <h6><b>Apellidos:</b></h6>     
                                    <input type='text' name='apellido_col' value="<?php echo $apellido_col; ?>">
                                    <br><br>

                                    <h6><b>Dirección:</b></h6>     
                                    <input type='text' name='direccion' value="<?php echo $direccion; ?>">
                                    <br><br>


                                    <h6><b>Edad:</b></h6>     
                                    <input type='number' name='edad' value="<?php echo $edad; ?>">
                                    <br><br>

                                    <h6><b>Género:</b></h6>     
                                    <select name="genero">
                                        <option <?php if($genero == 'Hombre') {echo "selected";} ?> >Hombre</option>
                                        <option <?php if($genero == 'Mujer') {echo "selected";} ?> >Mujer</option>
                                    </select>
                                    <br><br>

                                    <h6><b>Estudios:</b></h6>     
                                    <textarea name='estudios' cols="50" rows="5"><?php echo $estudios; ?></textarea>
                                    <br><br>

                                    <h6><b>Contrato:</b></h6>     
                                    <h6>Actual : <?php echo $contrato; ?></h6>
                                    <input type='file' name='contrato'/>
                                    <br><br>

                                    <h6><b>Foto:</b></h6>     
                                    <h6>Actual : <?php echo $foto; ?></h6>
                                    <div align="center">
                                        <img src="assets/images/<?php echo $foto; ?>" class="img-fluid">
                                    </div>
                                    <br>
                                    <input type='file' name='foto'/>

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
                                                    <option value="<?php echo $obsql->id_usuario; ?>" <?php if($id_administrador == $obsql->id_usuario){echo "selected";} ?> ><?php echo $obsql->nombre_marca; ?></option>
                                                    <?php
                                                }
                                                $resql->close();
                                            }
                                            ?>
                                        </select>
                                   
                                    <?php
                                }
                                ?>


                                    <br><br>      
                                    <div class="text-center">
                                        <input  class="btn btn-success btn-rounded" type="submit" name="Editar"   value="Guardar"/>
                                    </div>    
                                    <br>
                                </form>
                            </div>
                            <?php
                            if(isset($_REQUEST['Editar'])){
                                require_once 'conexion.php'; 
                                
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
                                if (empty($file_name)== false){
                                    $file_tmp =$_FILES['contrato']['tmp_name'];
                                    move_uploaded_file($file_tmp,"assets/documentos/".$file_name);
                                    $sql = "UPDATE colaboradores SET contrato = '$file_name' WHERE colaborador_id = '$id'";
                                    $mysqli->query($sql);   
                                }

                                $file_name_2 = $_FILES['foto']['name'];
                                if (empty($file_name_2)== false){
                                    $file_tmp_2 =$_FILES['foto']['tmp_name'];
                                    move_uploaded_file($file_tmp_2,"assets/images/".$file_name_2);
                                    $sql = "UPDATE colaboradores SET foto = '$file_name_2' WHERE colaborador_id = '$id'";
                                    $mysqli->query($sql);   
                                }


                                $sql = "UPDATE colaboradores SET
                                    nombre_col = '$nombre_col',
                                    apellido_col = '$apellido_col',
                                    direccion = '$direccion',
                                    edad = '$edad',
                                    genero = '$genero',
                                    estudios = '$estudios',
                                    id_administrador = $id_administrador
                                    WHERE colaborador_id = '$id'
                                    ";
                                $mysqli->query($sql);    
                            ?>
                            <script type="text/javascript">
                                window.location.assign("colaboradores_panel.php");
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