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
                                    $consulta = "SELECT * FROM relacion_m_t_c WHERE relacion_mtc_id = '$id'";
                                    $resultado = $mysqli->query($consulta);
                                    $obj = $resultado->fetch_object();
                                    $id_marca = $obj->relacion_mtc_marca_id;
                                    //buscamos nombre marca
                                    $sql = "SELECT * FROM marcas WHERE marca_id = '$id_marca'";
                                    if ($resql = $mysqli->query($sql)){
                                        $count = mysqli_num_rows($resql);
                                        if ($count > 0){
                                            $obsql = $resql->fetch_object();    
                                            $nombre_marca = $obsql->nombre_marca;     
                                            $resql->close();
                                        }
                                    }
                                    $id_cadena = $obj->relacion_mtc_cadena_id;
                                    //buscamos nombre cadena
                                    $sql = "SELECT * FROM cadena WHERE cadena_id = '$id_cadena'";
                                    if ($resql = $mysqli->query($sql)){
                                        $count = mysqli_num_rows($resql);
                                        if ($count > 0){
                                            $obsql = $resql->fetch_object();    
                                            $nombre_cadena = $obsql->nombre_cadena;     
                                            $resql->close();
                                        }
                                    }

                                    $id_tienda = $obj->relacion_mtc_tienda_id;  
                                    //buscamos nombre tienda
                                    $sql = "SELECT * FROM tienda WHERE tienda_id = '$id_tienda'";
                                    if ($resql = $mysqli->query($sql)){
                                        $count = mysqli_num_rows($resql);
                                        if ($count > 0){
                                            $obsql = $resql->fetch_object();    
                                            $nombre_tienda = $obsql->nombre_tienda;     
                                            $resql->close();
                                        }
                                    }

                                    $resultado->close();
                                    ?>
                                    <h2 style="font-size:25px;">Confirma borrar la Relación entre : </h2>
                                    <h4 style="font-size:25px;">Servicio :<?php echo $nombre_marca; ?></h4>
                                    <h4 style="font-size:25px;">Cadena :<?php echo $nombre_cadena; ?></h4>
                                    <h4 style="font-size:25px;">Tienda :<?php echo $nombre_tienda; ?></h4>
                                    <br><br> 

                                    <br>      
                                    <div class="text-center">
                                        <input  class="btn btn-success btn-rounded" type="submit" name="Borrar"   value="Borrar"/>
                                        <input  class="btn btn-success btn-rounded" type="submit" name="Cancelar" value="Cancelar"/>
                                    </div>    
                                    <br>
                                </form>
                            </div>
                            <?php
                            if(isset($_REQUEST['Borrar'])){
                                require_once("conexion.php");
                                $id=$_GET['id'];
                                $borrado = "DELETE FROM relacion_m_t_c WHERE relacion_mtc_id = '$id'";
                                $mysqli->query($borrado);
                            ?>
                            <script type="text/javascript">
                                var js = "<?php echo $id_marca; ?>";
                                window.location.assign("marcas_relacionar.php?id="+js);
                            </script>
                            <?php
                            }
                            if(isset($_REQUEST['Cancelar'])){
                            ?>
                            <script type="text/javascript">
                                var js = "<?php echo $id_marca; ?>";
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
    </body>
</html>