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
                            <div align="center" class="col-12" >

                                <h2 style="font-size:25px;" >Estados de Cuenta:</h2>
                            
                                
                                  
                                <br><br>
                                <table id="estados" class="table  table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th><i>Cliente</i></th>    
                                            <th><i>Paquete</i></th>
                                            <th><i>Fecha Inicio</i></th>
                                            <th><i>Fecha Fin</i></th>
                                            <th><i>Status</i></th>               
                                        </tr> 
                                    </thead>     
                                    <tbody>
                                        <?php 
                                        require_once 'conexion.php'; 
                                        $consulta = "SELECT * FROM clientes_paquetes_actuales INNER JOIN usuarios ON clientes_paquetes_actuales.id_cliente = usuarios.usuario_id INNER JOIN paquetes ON clientes_paquetes_actuales.id_paquete = paquetes.id_paquete ORDER BY usuarios.nombre_completo ASC"; 
                                        if($resultado = $mysqli->query($consulta)) {
                                            while ($obj = $resultado->fetch_object()){
                                        ?>
                                        <tr >
                                            <td style="max-width:30px;overflow:auto;"><h6>
                                                <?php 
                                                echo "$obj->nombre_completo";?></h6>
                                            </td>
                                            <td style="max-width:30px;overflow:auto;">
                                                <h6>
                                                    <?php 
                                                echo "$obj->nombre";?></h6>
                                            </td>                    
                                            <td style="max-width:30px;overflow:auto;">
                                                <h6>
                                                    <?php 
                                                echo "$obj->fecha_inicio";?></h6>
                                            </td>                    
                                            <td style="max-width:30px;overflow:auto;">
                                                <h6>
                                                    <?php 
                                                echo "$obj->fecha_final";?></h6>
                                            </td>                    
                                            <td style="max-width:30px;overflow:auto;">
                                                <h6>
                                                    <?php 
                                                echo "$obj->status";?></h6>
                                            </td>  
                                            
                                        </tr>     
                                        <?php } 
                                            $resultado->close();
                                        }?>               
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
                var table = $('#estados').DataTable({
                "responsive": false,
                "stateSave": true,
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "order": [[0, "asc"]],
            });
            });
        </script> 
        <script>
            $(document).ready(function(){
                $('[data-toggle="tooltip"]').tooltip(); 
            });
        </script>    
    </body>
</html>