<?php include ('pass.php');
require_once 'conexion.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php include ('cabecera_panel.php'); ?>

<body class="sb-nav-fixed">
    <?php include ('preloader.php'); ?>
    <?php include ('header.php'); ?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include ('menu_panel.php'); ?>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">

                            <h4>Viáticos:</h4>
                            <ol class="breadcrumb mb-4">
                                <li class="breadcrumb-item"><a href="admin.php">Inicio </a></li>
                                <li class="breadcrumb-item active">Viáticos</li>
                            </ol>

                           
                            <br>

                            <div class="card mb-4">
                                <div class="card-header"><i class="fas fa-table mr-1"></i>Viáticos</div>
                                <div class="card-body">

                                    <div class="table-responsive" id="colaboradores-container">
                                        <table id="viaticos"
                                            class="records_list table  table-bordered dt-responsive nowrap"
                                            cellspacing="0" width="100%">

                                            <thead>
                                                <tr>
                                                    <th>Id OT</th>
                                                    <th>Depositos</th>
                                                    <th>Total a Comprobar</th>
                                                    <th>Total Comprobado</th>
                                                    <th>Diferencia</th>
                                                    <th>Opciones</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php

                                                if($_SESSION['permisos'] == 'Administrador'){
                                                    $consulta = "SELECT * FROM rol_maestro_misiones INNER JOIN colaboradores ON rol_maestro_misiones.colaborador_id_asignado_rol = colaboradores.col_usuario_id GROUP BY rol_id_orden_trabajo ORDER BY rol_id_orden_trabajo DESC";
                                                }else{
                                                    $id_cliente = $_SESSION['user_id'];
                                                    $consulta = "SELECT * FROM rol_maestro_misiones INNER JOIN colaboradores ON rol_maestro_misiones.colaborador_id_asignado_rol = colaboradores.col_usuario_id INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id  WHERE marcas.id_usuario = $id_cliente GROUP BY rol_id_orden_trabajo ORDER BY rol_id_orden_trabajo DESC";
                                                }    

                                                if ($resultado = $mysqli->query($consulta)) {
                                                    while ($obj = $resultado->fetch_object()) {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <h6>
                                                                    <?php
                                                                    echo "$obj->rol_id_orden_trabajo"; ?>
                                                                </h6>
                                                            </td>
                                                            
                                                            <td>
                                                                <?php
                                                                $sql = "SELECT * FROM viaticos_detalle WHERE id_ot = '$obj->rol_id_orden_trabajo' ORDER BY fecha_deposito";
                                                                $total = 0;
                                                                if ($resql = $mysqli->query($sql)) {
                                                                    while ($obsql = $resql->fetch_object()) {
                                                                        ?>
                                                                        <h6><a href='' data-toggle='modal'
                                                                                data-target='#detalles<?php echo $obsql->id_viatico_detalle; ?>'
                                                                                data-toggle='tooltip' data-placement='top'
                                                                                title='Ver Detalles'><?php echo $obsql->fecha_deposito . ' - $ <b>' . $obsql->importe . '  ' . $obsql->motivo . '</b>';
                                                                                $total = $total + $obsql->importe;
                                                                                ?></a>
                                                                        </h6>
                                                                        <!-- modal ver detalles -->
                                                                        <div class="modal fade"
                                                                            id="detalles<?php echo $obsql->id_viatico_detalle; ?>"
                                                                            tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                                                            style="z-index:99999;">
                                                                            <div class="modal-dialog" role="document"
                                                                                style="width:70% !important;">
                                                                                <div class="modal-content" style="">
                                                                                    <div class="modal-header">
                                                                                        <h4 class="modal-title" id="myModalLabel"
                                                                                            style="color:black;">Detalles:</h4>
                                                                                        <button type="button" class="close"
                                                                                            data-dismiss="modal"
                                                                                            aria-label="Close"><span
                                                                                                aria-hidden="true">Cerrar</span></button>
                                                                                    </div>
                                                                                    <div class="modal-body ">
                                                                                        <div align="center">

                                                                                            <h4>Fecha de deposito :
                                                                                                <?php echo $obsql->fecha_deposito; ?>
                                                                                            </h4>
                                                                                            <h4>Importe :
                                                                                                $<?php echo $obsql->importe; ?>
                                                                                            </h4>
                                                                                            <h4>Motivo :
                                                                                                <?php echo $obsql->motivo; ?>
                                                                                            </h4>

                                                                                        </div>
                                                                                        <br>
                                                                                        <div align="center" style="display:in-line">
                                                                                            <a class="btn btn-success btn-rounded"
                                                                                                data-dismiss="modal" href=''
                                                                                                data-toggle='modal'
                                                                                                data-target='#editar<?php echo $obsql->id_viatico_detalle; ?>'>Editar</a>

                                                                                            <a class="btn btn-success btn-rounded"
                                                                                                data-dismiss="modal" href=''
                                                                                                data-toggle='modal'
                                                                                                data-target='#borrar<?php echo $obsql->id_viatico_detalle; ?>'>Borrar</a>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-default"
                                                                                            data-dismiss="modal">Cerrar</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- fin modal ver detalles -->

                                                                        <!-- modal borrar -->
                                                                        <div class="modal fade"
                                                                            id="borrar<?php echo $obsql->id_viatico_detalle; ?>"
                                                                            tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                                                            style="z-index:99999;">
                                                                            <div class="modal-dialog" role="document"
                                                                                style="width:70% !important;">
                                                                                <div class="modal-content" style="">
                                                                                    <div class="modal-header">
                                                                                        <h4 class="modal-title" id="myModalLabel"
                                                                                            style="color:black;">Borrar:</h4>
                                                                                        <button type="button" class="close"
                                                                                            data-dismiss="modal"
                                                                                            aria-label="Close"><span
                                                                                                aria-hidden="true">Cerrar</span></button>
                                                                                    </div>
                                                                                    <div class="modal-body ">
                                                                                        <form method="post"
                                                                                            enctype="multipart/form-data"
                                                                                            action="<?php $_SERVER['PHP_SELF']; ?>">
                                                                                            <div align="center">

                                                                                                <h4>Confirma borrar el deposito de : <br>$
                                                                                                    <?php echo $obsql->importe; ?>
                                                                                                </h4>
                                                                                                <br><br>
                                                                                                <input
                                                                                                    class="btn btn-success btn-rounded"
                                                                                                    type="submit"
                                                                                                    name="btn_borrar<?php echo $obsql->id_viatico_detalle; ?>"
                                                                                                    value="Confirmar" />
                                                                                                <br><br>

                                                                                            </div>
                                                                                        </form>
                                                                                        <?php
                                                                                        if (isset($_REQUEST["btn_borrar" . $obsql->id_viatico_detalle])) {
                                                                                            require_once ("conexion.php");
                                                                                            $borro = "DELETE FROM viaticos_detalle  WHERE id_viatico_detalle = '$obsql->id_viatico_detalle'";
                                                                                            $mysqli->query($borro);
                                                                                            ?>
                                                                                            <script type="text/javascript">
                                                                                                alert('Se ha borrado el deposito');
                                                                                                window.location.assign("viaticos_panel.php");
                                                                                            </script>
                                                                                            <?php
                                                                                        }
                                                                                        ?>

                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-default"
                                                                                            data-dismiss="modal">Cerrar</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- fin modal borrar -->
                                                                        <!-- modal editar -->
                                                                        <div class="modal fade"
                                                                            id="editar<?php echo $obsql->id_viatico_detalle; ?>"
                                                                            tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                                                            style="z-index:99999;">
                                                                            <div class="modal-dialog" role="document"
                                                                                style="width:70% !important;">
                                                                                <div class="modal-content" style="">
                                                                                    <div class="modal-header">
                                                                                        <h4 class="modal-title" id="myModalLabel"
                                                                                            style="color:black;">Editar:</h4>
                                                                                        <button type="button" class="close"
                                                                                            data-dismiss="modal"
                                                                                            aria-label="Close"><span
                                                                                                aria-hidden="true">Cerrar</span></button>
                                                                                    </div>
                                                                                    <div class="modal-body ">
                                                                                        <form method="post"
                                                                                            enctype="multipart/form-data"
                                                                                            action="<?php $_SERVER['PHP_SELF']; ?>">
                                                                                            <div align="center">
                                                                                                <h4>Fecha del deposito : <input
                                                                                                        type="date"
                                                                                                        name="fecha_deposito"
                                                                                                        value="<?php echo $obsql->fecha_deposito; ?>">
                                                                                                </h4>

                                                                                                <h4>Importe : <input type="number"
                                                                                                        name="importe"
                                                                                                        value="<?php echo $obsql->importe; ?>">
                                                                                                </h4>

                                                                                                <h4>Motivo :</h4>
                                                                                                <textarea name="motivo" cols="40"
                                                                                                    rows="4"><?php echo $obsql->motivo; ?></textarea>

                                                                                                <br><br>
                                                                                                <input
                                                                                                    class="btn btn-success btn-rounded"
                                                                                                    type="submit"
                                                                                                    name="btn_editar<?php echo $obsql->id_viatico_detalle; ?>"
                                                                                                    value="Registrar" />
                                                                                                <br><br>

                                                                                            </div>
                                                                                        </form>
                                                                                        <?php
                                                                                        if (isset($_REQUEST["btn_editar" . $obsql->id_viatico_detalle])) {
                                                                                            $fecha_deposito = $_POST['fecha_deposito'];
                                                                                            $importe = $_POST['importe'];
                                                                                            $motivo = $_POST['motivo'];

                                                                                           
                                                                                            $sql = "UPDATE viaticos_detalle SET
                                            fecha_deposito = '$fecha_deposito',
                                            importe = '$importe',
                                            motivo = '$motivo'
                                            WHERE id_viatico_detalle = '$obsql->id_viatico_detalle'";
                                                                                            $mysqli->query($sql);
                                                                                            ?>
                                                                                            <script type="text/javascript">
                                                                                                window.location.assign("viaticos_panel.php");
                                                                                            </script>
                                                                                            <?php
                                                                                        }
                                                                                        ?>

                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-default"
                                                                                            data-dismiss="modal">Cerrar</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- fin modal editar -->
                                                                       
                                                                     
                                                                        <?php
                                                                    }
                                                                    $resql->close();
                                                                }
                                                                ?>
                                                            </td>
                                                            <td style="max-width:30px;overflow:auto;">
                                                                <h6>
                                                                    <?php
                                                                    echo "$".$total; ?>
                                                                </h6>
                                                            </td>
                                                            
                                                            <td>
                                                                <h6>
                                                                    <?php

$sql = "SELECT SUM(importe) as total FROM viaticos_comprobantes WHERE id_ot = '$obj->rol_id_orden_trabajo' AND status = 'Aceptado'";
if ($resql = $mysqli->query($sql)) {
	$obsql = $resql->fetch_object();
	$total_comprobantes = $obsql->total;
	$resql->close();
}
if($total_comprobantes == null){
	$total_comprobantes = 0;
}
                                                                    echo "$".$total_comprobantes; 
                                                                    ?>
                                                                </h6>
                                                            </td>
                                                            <td>
                                                                <h6>
                                                                    <?php
                                                                    echo "$".($total - $total_comprobantes); ?>
                                                                </h6>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                $id = ($obj->rol_id_orden_trabajo);
                                                                ?>

                                                               
                                                                <?php
                                                               // echo "<a href='viaticos_subir_comp.php?id=$id' style='width:20px;'  aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Subir Comprobante'><i class='fa fa-upload'></i></a>";
                                                                ?>

                                                                <?php
                                                                echo "<a href='viaticos_alta_deposito.php?id=$id' style='width:20px;'  aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Alta de Deposito'><i class='fa fa-money-bill'></i></a>";
                                                                ?>

                                                            </td>
                                                        </tr>
                                                    <?php }
                                                    $resultado->close();
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <br>
                            </div>
                            <!-- fin contenido -->
                        </div>

                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            /*
            $('#colaboradores tfoot th').each( function () {
                var title = $(this).text();
                $(this).html( '<input type="text" placeholder="Filtrar.." />' );
            } );
            */
            var table = $('#viaticos').DataTable({
                "responsive": false,
                "stateSave": true,
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                }
            });
        });
    </script>
    <script>
        function upsection() {
            window.location.assign("viaticos_alta.php");
        }
    </script>
</body>

</html>