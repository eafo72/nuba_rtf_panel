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

                                <h2 style="font-size:25px;" >Usuarios:</h2>
                            
                                <a class="btn btn-success btn-rounded" href="usuarioalta.php" ><i class="fa fa-plus-circle m-r-5"></i> Alta</a>
                                  
                                <br><br>
                                <table id="usuarios" class="table  table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th><i>Id</i></th>
                                            <th><i>Nombre de Usuario</i></th>    
                                            <th><i>Status</i></th>
                                            <th><i>Permiso</i></th>
                                            <th><i>Opciones</i></th>               
                                        </tr> 
                                    </thead>     
                                    <tbody>
                                        <?php 
                                        require_once 'conexion.php'; 
                                        $consulta = "SELECT * FROM usuarios"; 
                                        if($resultado = $mysqli->query($consulta)) {
                                            while ($obj = $resultado->fetch_object()){
                                        ?>
                                        <tr >
                                            <td style="max-width:30px;overflow:auto;"><h6>
                                                <?php 
                                                echo "$obj->usuario_id";?></h6>
                                            </td>
                                            <td style="max-width:30px;overflow:auto;">
                                                <h6>
                                                    <?php 
                                                echo "$obj->nombre_usuario";?></h6>
                                            </td>                    
                                            <td style="max-width:30px;overflow:auto;">
                                                <h6>
                                                    <?php 
                                                echo "$obj->estado";?></h6>
                                            </td>                    
                                            <td style="max-width:30px;overflow:auto;">
                                                <h6>
                                                    <?php 
                                                echo "$obj->permisos";?></h6>
                                            </td>                    
                                            <td>
                                                <?php
                                                $id = ($obj->usuario_id);
                                                ?>

                                                <?php
                                                if ($obj->usuario_id != 1){
                                                    echo "<a href='usuarioeditar.php?id=$id' style='width:20px;'  aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Editar'><i class='fa fa-edit'></i></a>";
                                                }
                                                ?>

                                                <?php
                                                if ($obj->usuario_id != 1){
                                                    echo "<a href='usuarioborrar.php?id=$id' style='width:20px;'  aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Borrar'><i class='fa fa-eraser'></i></a>";
                                                }
                                                ?>
                                                
                                                <?php
                                                if ($obj->estado == 'Activo' AND $obj->usuario_id != 1){
                                                    echo "<a href='usuariodesactivar.php?id=$id' style='width:20px;color:red;'  aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Desactivar'><i class='fa fa-times'></i></a>";
                                                }
                                                ?>
                                                <?php
                                                if ($obj->estado == 'Inactivo' AND $obj->usuario_id != 1){
                                                    echo "<a href='usuarioactivar.php?id=$id' style='width:20px;color:green;'  aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Activar'><i class='fa fa-check'></i></a>";
                                                }
                                                ?>

                                                <?php
                                                echo "<a href='usuariopassw.php?id=$id' style='width:20px;'  aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Cambiar Password'><i class='fa fa-key'></i></a>";
                                                ?>

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
                var table = $('#usuarios').DataTable({
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