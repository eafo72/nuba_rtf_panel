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
                            <?php 
                            $id=$_GET['id'];
                           ?> 
                            <div align="center" class="col-12">
                                <form method="post" enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']; ?>" >
                                    <div align="center">
                                        <br>
                                        <h2 style="font-size:25px;" >Subir Comprobante de Gastos:</h2>  
                                        <h4><i>ID OT: <?php printf($id); ?></i></h4>
                                        
                                        <!--<h6>Ultimos archivos subidos :</h6>-->
                                        <?php
                                        /*
                                        $subidos = explode(',', $ive->comprobantes);
                                        $size = count($subidos);
                                        $i = 0;
                                        while ($i < $size){
                                            echo $subidos["$i"];
                                            echo "<br>";
                                            $i++;
                                        }
                                        */
                                        ?>
                                        <br><br>
                                        <input class="text-center" type="file" name="image" required /><br><br>

                                        <h6>Concepto:
                                            <input class="text-center" type="text" name="concepto" required />
                                        </h6>

                                        <h6>Fecha:
                                            <input class="text-center" type="date" name="fecha" required />
                                        </h6>

                                        <h6>Importe:
                                            <input class="text-center" type="number" step="any" name="importe" required />
                                        </h6>
                                        <br><br>


                                        <input  class="btn btn-success btn-rounded" type="submit" name="Cambiar" value="Enviar"/><br><br> 
                                        <br/><br/>
                                    </div>    
                                    <br>
                                </form>
                            </div>
                            <?php
                           
                            if(isset($_REQUEST['Cambiar'])){
                                $file_name = $_FILES['image']['name'];
                                $file_tmp =$_FILES['image']['tmp_name'];
                                $filenewname = "id_";
                                $filenewname .= $id;
                                $filenewname .= '_';
                                $filenewname .= strtolower($file_name);

                                $concepto = $_POST['concepto'];
                                $fecha = $_POST['fecha'];
                                $importe = $_POST['importe'];

                                if(file_exists('assets/comprobantes/'.$filenewname)){
                                    $counter = 1;
                                    while(@file_exists('assets/comprobantes/('.$counter.')'.$filenewname)) { $counter++;  }
                                    $filenewname = '('.$counter.')'.$filenewname;
                                }

                                move_uploaded_file($file_tmp,"assets/comprobantes/".$filenewname);
                                
                                $id=$_GET['id'];
                                
                                /*
                                $consulta2 = "SELECT * from viaticos where id_viatico = '$id'";
                                $resultado2 = $mysqli->query($consulta2);
                                $Obj = $resultado2->fetch_object();
                                $acumulado = $Obj->comprobantes.''.$filenewname.','; 
                                */

                                $consulta = "INSERT INTO viaticos_comprobantes SET 
                                id_ot = '$id',
                                archivo = '$filenewname',
                                concepto = '$concepto',
                                fecha = '$fecha',
                                importe = '$importe'
                                ";

                                $mysqli->query($consulta);
                                //$resultado2->close();

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
    </body>
</html>