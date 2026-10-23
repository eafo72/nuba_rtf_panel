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
                            $consultaone = "SELECT * FROM marcas WHERE marca_id = $id"; 
                            $result = $mysqli->query($consultaone);
                            $ive = $result->fetch_object();
                            ?>  
                            <div align="center" class="col-12">
                                <form method="post" enctype="multipart/form-data" action="subir_documentos.php" >

                                    <br>
                                    <h2 style="font-size:25px;" id="titulopagina">Subir Archivo de documentación de :</h2>  
                                    <h4><i><?php echo $ive->nombre_marca; ?></i></h4>
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
                                    <input type="hidden" name="id" value="<?php echo $id;?>"/>
                                    <input  class="btn btn-success" type="submit" name="Cambiar" value="Enviar"/><br><br> 
                                    <br/><br/>

                                    <br>
                                </form>
                            </div>
                            <?php
                            $result->close();
                            
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