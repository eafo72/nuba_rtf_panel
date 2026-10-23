<?php include('pass.php');?>
<?php 
date_default_timezone_set('America/Mexico_City');  
$hoy = date('Y-m-d');
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
                        <h1 class="mt-4">Incidencias de Ubicaciones</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="admin.php">Inicio </a></li>
                            <li class="breadcrumb-item active">Incidencias</li>
                        </ol>
                        <div class="row">
                            <div class="col-12">
                                <form method ="get">
                                    <div class="row">
                                        <div class="col-6">


                                            <div class="form-group"> <!-- Date input -->
                                                <label class="control-label" >Fecha Inicio</label>
                                                <input class="form-control" type="date" name="fecha_inicial" value="<?php if(isset($_GET['fecha_inicial'])){echo $_GET['fecha_inicial']; }else{ echo($hoy);} ?>" />
                                            </div>

                                        </div>   
                                        <div class="col-6">          

                                            <div class="form-group"> <!-- Date input -->
                                                <label class="control-label" >Fecha Final</label>
                                                <input class="form-control" type="date" name="fecha_final" value="<?php if(isset($_GET['fecha_final'])){echo $_GET['fecha_final']; }else{ echo($hoy);} ?>" />
                                            </div>


                                        </div>
                                    </div>
                                    <div class="form-group"> <!-- Submit button -->
                                        <button class="btn btn-info " name="submit" type="submit">Filtrar</button>

                                    </div>
                                </form>
                                <br>
                            </div>

                            <div class="col-12">


                                <br>
                                <div class="col-12 text-center">
                                    <a href="incidencias_excel.php" class="btn btn-info"> Exportar Excel</a>
                                    <br><br>
                                </div>

                                <div class="card mb-4">
                                    <div class="card-header"><i class="fas fa-table mr-1"></i>Incidencias por Ubicación</div>
                                    <div class="card-body">
                                        <div class="col-md-12 text-center">


                                            <table id="incidencias" class="table" style="border: solid 1px black;">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th >Ubicación</th>
                                                        <th >Cliente</th>
                                                        <th >Orden de Trabajo</th>
                                                        <th >Técnico</th>
                                                        <th >Fecha</th>
                                                        <th >Comentario</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $id_user = $_SESSION['user_id'];
                                                    require_once('conexion.php');

                                                    if(isset($_GET['fecha_inicial']) && isset($_GET['fecha_final'])){
                                                        $fecha_inicial = $_GET['fecha_inicial'];
                                                        $fecha_final = $_GET['fecha_final'];   

                                                        $sql = "SELECT * FROM entregable INNER JOIN rol_maestro_misiones ON  entregable.entrega_rol_id =  rol_maestro_misiones.rol_maestro_id INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id WHERE entregable.entrega_objetivo_id = 3 AND marcas.mar_cliente_id = '$id_user' AND 
                                                        rol_maestro_misiones.fecha_programada_visita_rol BETWEEN '$fecha_inicial' AND '$fecha_final' ORDER BY entregable.entrega_fecha_cierre DESC"; 

                                                    }else{
                                                        $sql = "SELECT * FROM entregable INNER JOIN rol_maestro_misiones ON  entregable.entrega_rol_id =  rol_maestro_misiones.rol_maestro_id INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id WHERE entregable.entrega_objetivo_id = 3 AND marcas.mar_cliente_id = '$id_user' AND 
                                                        rol_maestro_misiones.fecha_programada_visita_rol BETWEEN '$hoy' AND '$hoy' ORDER BY entregable.entrega_fecha_cierre DESC"; 
                                                    }





                                                    if ($resql = $mysqli->query($sql)){
                                                        while($obsql= $resql->fetch_object()){
                                                    ?>
                                                    <tr>
                                                        <td><?php
                                                            $sqlX="SELECT * FROM tienda WHERE tienda_id = '$obsql->rol_id_tienda'";
                                                            if ($resX = $mysqli->query($sqlX)){
                                                                $obX = $resX->fetch_object();
                                                                echo $obX->nombre_tienda;     
                                                                $resX->close();
                                                            }    
                                                            ?>
                                                        </td>
                                                        <td><?php echo $obsql->nombre_marca; ?></td>
                                                        <td><?php echo $obsql->rol_id_orden_trabajo; ?></td>

                                                        <td>
                                                            <?php
                                                            $sqlX="SELECT * FROM colaboradores WHERE col_usuario_id = '$obsql->colaborador_id_asignado_rol'";
                                                            if ($resX = $mysqli->query($sqlX)){
                                                                $obX = $resX->fetch_object();
                                                                echo $obX->nombre_col.' '.$obX->apellido_col;   
                                                                $resX->close();
                                                            }    
                                                            ?>
                                                        </td>
                                                        <td><?php echo $obsql->entrega_fecha_cierre; ?></td>
                                                        <td><?php echo $obsql->entrega_tipo_texto; ?></td>
                                                    </tr>    
                                                    <?php
                                                        }
                                                        $resql->close();  
                                                    }      
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        
        
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        
        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
        <script>
            var table = $('#incidencias').DataTable({
                "responsive": false,
                "stateSave": true,
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "order": [[0, "asc"]],
            });
        </script>
    </body>
</html>
