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
						<h4>Consultar Visita a ubicación</h4>
						<ol class="breadcrumb mb-4">
							<li class="breadcrumb-item"><a href="admin.php">Inicio </a></li>
							<li class="breadcrumb-item"><a href="consultar.php">Consultar</a></li>
							<li class="breadcrumb-item active">Ubicación</li>
						</ol>
						<div class="row">
								


							<div class="col-12">

								<?php

								if ($_SESSION['permisos'] == "Cliente"){   
									$id_user = $_SESSION['user_id'];
									$id_tienda = $_GET['tid'];
									$id_ot = $_GET['id_ot'];   

									$consulta = "SELECT * FROM rol_maestro_misiones INNER JOIN relacion_m_t_c ON rol_maestro_misiones.rol_marca_id = relacion_m_t_c.relacion_mtc_marca_id INNER JOIN marcas on rol_maestro_misiones.rol_marca_id = marcas.marca_id INNER JOIN tienda ON relacion_m_t_c.relacion_mtc_tienda_id WHERE rol_id_orden_trabajo = '$id_ot' AND relacion_mtc_tienda_id = '$id_tienda' AND tienda_id = '$id_tienda' AND id_usuario = '$id_user'";
									if ($resql = $mysqli->query($consulta)){
										$obsql = $resql->fetch_object();
										$tienda = $obsql->nombre_tienda; 
										$fecha_programada = $obsql->fecha_programada_visita_rol;
										$fechasubida = date('Y-m-d', strtotime($obsql->fechayhorasubida));
										$horasubida = date('H:i:s', strtotime($obsql->fechayhorasubida));
										$id_colaborador  = $obsql->colaborador_id_asignado_rol; 
										$resql->close();
									}   

								} 

								?>               

								<br>
								<div class="card mb-4">
									<div class="card-header"><i class="fas fa-table mr-1"></i><?php if ($_SESSION['permisos'] == "Cliente"){ echo "Clientes Trabajados en ubicación: ".$tienda." con Fecha Programada: ".$fecha_programada." y Fecha Entrega: ".$fechasubida;}?>  </div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table " id="dataTable" width="100%" cellspacing="0">
												<thead>
													<tr>
														<th>OT</th> 
														<th>Cliente</th>
														<th>Ver</th>               
													</tr> 
												</thead>
												
												<tbody>
													<?php
										$id_ot = $_GET['id_ot'];    
										require_once 'conexion.php'; 

										if ($_SESSION['permisos'] == "Administrador"){
											$consulta = "SELECT * FROM rol_maestro_misiones  WHERE rol_id_orden_trabajo = '$id_ot'";    
										} 

										if ($_SESSION['permisos'] == "Cliente"){   
											$id_user = $_SESSION['user_id'];

											$consulta = "SELECT * FROM rol_maestro_misiones INNER JOIN relacion_m_t_c ON rol_maestro_misiones.rol_marca_id = relacion_m_t_c.relacion_mtc_marca_id INNER JOIN marcas on rol_maestro_misiones.rol_marca_id = marcas.marca_id INNER JOIN tienda ON relacion_m_t_c.relacion_mtc_tienda_id WHERE rol_id_orden_trabajo = '$id_ot' AND relacion_mtc_tienda_id = '$id_tienda' AND tienda_id = '$id_tienda' AND id_usuario = '$id_user'";
										} 


										if($resultado = $mysqli->query($consulta)) {
											while ($obj = $resultado->fetch_object()){
													?>
													<tr>

														<td style="max-width:30px;overflow:auto;">
															<?php 
												echo $obj->rol_id_orden_trabajo;
															?>
														</td>
														<td style="max-width:30px;overflow:auto;">
															<?php
                                                            $sql = "SELECT * FROM tienda WHERE tienda_id = '$obj->rol_id_tienda'";
                                                            if ($resql = $mysqli->query($sql)){
                                                                $obsql = $resql->fetch_object();
                                                                echo $obsql->nombre_tienda;
                                                                $resql->close();
                                                            }
                                                            ?>

														</td>
														<td>
															<?php
												//echo "<a href='misiones_borrar.php?id=$obj->mision_id' style='width:20px;' class='fa fa-eraser' aria-hidden='true' data-toggle='tooltip' data-placement='top' title='Borrar'></a>";
															?>
															<?php
															if ($obj->fechayhorasubida != '0000-00-00 00:00:00') {
																echo "<a href='consultar_tienda_info.php?id=$obj->rol_maestro_id&ot=$obj->rol_id_orden_trabajo&tid=$id_tienda' style='width:20px;'>Ver</a>";
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

											<div align="center">
												<a class="btn btn-success" href="colaboradores_ubicacion.php?id_colaborador=<?php echo $id_colaborador;?>">Ubicación en tiempo real</a>
									        </div>


<br><br>
<h4>Viáticos</h4>
<?php

$sql = "SELECT SUM(importe) as total FROM viaticos_detalle WHERE id_ot = '$id_ot'";
if ($resql = $mysqli->query($sql)) {
	$obsql = $resql->fetch_object();
	$total_depositos = $obsql->total;
	$resql->close();
}
if($total_depositos == null){
	$total_depositos = 0;
}


$sql = "SELECT SUM(importe) as total FROM viaticos_comprobantes WHERE id_ot = '$id_ot' AND status = 'Aceptado'";
if ($resql = $mysqli->query($sql)) {
	$obsql = $resql->fetch_object();
	$total_comprobantes = $obsql->total;
	$resql->close();
}
if($total_comprobantes == null){
	$total_comprobantes = 0;
}
?>
<h6>Total depósitos: $ <?php echo $total_depositos;?></h6>
<h6>Total comprobado: $ <?php echo $total_comprobantes;?></h6>
<h6>Por comprobar: $ <?php echo ($total_depositos - $total_comprobantes);?></h6>

<!--
<a class="btn btn-success" href='viaticos_alta_deposito.php?id=$id'>Alta de Deposito</a>
									-->

									<div class="table-responsive" id="colaboradores-container">
                                        <table id="viaticos"
                                            class="records_list table  table-bordered dt-responsive nowrap"
                                            cellspacing="0" width="100%">

                                            <thead>
                                                <tr>
                                                    
                                                    <th>Fecha</th>
                                                    <th>Concepto</th>
                                                    <th>Importe</th>
													<th>Comprobante</th>
                                                    <th>Status</th>
                                                    <th>Opciones</th>
                                                    
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php
                                                $consulta = "SELECT * FROM viaticos_comprobantes WHERE id_ot = '$id_ot' ORDER BY  fecha DESC";
                                                if ($resultado = $mysqli->query($consulta)) {
                                                    while ($obj = $resultado->fetch_object()) {
                                                        ?>
                                                        <tr>
                                                           
                                                            <td>
                                                             <?php 
															 echo $obj->fecha;
															 ?>   
                                                            </td>

															<td>
                                                             <?php 
															 echo $obj->concepto;
															 ?>   
                                                            </td>

															<td>
                                                             <?php 
															 echo $obj->importe;
															 ?>   
                                                            </td>

															<td>
																<a href="assets/comprobantes/<?php echo $obj->archivo;?>" target="_blank">
																	<?php 
															 		echo $obj->archivo;
															 		?>
															    </a>
                                                             
                                                            </td>


															<td>
                                                             <?php 
															 echo $obj->status;
															 ?>   
                                                            </td>
                                                            
															<td>
																<?php
                                                                echo "<a href='viaticos_status_comprobante.php?id=$obj->id_comprobante&id_ot=$id_ot&tid=$id_tienda' class='btn btn-success'>Status</a>";
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



	</body>
</html>
