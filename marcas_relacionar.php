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
                                $consulta = "SELECT * FROM marcas WHERE marca_id = $id";
                                $resultado = $mysqli->query($consulta);
                                $obj = $resultado->fetch_object();
                                $nombre_marca = $obj->nombre_marca;
                                $resultado->close();
                                ?>
                                <h2 style="font-size:25px;" id="titulopagina">Relaciones entre tiendas y el servicio: <?php echo $nombre_marca;?></h2>
                                <button onclick="upsection();" class="btn btn-success btn-rounded" ><i class="fa fa-plus-circle m-r-5"></i>Alta</button>
                                <br><br>
                                <table id="marcas" class="table  table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th><i>Id</i></th>    
                                            <th><i>Cadena</i></th>  
                                            <th><i>Tienda</i></th>  
                                            <th><i>Opciones</i></th>               
                                        </tr> 
                                    </thead>     
                                    <tbody>
                                        <?php 
                                        require_once 'conexion.php'; 
                                        $consulta = "SELECT * FROM relacion_m_t_c WHERE relacion_mtc_marca_id = '$id'"; 
                                        if($resultado = $mysqli->query($consulta)) {
                                            while ($obj = $resultado->fetch_object()){
                                        ?>
                                        <tr>
                                            <td style="max-width:30px;overflow:auto;"><h6>
                                                <?php 
                                                echo $obj->relacion_mtc_id;
                                                ?></h6>
                                            </td>
                                            <td style="max-width:30px;overflow:auto;"><h6>
                                                <?php 
                                                $sql="SELECT * FROM cadena WHERE cadena_id = '$obj->relacion_mtc_cadena_id'";
                                                if ($resql = $mysqli->query($sql)){
                                                    $obsql = $resql->fetch_object();
                                                    $nombre_cadena = $obsql->nombre_cadena;
                                                    $resql->close();
                                                }
                                                echo $nombre_cadena;
                                                ?>
                                                </h6>
                                            </td>
                                            <td style="max-width:30px;overflow:auto;"><h6>
                                                <?php 
                                                $sql="SELECT * FROM tienda WHERE tienda_id = '$obj->relacion_mtc_tienda_id'";
                                                if ($resql = $mysqli->query($sql)){
                                                    $obsql = $resql->fetch_object();
                                                    $nombre_tienda = $obsql->nombre_tienda;
                                                    $resql->close();
                                                }
                                                echo $nombre_tienda;
                                                ?></h6>
                                            </td>
                                            <td>
                                                <?php
                                                echo "<a href='marcas_relacionar_borrar.php?id=$obj->relacion_mtc_id' style='width:20px;'  aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Borrar'><i class='fa fa-eraser'></i></a>";
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
                                    <a href="marcas_panel.php" class="btn btn-success btn-rounded">Regresar a marcas</a>
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
                var table = $('#marcas').DataTable({
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
                window.location.assign("marcas_relacionar_alta.php?id="+js); 
            }
        </script>
    </body>
</html>