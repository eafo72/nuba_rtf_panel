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
                                    <h2 style="font-size:25px;">Alta de Objetivo</h2>

                                    <h6><b>Nombre:</b></h6>     
                                    <input type='text' name='nombre' size="20" required/><br><br>
                                    <h6><b>Imagen:</b></h6>     
                                    <input type='file' name='imagen' required/>
                                    
                                    
                                    

                                    <div id="meta" style="display:none;">
                                        <br>
                                        <h6><b>Meta:</b></h6>
                                        <input id="goal" type='number' name='cantidad_meta'>
                                    </div>


                                    <div id="inv" style="display:none;">
                                        <br>
                                        <h6><b>Existencia:</b></h6>
                                        <input id="exist" type='number' name='cantidad_existencia'>
                                    </div>
                                    
                                    
                                    <br><br>
                                    <h6><b>Incluir Firma:</b></h6>
                                    <select name='firma' required>
                                        <option value="" hidden>Seleccione</option>
                                        <option value="Si">Sí</option>
                                        <option>No</option>
                                    </select>
                                    


                                    <br><br> 

                                    <br>  
                                    <div class="text-center" >
                                        <input  class="btn btn-success btn-rounded" type='submit' name='Alta' value='Guardar'/>
                                    </div>
                                </form>
                            </div> 
                            <?php
                            if(isset($_REQUEST['Alta'])){
                                $nombre=$_REQUEST['nombre'];
                                //$tipo =$_REQUEST['tipo'];
                                $tipo = 'Actividad';
                                $firma =$_REQUEST['firma'];
                                
                                
                                if ($tipo == 'Venta'){
                                    $meta =$_REQUEST['cantidad_meta'];
                                }
                                if ($tipo == 'Inventario'){
                                    $meta =$_REQUEST['cantidad_existencia'];
                                }

                                $file_name = $_FILES['imagen']['name'];
                                $file_tmp =$_FILES['imagen']['tmp_name'];
                                move_uploaded_file($file_tmp,"assets/images/".$file_name);

                                require_once 'conexion.php'; 
                                $sql = "SELECT * FROM objetivos WHERE nombre_objetivo = '$nombre'";
                                $resql = $mysqli->query($sql);
                                $count = mysqli_num_rows($resql);
                                if ($count > 0) {
                                    $resql->close();
                            ?>  
                            <script type="text/javascript">    
                                alert ('El Nombre del objetivo ya existe, por favor escoga otro.');
                                window.location.assign("objetivo_panel.php");
                            </script>     
                            <?php    
                                }else{
                                    $sql = "INSERT INTO objetivos SET
                                    nombre_objetivo = '$nombre',
                                    imagen_objetivo = '$file_name',
                                    tipo_objetivo = '$tipo',
                                    meta = '$meta',
                                    firma = '$firma'
                                    ";
                                    $mysqli->query($sql);
                            ?>
                            <script type="text/javascript">
                                window.location.assign("objetivo_panel.php");
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