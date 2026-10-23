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
                                    $consulta = "SELECT * FROM marcas WHERE marca_id = $id";
                                    $resultado = $mysqli->query($consulta);
                                    $obj = $resultado->fetch_object();
                                    $nombre_marca = $obj->nombre_marca;
                                    $resultado->close();
                                    ?>
                                    <h2 style="font-size:25px;">Relacionar Servicio : <?php echo $nombre_marca; ?></h2>
                                    <br>
                                    <h6><b>Tienda:</b></h6>     
                                    <select id="store" name="combo" required>
                                        <option value="" hidden>Seleccione</option>
                                        <?php
                                        require_once('conexion.php');
                                        $sql = "SELECT * FROM tienda";
                                        if ($resql = $mysqli->query($sql)){
                                            while ($obsql = $resql->fetch_object()){
                                        ?>   
                                        <option value="<?php echo $obsql->tienda_id.'/'.$obsql->cadena_id_tienda; ?>"><?php echo $obsql->nombre_tienda; ?></option>
                                        <?php
                                            }
                                            $resql->close();
                                        }
                                        ?>
                                    </select>
                                    <br><br>


                                    <br>      
                                    <div class="text-center">
                                        <input  class="btn btn-success btn-rounded" type="submit" name="Editar"   value="Guardar"/>
                                    </div>    
                                    <br>
                                </form>
                            </div>  
                            <?php
                            if(isset($_REQUEST['Editar'])){
                                require_once 'conexion.php'; 
                                $combo = explode('/',$_REQUEST['combo']);
                                $relacion_mtc_marca_id = $_GET['id'];
                                $relacion_mtc_tienda_id = $combo[0];
                                $relacion_mtc_cadena_id = $combo[1];

                                $sql = "INSERT INTO relacion_m_t_c SET
                                relacion_mtc_marca_id = '$relacion_mtc_marca_id', 
                                relacion_mtc_cadena_id = '$relacion_mtc_cadena_id',
                                relacion_mtc_tienda_id = '$relacion_mtc_tienda_id'
                                ";
                                $mysqli->query($sql);    
                            ?>
                            <script type="text/javascript">
                                alert('Se ha dado de alta la relación');
                                var js = "<?php echo $id; ?>";
                                window.location.assign("marcas_relacionar.php?id="+js);
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
            $("#store").select2( {
                placeholder: "Selecciona",
                allowClear: true
            } );
        </script>
    </body>
</html>