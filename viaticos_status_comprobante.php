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
                                
                                <form method="post" enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']; ?>" >
                                    <div align="center">
                                        <br>
                                        <?php
                                        $id_comprobante = $_GET['id'];
                                        $id_ot = $_GET['id_ot'];
                                        $id_tienda = $_GET['tid'];


                                        $consulta = "SELECT * FROM viaticos_comprobantes WHERE id_comprobante = '$id_comprobante'";
                                        if($resultado = $mysqli->query($consulta)){
                                            $obj = $resultado->fetch_object();
                                            $status = $obj->status;
                                            $resultado->close();
                                        }    
                                        ?>
                                        <h2 align="center" style="font-size:25px;">Edición del status del comprobante:</h2>
                                        <br>
                                        <h4>Status:</h4>
                                        <select name='status'>
                                            <option <?php if($status == "Enviado"){echo("selected");}?> >Enviado</option>
                                            <option <?php if($status == "Aceptado"){echo("selected");}?> >Aceptado</option>
                                            <option <?php if($status == "Rechazado"){echo("selected");}?> >Rechazado</option>
                                        </select>
                                        <br/><br/>
                                    </div>    
                                    <br>
                                    <div class="text-center">
                                        <input class="btn btn-success btn-rounded" type="submit" name="Editar" value="Guardar">
                                    </div>
                                </form>
                            </div>
                            <?php 
                            if(isset($_REQUEST['Editar'])){
                                $newStatus = $_REQUEST['status'];
                                
                                $mysqli->query("UPDATE viaticos_comprobantes SET status = '$newStatus' WHERE id_comprobante = '$id_comprobante'");
                                ?>
                                <script type="text/javascript">
                                    const idot = <?php echo $id_ot;?>;
                                    const tid = <?php echo $id_tienda;?>;
                                    window.location.assign("consultar_tienda.php?id_ot="+idot+"&tid="+tid);
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