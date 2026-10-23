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
                                    <?php
                                    require_once("conexion.php");
                                    $id=$_GET['id'];
                                    $consulta = "SELECT * FROM objetivos WHERE objetivo_id = $id";
                                    $resultado = $mysqli->query($consulta);
                                    $obj = $resultado->fetch_object();
                                    $nombre = $obj->nombre_objetivo;
                                    $resultado->close();
                                    ?>
                                    <h2 style="font-size:25px;">Alta de Elemento en el objetivo : <?php echo $nombre;?></h2>


                                    <h6><b>Elemento:</b></h6>     
                                    <select id="item" name = "id_elemento" required>
                                        <option value="" hidden>Seleccione</option>
                                        <?php
                                        require_once('conexion.php');
                                        $sql="SELECT * FROM elementos_llegada ORDER BY nombre_elemento";
                                        if ($resQ = $mysqli->query($sql)){
                                            while ($obQ = $resQ->fetch_object()){
                                        ?>
                                        <option value="<?php echo $obQ->elemento_id;?>"><?php echo $obQ->nombre_elemento;?></option>
                                        <?php
                                            }
                                            $resQ->close();
                                        }
                                        ?>
                                    </select>
                                    <br><br>


                                    <h6><b>Index (Orden de aparición):</b></h6>     
                                    <input type="number" name="orden" required>
                                    <br><br> 

                                    <br>  
                                    <div class="text-center" >
                                        <input  class="btn btn-success btn-rounded" type='submit' name='Alta' value='Guardar'/>
                                    </div>
                                </form>
                            </div> 
                            <?php
                            if(isset($_REQUEST['Alta'])){
                                $id_objetivo=$_GET['id'];
                                $id_elemento=$_REQUEST['id_elemento'];
                                $orden=$_REQUEST['orden'];


                                require_once 'conexion.php'; 
                                $sql = "INSERT INTO relacion_e_o SET
                                    relacion_eo_objetivo_id = '$id_objetivo',
                                    relacion_eo_elementos_id = '$id_elemento',
                                    orden_aparicion = '$orden'
                                    ";
                                $mysqli->query($sql);
                            ?>
                            <script type="text/javascript">
                                var js = "<?php echo $id; ?>";
                                window.location.assign("objetivo_elementos.php?id="+js);
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
            $("#item").select2( {
                placeholder: "Selecciona",
                allowClear: true
            } );
        </script>
    </body>
</html>