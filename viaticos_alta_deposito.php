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
                                        $id=$_GET['id'];
                                        ?>    
                                        <h2 align="center" style="font-size:25px;">Alta de Deposito:</h2>
                                        <h4><i>ID OT: <?php printf($id); ?></i></h4>
                                                                                

                                        <h4>Fecha del deposito: <input type="date" name="fecha_deposito" required></h4>

                                        <h4>Viáticos anteriores:</h4>
                                        <?php 
                                        $consult = "SELECT * FROM viaticos_detalle ORDER BY fecha_deposito DESC"; 
                                        ?>
                                        <select onchange="javascript:actualiza_info(this.value)">
                                            <?php
                                            if($result = $mysqli->query($consult)) {
                                                ?>
                                                <option value="" hidden>Seleccione del historial</option> 
                                                <?php
                                                while ($ivj = $result->fetch_object()){?>
                                                    <option value="<?php echo $ivj->importe.','.$ivj->motivo;?>" >$<?php echo $ivj->importe.' - '.$ivj->motivo;?></option>                                                    <?php 
                                                }
                                            }
                                            ?>
                                        </select>
                                        <br><br>
                                        <?php 
                                        $result->close();
                                        ?> 

                                        <h4>Importe: <input type="number" name="importe" id="importe" required></h4>
                                        <h4>Motivo :</h4>
                                        <textarea name="motivo" cols="40" rows="4" id="motivo" required></textarea>
                                        <br/><br/>
                                    </div>    
                                    <br>
                                    <div class="text-center">
                                        <input class="btn btn-success btn-rounded" type="submit" name="Alta" value="Registrar">
                                    </div>
                                </form>
                            </div>
                            <?php 
                            
                            if(isset($_REQUEST['Alta'])){
                                $fecha_deposito = $_REQUEST['fecha_deposito']; 
                                $importe = $_REQUEST['importe'];
                                $motivo = $_REQUEST['motivo'];

                                
                                $alta = "INSERT INTO viaticos_detalle SET
                                id_ot = '$id',
                                fecha_deposito = '$fecha_deposito',
                                importe = '$importe',
                                motivo = '$motivo'
                                ";
                                $mysqli->query($alta);
                                ?>
                                <script type="text/javascript">
                                    window.location.assign("viaticos_panel.php");
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
            function actualiza_info(val){
                const combo = val.split(",");
                
                document.getElementById('importe').value = combo[0];
                document.getElementById('motivo').value = combo[1];

            }
        </script>
    </body>
</html>