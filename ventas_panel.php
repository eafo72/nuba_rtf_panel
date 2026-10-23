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
                                <h2 style="font-size:25px;" id="titulopagina">Ventas:</h2>
                                
                                <br><br>
                                <table id="entregable" class="table  table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th><i>Fecha</i></th> 
                                            <th><i>Hora</i></th> 
                                            <th><i>Producto</i></th> 
                                            <th><i>Cantidad</i></th>
                                            <?php
                                            if ($_SESSION['permisos'] == 'Administrador'){
                                                ?>
                                                <th><i>Cliente</i></th> 
                                                <?php
                                            }
                                            ?>
                                            <th><i>Tienda</i></th> 
                                        </tr> 
                                    </thead>     
                                    <tbody>
                                        <?php 
                                        $user = $_SESSION['user_id'];
                                        require_once 'conexion.php'; 
                                        
                                        if ($_SESSION['permisos'] == 'Administrador'){
                                            $consulta = "SELECT * FROM entregable INNER JOIN objetivos ON entregable.entrega_objetivo_id = objetivos.objetivo_id INNER JOIN rol_maestro_misiones ON entregable.entrega_rol_id = rol_maestro_misiones.rol_maestro_id INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id WHERE objetivos.tipo_objetivo = 'Venta' AND entregable.entrega_nombre_elemento = 'Cantidad' ORDER BY entregable.entrega_fecha_cierre, entregable.entrega_hora_cierre  DESC";
                                        }
                                        if ($_SESSION['permisos'] == 'Cliente'){
                                               $consulta = "SELECT * FROM entregable INNER JOIN objetivos ON entregable.entrega_objetivo_id = objetivos.objetivo_id INNER JOIN rol_maestro_misiones ON entregable.entrega_rol_id = rol_maestro_misiones.rol_maestro_id INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id WHERE objetivos.tipo_objetivo = 'Venta' AND entregable.entrega_nombre_elemento = 'Cantidad' AND marcas.mar_cliente_id = '$user' ORDER BY entregable.entrega_fecha_cierre, entregable.entrega_hora_cierre  DESC";
                                        }
                                        

                                        if($resultado = $mysqli->query($consulta)) {
                                            while ($obj = $resultado->fetch_object()){
                                        ?>
                                        <tr>
                                            <td style="max-width:30px;overflow:auto;"><h6>
                                                <?php 
                                                echo $obj->entrega_fecha_cierre;
                                                ?></h6>
                                            </td>
                                            <td style="max-width:30px;overflow:auto;"><h6>
                                                <?php 
                                                echo $obj->entrega_hora_cierre;
                                                ?></h6>
                                            </td>
                                            <td style="max-width:30px;overflow:auto;"><h6>
                                                <?php 
                                                echo $obj->nombre_objetivo;
                                                ?></h6>
                                            </td>
                                            <td style="max-width:30px;overflow:auto;"><h6>
                                                <?php 
                                                echo $obj->entrega_tipo_numero;
                                                ?></h6>
                                            </td>
                                            
                                            <?php
                                            if ($_SESSION['permisos'] == 'Administrador'){
                                                ?>
                                            <td style="max-width:30px;overflow:auto;">
                                                <h6>
                                                    <?php 
                                                $sql="SELECT * FROM clientes WHERE cli_usuario_id = '$obj->mar_cliente_id;'";
                                                if ($resql = $mysqli->query($sql)){
                                                    $obsql = $resql->fetch_object();
                                                    $nombre_empresa = $obsql->nombre_empresa;
                                                    $resql->close();
                                                }
                                                echo $nombre_empresa;
                                                    ?>
                                                </h6>
                                            </td>
                                            <?php
                                            }
                                            ?>
                                            
                                            <td style="max-width:30px;overflow:auto;">
                                                <h6>
                                                    <?php 
                                                $sql="SELECT * FROM tienda WHERE tienda_id = '$obj->rol_id_tienda;'";
                                                if ($resql = $mysqli->query($sql)){
                                                    $obsql = $resql->fetch_object();
                                                    $nombre_tienda = $obsql->nombre_tienda;
                                                    $resql->close();
                                                }
                                                echo $nombre_tienda;
                                                    ?>
                                                </h6>
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
                var table = $('#entregable').DataTable({
                "responsive": false,
                "stateSave": true,
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "order": [[0, "asc"]],
            });
            } );
        </script> 
    </body>
</html>