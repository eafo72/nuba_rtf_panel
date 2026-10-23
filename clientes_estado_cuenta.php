<?php include('pass.php');
require_once 'conexion.php';
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
                                <br>
                                <h2 style="font-size:25px;" id="titulopagina">Estado de Cuenta:</h2>
                                <br><br>
                            </div>    

                            <div  class="col-12 col-md-4">
                                <?php
                                $id_administrador = $_SESSION['user_id'];

                                $consulta = "SELECT * FROM clientes_paquetes_actuales INNER JOIN paquetes ON clientes_paquetes_actuales.id_paquete = paquetes.id_paquete  WHERE clientes_paquetes_actuales.id_cliente = $id_administrador"; 
                                if($resultado = $mysqli->query($consulta)) {
                                    $obj = $resultado->fetch_object();

                                    $nombre_paquete = $obj->nombre;
                                    $precio = $obj->precio;
                                    $vigencia =  "del: ".$obj->fecha_inicio." al ".$obj->fecha_final;
                                    $fecha_final = $obj->fecha_final;
                                    $colaboradores = $obj->colaboradores;
                                    $ubicaciones = $obj->ubicaciones;
                                    $status = $obj->status;

                                    $resultado->close();
                                }    
                                ?>
                                
                                <h4 align="center">Paquete Actual:</h4>
                                <br>
                                <div align="left">
                                    <h6>Paquete: <span><?php echo $nombre_paquete;?></span></h6>
                                    <h6>Precio: <span>$ <?php echo $precio;?> MXN</span></h6>
                                    <h6>Vigencia: <span><?php echo $vigencia;?></span></h6>
                                    <h6>Máx.Colaboradores: <span><?php echo $colaboradores;?></span></h6>
                                    <h6>Máx.Ubicaciones: <span><?php echo $ubicaciones;?></span></h6>
                                    <h6>Status: <span><?php echo $status;?></span></h6>
                                   
                                </div>    

                            </div>

                            <div align="center" class="col-12 col-md-8">    
                                <h4>Historial</h4>
                                <br>
                                <div class="table-responsive" id="tiendas-container">  
                                    <table id="tiendas" class="records_list table  table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                        
                                       
                                        <thead>
                                            <tr>
                                                <th><i>Paquete</i></th>    
                                                <th><i>Precio</i></th>    
                                                <th><i>Fecha Inicial</i></th>    
                                                <th><i>Fecha Final</i></th>    
                                            </tr> 
                                        </thead>     
                                        <tbody>
                                            <?php 
                                            $consulta = "SELECT * FROM clientes_paquetes_historial INNER JOIN paquetes ON clientes_paquetes_historial.id_paquete = paquetes.id_paquete  WHERE clientes_paquetes_historial.id_cliente = $id_administrador ORDER BY id DESC"; 
                                            if($resultado = $mysqli->query($consulta)) {
                                                while ($obj = $resultado->fetch_object()){
                                            ?>
                                            <tr>
                                                <td style="max-width:30px;overflow:auto;"><h6>
                                                    <?php 
                                                    echo $obj->nombre;
                                                    ?></h6>
                                                </td>
                                                <td style="max-width:30px;overflow:auto;"><h6>
                                                    <?php 
                                                    echo $obj->precio;
                                                    ?></h6>
                                                </td>
                                                <td style="max-width:30px;overflow:auto;"><h6>
                                                    <?php 
                                                    echo $obj->fecha_inicio;
                                                    ?></h6>
                                                </td>
                                                <td style="max-width:30px;overflow:auto;"><h6>
                                                    <?php 
                                                    echo $obj->fecha_final;
                                                    ?></h6>
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
                

                var table = $('#tiendas').DataTable({
                    
                    "responsive": false,
                    "stateSave": true,
                    "language": {
                        "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                    },
                    
                });
            });
        </script> 
        <script>
            function go_pay(){
                window.location.assign("registrar_pago.php");
            } 
        </script>    
       
    </body>
</html>