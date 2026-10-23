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
                                    require_once 'conexion.php'; 
                                    $id = $_GET['id'];
                                    $sql = "SELECT * FROM relacion_e_o WHERE relacion_eo_id = '$id'"; 
                                    if($resql = $mysqli->query($sql)) {
                                        $obsql = $resql->fetch_object();
                                        $id_objetivo = $obsql->relacion_eo_objetivo_id;
                                        $id_elemento = $obsql->relacion_eo_elementos_id;
                                        $resql->close();
                                        //buscar nombre del elemento
                                        $sql_2 = "SELECT * FROM elementos_llegada WHERE elemento_id = '$id_elemento'"; 
                                        if($resql_2 = $mysqli->query($sql_2)) {
                                            $obsql_2 = $resql_2->fetch_object();    
                                            $nombre_elemento = $obsql_2->nombre_elemento;
                                            $resql_2->close();
                                        }
                                    }
                                    ?>
                                    <h2 style="font-size:25px;">Confirma desvincular el elemento : <?php echo $nombre_elemento;?> del objetivo ?</h2>
                                    <br><br> 

                                    <br>      
                                    <div class="text-center">
                                        <input  class="btn btn-success btn-rounded" type="submit" name="Borrar"   value="Desvincular"/>
                                        <input  class="btn btn-success btn-rounded" type="submit" name="Cancelar" value="Cancelar"/>
                                    </div>    
                                    <br>
                                </form>
                            </div>
                            <?php
                            if(isset($_REQUEST['Borrar'])){
                                require_once("conexion.php");
                                $id=$_GET['id'];
                                $borrado = "DELETE FROM relacion_e_o WHERE relacion_eo_id = '$id'";
                                $mysqli->query($borrado);
                            ?>
                            <script type="text/javascript">
                                var js = "<?php echo $id_objetivo; ?>";
                                window.location.assign("objetivo_elementos.php?id="+js);
                            </script>
                            <?php
                            }
                            if(isset($_REQUEST['Cancelar'])){
                            ?>
                            <script type="text/javascript">
                                var js = "<?php echo $id_objetivo; ?>";
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
    </body>
</html>