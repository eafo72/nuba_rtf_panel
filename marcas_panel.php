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
                                <h2 style="font-size:25px;" id="titulopagina">Empresas:</h2>

                                <button onclick="upsection();" class="btn btn-success btn-rounded" ><i class="fa fa-plus-circle m-r-5"></i> Alta</button>
                                <br><br>

                                <br><br>
                                <div class="table-responsive" id="marcas-container">  
                                    <table id="marcas" class="records_list table  table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                        <!-- Inicio de tabla Admin -->  
                                        <?php 
                                        if ($_SESSION['permisos'] == "Administrador" OR $_SESSION['permisos'] == "Cliente" ){
                                        ?>
                                        <thead>
                                            <tr>
                                                <th><i>Id</i></th>  
                                                <th><i>Id Usuario</i></th>  
                                                <th><i>Nombre</i></th>  
                                                <th><i>Descripcion</i></th> 
                                                <th><i>Documentos</i></th> 
                                                <th><i>Opciones</i></th>               
                                            </tr> 
                                        </thead>     
                                        <tbody>
                                            <?php 
                                            require_once 'conexion.php'; 
                                            $consulta = "SELECT * FROM marcas"; 
                                            if($resultado = $mysqli->query($consulta)) {
                                                while ($obj = $resultado->fetch_object()){
                                            ?>
                                            <tr>
                                                <td style="max-width:30px;overflow:auto;"><h6>
                                                    <?php 
                                                    echo $obj->marca_id;
                                                    ?></h6>
                                                </td>
                                                <td style="max-width:30px;overflow:auto;"><h6>
                                                    <?php 
                                                    echo $obj->id_usuario;
                                                    ?></h6>
                                                </td>

                                                <td style="max-width:30px;overflow:auto;"><h6>
                                                    <?php 
                                                    echo $obj->nombre_marca;
                                                    ?></h6>
                                                </td> 
                                                
                                                <td style="max-width:30px;overflow:auto;"><h6>
                                                    <?php 
                                                    echo $obj->descripcion_marca;
                                                    ?></h6>
                                                </td>
                                                <td style="max-width:30px;overflow:auto;">
                                                    <h6>
                                                        <?php
                                                    if($obj->documentos != ''){
                                                        $subidos = explode(',',$obj->documentos);
                                                        $size = count($subidos);
                                                        $i = 0;
                                                        while ($i < $size){
                                                            echo '<a href="assets/documentos/'.$subidos["$i"].'" target="_blank">'.$subidos["$i"].' <a href="javascript:borrar('.$obj->marca_id.','.$i.')"><i style="margin-left:5px; color:red" class="fa fa-times-circle"></i></a></a>';
                                                            echo "<br>";
                                                            $i++;
                                                        }
                                                    }
                                                        ?>
                                                    </h6>
                                                </td>
                                                <td>

                                                    <?php
                                                    echo "<a href='marcas_editar.php?id=$obj->marca_id' style='width:20px;'  aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Editar'><i class='fa fa-edit'></i></a>";
                                                    ?>

                                                    <?php
                                                    echo "<a href='marcas_borrar.php?id=$obj->marca_id' style='width:20px;'  aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Borrar'><i class='fa fa-eraser'></i></a>";
                                                    ?>



                                                    <?php
                                                    echo "<a href='marcas_relacionar_obj.php?id=$obj->marca_id' style='width:20px;'  aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Relaciones con objetivos'><i class='fa fa-bullseye'></i></a>";
                                                    ?>

                                                    <?php
                                                    echo "<a href='marcas_documentos.php?id=$obj->marca_id' style='width:20px;'  aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Subir documentos'><i class='fa fa-upload'></i></a>";
                                                    ?>

                                                </td>
                                            </tr>     
                                            <?php 
                                                } 
                                                $resultado->close();
                                            }
                                            ?>               

                                            <?php
                                        }
                                            ?>

                                        </tbody>
                                    </table>   
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
        <script type="text/javascript">
            $(document).ready(function() {
                
                var table = $('#marcas').DataTable({
                    "stateSave": true,
                    "language": {
                        "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                    },

                    "order": [[ 0, "asc" ]]

                });
            });
        </script> 
        <script>
            function upsection(){ 
                window.location.assign("marcas_alta.php"); 
            }
        </script>   
        <script>
            function borrar(cliente,posicion){
                $.ajax({
                    type: "POST",
                    url: 'marcas_borrar_documento.php',
                    data:  {id_cliente: cliente, posicion: posicion},
                    success: function(resp){
                       window.location.assign('marcas_panel.php');    
                    }
                });  
            }    
        </script>
    </body>
</html>