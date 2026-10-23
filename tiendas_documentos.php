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
                            <?php 
                            $id=$_GET['id'];
                            require_once 'conexion.php';   
                            $consultaone = "SELECT * FROM tienda WHERE tienda_id = $id"; 
                            $result = $mysqli->query($consultaone);
                            $ive = $result->fetch_object();
                            ?>  
                            <div align="center" class="col-12">
                                <form method="post" enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']; ?>" >

                                    <br>
                                    <h2 style="font-size:25px;" id="titulopagina">Subir Archivo de documentación de :</h2>  
                                    <h4><i><?php echo $ive->nombre_tienda; ?></i></h4>
                                    <h6>Ultimos archivos subidos :</h6>
                                    <?php
                                    $subidos = explode(',', $ive->documentos);
                                    $size = count($subidos);
                                    $i = 0;
                                    while ($i < $size){
                                        echo $subidos["$i"];
                                        echo "<br>";
                                        $i++;
                                    }
                                    ?>
                                    <br><br>
                                    <input class="text-center" type="file" name="image" required /><br><br>
                                    <input  class="btn btn-success" type="submit" name="Cambiar" value="Enviar"/><br><br> 
                                    <br/><br/>

                                    <br>
                                </form>
                            </div>
                            <?php
                            $result->close();
                            if(isset($_REQUEST['Cambiar'])){
                                $file_name = $_FILES['image']['name'];
                                $file_tmp =$_FILES['image']['tmp_name'];
                                $filenewname = "id_";
                                $filenewname .= $id;
                                $filenewname .= '_';
                                $filenewname .= strtolower($file_name);

                                if(file_exists('assets/documentos/'.$filenewname)){
                                    $counter = 1;
                                    while(@file_exists('assets/documentos/('.$counter.')'.$filenewname)) { $counter++;  }
                                    $filenewname = '('.$counter.')'.$filenewname;
                                }

                                move_uploaded_file($file_tmp,"assets/documentos/".$filenewname);
                                $id=$_GET['id'];
                                include("conexion.php");
                                $consulta2 = "SELECT * FROM tienda WHERE tienda_id = '$id'";
                                $resultado2 = $mysqli->query($consulta2);
                                $Obj = $resultado2->fetch_object();
                                $acumulado = $Obj->documentos.''.$filenewname.','; 

                                $consulta = "UPDATE tienda SET documentos ='$acumulado' WHERE tienda_id = '$id'";
                                $mysqli->query($consulta);
                                $resultado2->close();

                            ?>
                            <script type="text/javascript">
                                window.location.assign("tiendas_panel.php");
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