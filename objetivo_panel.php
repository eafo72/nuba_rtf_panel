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
                                <h2 style="font-size:25px;" id="titulopagina">Objetivos:</h2>
                                <button onclick="upsection();" class="btn btn-success btn-rounded" ><i class="fa fa-plus-circle m-r-5"></i> Alta</button>
                                <br><br>
                                <table id="objetivos" class="table  table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th><i>Id</i></th>    
                                            <th><i>Nombre</i></th>    
                                            <th><i>Imagen</i></th> 
                                            <th><i>Tipo</i></th>
                                            <th><i>Firma</i></th>
                                            <th><i>Opciones</i></th>               
                                        </tr> 
                                    </thead>     
                                    <tbody>
                                        <?php 
                                        require_once 'conexion.php'; 
                                        $consulta = "SELECT * FROM objetivos"; 
                                        if($resultado = $mysqli->query($consulta)) {
                                            while ($obj = $resultado->fetch_object()){
                                        ?>
                                        <tr>
                                            <td style="max-width:30px;overflow:auto;"><h6>
                                                <?php 
                                                echo $obj->objetivo_id;
                                                ?></h6>
                                            </td>
                                            <td style="max-width:30px;overflow:auto;"><h6>
                                                <?php 
                                                echo $obj->nombre_objetivo;
                                                ?></h6>
                                            </td>
                                            <td style="max-width:30px;overflow:auto;"><h6>
                                                <?php 
                                                echo $obj->imagen_objetivo;
                                                ?></h6>
                                            </td>
                                            <td style="max-width:30px;overflow:auto;"><h6>
                                                <?php 
                                                if($obj->tipo_objetivo == 'Venta'){
                                                    echo $obj->tipo_objetivo.' META : '.$obj->meta;
                                                }
                                                if($obj->tipo_objetivo == 'Inventario'){
                                                    echo $obj->tipo_objetivo.' EXISTENCIA : '.$obj->meta;
                                                }
                                                 
                                                if($obj->tipo_objetivo != 'Venta' && $obj->tipo_objetivo != 'Inventario'){
                                                    echo $obj->tipo_objetivo;
                                                }
                                                ?></h6>
                                            </td>
                                            <td style="max-width:30px;overflow:auto;"><h6>
                                                <?php 
                                                echo $obj->firma;
                                                ?></h6>
                                            </td>
                                            <td>
                                                
                                                <?php
                                                //solo se pueden editar los demas menos incidencias
                                                if ($obj->objetivo_id != 3){
                                                
                                                
                                                    echo "<a href='objetivo_editar.php?id=$obj->objetivo_id' style='width:20px;'  aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Editar'><i class='fa fa-edit'></i></a>";
                                                    ?>
                                                
                                                    <?php
                                                    echo "<a href='objetivo_borrar.php?id=$obj->objetivo_id' style='width:20px;'  aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Borrar'><i class='fa fa-eraser'></i></a>";
                                                    ?>
                                                
                                                    <?php
                                                    echo "<a href='objetivo_elementos.php?id=$obj->objetivo_id' style='width:20px;'  aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Elementos'><i class='fa fa-list'></i></a>";
                                                    
                                                    
                                                }
                                                ?>
                                                
                                                <?php
                                                //vemos si ya tiene elementos programados
                                                $sql="SELECT * FROM relacion_e_o WHERE relacion_eo_objetivo_id = '$obj->objetivo_id'";
                                                $resql = $mysqli->query($sql);
                                                $count = mysqli_num_rows($resql);
                                                if ($count > 0){
                                                    $resql->close();
                                                    echo "<a href='objetivo_ver.php?id=$obj->objetivo_id' style='width:20px;' aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Ver'><i class='fa fa-eye''></i></a>";
                                                }
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
                var table = $('#objetivos').DataTable({
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
                window.location.assign("objetivo_alta.php"); 
            }
        </script>  
    </body>
</html>