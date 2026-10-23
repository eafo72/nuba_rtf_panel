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
                                <br>
                                <?php
                                require_once("conexion.php");
                                $id=$_GET['id'];
                                $consulta = "SELECT * FROM tienda WHERE tienda_id = $id";
                                $resultado = $mysqli->query($consulta);
                                $obj = $resultado->fetch_object();
                                $nombre_tienda = $obj->nombre_tienda;
                                $resultado->close();
                                ?>
                                <h2 style="font-size:25px;" id="titulopagina">Relaciones entre objetivos y cliente: <?php echo $nombre_tienda;?></h2>
                                <br>
                                <button onclick="upsection();" class="btn btn-success btn-rounded" ><i class="fa fa-plus-circle m-r-5"></i> Alta</button>
                                <br><br>
                                <table id="tiendas" class="table  table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th><i>Id</i></th>    
                                            <th><i>Objetivo</i></th>  
                                            <th><i>Opciones</i></th>               
                                        </tr> 
                                    </thead>     
                                    <tbody>
                                        <?php 
                                        require_once 'conexion.php'; 
                                        $consulta = "SELECT * FROM relacion_o_t WHERE relacion_ot_tienda_id = '$id'"; 
                                        if($resultado = $mysqli->query($consulta)) {
                                            while ($obj = $resultado->fetch_object()){
                                        ?>
                                        <tr>
                                            <td style="max-width:30px;overflow:auto;"><h6>
                                                <?php 
                                                echo $obj->relacion_ot_id;
                                                ?></h6>
                                            </td>
                                            <td style="max-width:30px;overflow:auto;"><h6>
                                                <?php 
                                                $sql="SELECT * FROM objetivos WHERE objetivo_id = '$obj->relacion_ot_objetivo_id'";
                                                if ($resql = $mysqli->query($sql)){
                                                    $obsql = $resql->fetch_object();
                                                    $nombre_objetivo = $obsql->nombre_objetivo;
                                                    $resql->close();
                                                }
                                                echo $nombre_objetivo;
                                                ?>
                                                </h6>
                                            </td>
                                            
                                            <td>
                                                <?php
                                                echo "<a href='tiendas_relacionar_obj_borrar.php?id=$obj->relacion_ot_id' style='width:20px;'  aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Borrar'><i class='fa fa-eraser'></i></a>";
                                                ?>
                                            </td>
                                        </tr>     
                                        <?php 
                                            } 
                                            $resultado->close();
                                        }
                                        ?>               
                                    </tbody>
                                </table>    
                                <div align="center">
                                    <a href="tiendas_panel.php" class="btn btn-success btn-rounded">Regresar a clientes</a>
                                </div>
                            </div>  

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
            $(document).ready(function() {
                var table = $('#tiendas').DataTable({
                "responsive": false,
                "stateSave": true,
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "order": [[0, "asc"]],
            });
            } );
        </script> 
        <script>
            function upsection(){ 
                var js = "<?php echo $id; ?>";
                window.location.assign("tiendas_relacionar_obj_alta.php?id="+js); 
            }
        </script>   
    </body>
</html>