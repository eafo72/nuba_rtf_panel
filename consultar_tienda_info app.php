<?php 
$id_tienda = $_GET['tid'];
$id_ot = $_GET['ot'];  
$tid = $_GET['tid'];
?>
<!DOCTYPE html>
<html lang="en">
	<?php include('cabecera_panel.php'); ?>

	<body class="sb-nav-fixed">
		<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            
            	<img src="landing/images/hpmled_logo.jpg" alt="logo" class="img-fluid" style="width:35vw; margin:0 auto">
			
                  
                        
        </nav>		
		<div id="layoutSidenav">
			<div id="layoutSidenav_nav">
				
			</div>


			<div id="layoutSidenav_content">
				<main>
					<div class="container-fluid">
						
						
						<div class="row">
							<div class="col-12 text-center">
								<?php
								$id_rol = $_GET['id'];
								?>
								
							</div>
						</div>	
						<section id="contenido">
							<div class="row">
								<div class="col-12">
									<div class="card mb-4">
										<div class="card-header"><i class="fas fa-table mr-1"></i>Información de la visita</div>
										<div class="card-body">
											<?php
											$ot = $_GET['ot'];
											$id_rol = $_GET['id'];
											require_once 'conexion.php';     
											$consultas = "SELECT * FROM rol_maestro_misiones INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id INNER JOIN tienda on rol_maestro_misiones.rol_id_tienda = tienda.tienda_id INNER JOIN misiones on rol_maestro_misiones.rol_id_orden_trabajo = misiones.mision_id_orden_trabajo INNER JOIN colaboradores on rol_maestro_misiones.colaborador_id_asignado_rol = colaboradores.col_usuario_id WHERE rol_id_orden_trabajo = '$ot' LIMIT 1";
											if($resultados = $mysqli->query($consultas)) {
												while ($objs = $resultados->fetch_object()){ 
													$arranque = strtotime($objs->hora_inicio_mision);
													$final =  strtotime($objs->hora_entrega_mision);
													$efectivo = round(($final - $arranque) / 60, 2);
													$programa = strtotime($objs->hora_programada_visita_rol);
													$arrivo = strtotime($objs->hora_inicio_mision);
													$retraso =  round(($arrivo - $programa) / 60, 2);
													$programada = strtotime($objs->fecha_programada_visita_rol);
													$actividad = strtotime($objs->fecha_inicio_mision);
													$geoinicio = $objs->geo_inicio_mision;
													$geoentrega = $objs->geo_entrega_mision;
													$dif = ($actividad - $programada);
													$combo = explode(',', $geoinicio) ;
													$latitud = $combo[0];
													$longitud = $combo[1];  
													$combo2 = explode(',', $geoentrega) ;
													$latitud2 = $combo2[0];
													$longitud2 = $combo2[1];  

													$combo_horas_pausas = explode("/",$objs->pausas_mision);
													$combo_horas_reinicios = explode("/",$objs->reinicios_mision);
													$combo_prcomentarios =  explode("/",$objs->prcomentarios);

													$SOS_causa = $objs->sos_causa;
													$SOS_comentario = $objs->sos_comentario;
											?> 

											<br>

											<div class="row">        
												<div class="col-6">

													<p><b>Cliente:</b> <?php echo $objs->nombre_tienda; ?></p>
													<p><b>Ot:</b> <?php echo $ot; ?></p>
													<p><b>Ténico Asignado:</b> <?php echo $objs->nombre_col; ?>&nbsp; <?php echo $objs->apellido_col; ?></p>
													<p><b>Tiempo efectivo dentro de la ubicación: </b><?php echo $efectivo; ?>min</p>
													<p><b>Retraso en arrivo: </b><?php if($dif < 0){?>Ninguno<?php }else{echo $retraso."min";}?></p>

													<p><b>Pausas: </b>
													<?php
													for($i=0;$i<count($combo_horas_pausas);$i++){
														if($combo_horas_pausas[$i] != ''){
															echo "<br>".$combo_horas_pausas[$i];
														}
													}
													?>
													<p><b>Comentarios Pausas: </b>
													<?php
													for($i=0;$i<count($combo_prcomentarios);$i++){
														$tipo = substr($combo_prcomentarios[$i],0,2);
														if($tipo == 'P:'){
															$comboP = explode(":",$combo_prcomentarios[$i]);
															echo "<br>".$comboP[1];
														}
													}
													?>
													

													<p><b>Reinicios: </b>
													<?php
													for($i=0;$i<count($combo_horas_reinicios);$i++){
														if($combo_horas_reinicios[$i] != ''){
															echo "<br>".$combo_horas_reinicios[$i];
														}
													}
													?>

													<p><b>Comentarios Reinicios: </b>
													<?php
													for($i=0;$i<count($combo_prcomentarios);$i++){
														$tipo = substr($combo_prcomentarios[$i],0,2);
														if($tipo == 'R:'){
															$comboR = explode(":",$combo_prcomentarios[$i]);
															echo "<br>".$comboR[1];
														}
													}
													?>

													


												</div>    
												<div class="col-6">        
													<p><b>Fecha Programada: </b><?php echo $objs->fecha_programada_visita_rol; ?></p>
													<p><b>Fecha Llegada: </b><?php echo $objs->fecha_inicio_mision; ?></p>  
													<p><b>Fecha Entrega: </b><?php echo $objs->fecha_entrega_mision; ?></p>
													<p><b>Hora Programada: </b><?php echo $objs->hora_programada_visita_rol; ?></p>
													<p><b>Hora Llegada: </b><?php echo $objs->hora_inicio_mision; ?></p>  
													<p><b>Hora Entrega: </b><?php echo $objs->hora_entrega_mision; ?></p>
													<p><b>SOS causa: </b><?php echo $objs->soscausa; ?></p>
													<p><b>SOS comentario: </b><?php echo $objs->soscomentario; ?></p>

													<?php
												}
												$resultados->close();
											}
													?>
												</div> 
											</div>    
										</div>
									</div>
								</div>



								<div class="col-12">

									<div class="card mb-4">
										<div class="card-header"><i class="fas fa-table mr-1"></i>Geolocalización de la visita</div>
										<div class="card-body">

											<br>

											<div class="row">        
												<div class="col-6">
													<h4 style="margin:0;display:inline;">Entrada:</h4> <p style="margin:0;display:inline;" ><?php echo $geoinicio; ?></p>
													<br><br>
													<div id="mapall" class="text-center" style="height:50vh;"></div>


												</div> 
												<div class="col-6">
													<h4 style="margin:0;display:inline;">Salida:</h4> <p style="margin:0;display:inline;" ><?php echo $geoentrega; ?></p>
													<br><br>
													<div id="mapall2" class="text-center" style="height:50vh;"></div>


												</div>  

											</div>    
										</div>
									</div>
								</div>


								<div class="col-12">    

									<br>
									<div class="card mb-4">
										<div class="card-header"><i class="fas fa-table mr-1"></i>Entregables  </div>
										<div class="card-body">

											<table id="tiendas" class="records_list table  table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th><i>Objetivo</i></th>    
														<th><i>Tipo</i></th>    
													</tr> 
												</thead>     
												<tbody>
													<?php 
													$id_rol = $_GET['id'];
													require_once 'conexion.php'; 
													$consultas = "SELECT DISTINCT entrega_objetivo_id FROM entregable WHERE entrega_rol_id = '$id_rol'";
													if($resultados = $mysqli->query($consultas)) {
														while ($objs = $resultados->fetch_object()){   
															$objetivo_id = $objs->entrega_objetivo_id;

															$consulta = "SELECT * FROM entregable INNER JOIN objetivos ON entregable.entrega_objetivo_id = objetivos.objetivo_id WHERE entrega_rol_id = '$id_rol' AND entrega_objetivo_id = '$objetivo_id'";
															if ($resql = $mysqli->query($consulta)){
																$obsql = $resql->fetch_object();
																$nombre_objetivo = $obsql->nombre_objetivo;
																$resql->close();
															} 
													?>  
													<tr style="max-width:30px;overflow:auto;">
														<td>
															<?php echo $nombre_objetivo; ?>
														</td>
														<td>


															<?php          
															$consulta = "SELECT * FROM entregable WHERE entrega_rol_id = '$id_rol' AND entrega_objetivo_id = '$objetivo_id'";
															if($resultado = $mysqli->query($consulta)) {
																while ($obj = $resultado->fetch_object()){
																	$objetivo = $objs->entrega_objetivo_id;
																	$entrega = $obj->entrega_id;

																	$consultan = "SELECT * FROM entregable WHERE entrega_objetivo_id = '$objetivo' AND entrega_id = '$entrega' ";
																	if($resultadon = $mysqli->query($consultan)) {
																		while ($objn = $resultadon->fetch_object()){

																			if (empty($obj->entrega_tipo_texto) == false){
																				if ($obj->entrega_nombre_elemento == 'QR'){
																					echo "<b>QR : </b>".$obj->entrega_tipo_texto."<br><br>"; 
																				}else{	
																					echo "<b>Comentario : </b>".$obj->entrega_tipo_texto."<br><br>"; 
																				}	
																			}
																			if (empty($obj->entrega_tipo_numero) == false){
																				echo "<b>Cantidad : </b>".$obj->entrega_tipo_numero."<br><br>"; 
																			}
																			if (empty($obj->entrega_tipo_fecha) == false AND $obj->entrega_tipo_fecha != '0000-00-00'){
																				echo "<b>Fecha : </b>".$obj->entrega_tipo_fecha."<br><br>";
																			}
																			if (empty($obj->entrega_tipo_hora) == false AND $obj->entrega_tipo_hora != '00:00:00'){
																				echo "<b>Horario: </b>".$obj->entrega_tipo_hora."<br><br>";
																			}
																			if (empty($obj->entrega_tipo_imagen) == false){
																				//echo "<b>$obj->entrega_nombre_elemento:</b><a href='imagenes.php?orden=$ot'>Ver en galería</a><br>";
																				echo "<b>$obj->entrega_nombre_elemento:</b><br>";
															?>
															
															<a href="tmp/<?php echo $obj->entrega_tipo_imagen; ?>" data-lightbox="roadtrip">
															<div style="width:100px;height:100px; background-image: url('tmp/<?php echo $obj->entrega_tipo_imagen; ?>'); background-position:center; background-size:cover">
																
															</div>
															</a>	

															<?php
																			}  

																		} 
																		$resultadon->close();
																	}
																} 
																$resultado->close();
															}
															?>
														</td>
													</tr>                                                
													<?php         




														} 
														$resultados->close();
													}               
													?>

												</tbody>
											</table>                                            
											<div class="card-footer small text-muted"></div>
										</div>

									</div>
								</div>
							</div>
						</section>

					</div>        
				</main>
			</div>
		</div>

		<script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
		<script src="js/lightbox.js" ></script>

		


		<script>
			// Initialize and add the map
			function initMap() {
				var direcciones = "<?php echo $dat; ?>"; 
				var arreglo_uno = direcciones.split("*");

				x = 0;
				size = arreglo_uno.length;

				var locations = [];

				while (x < size){
					var arreglo_dos = arreglo_uno[x].split("/");
					var tienda = arreglo_dos[0];
					var latitud = parseFloat(arreglo_dos[1]);
					var longitud = parseFloat(arreglo_dos[2]);

					locations.push( [tienda,latitud,longitud,x]);

					x++;
				}


				// The location of CDMX
				var place = {lat: <?php echo $latitud; ?>, lng: <?php echo $longitud; ?>};
				var place2 = {lat: <?php echo $latitud2; ?>, lng: <?php echo $longitud2; ?>};

				// The map, centered at CDMX
				var map = new google.maps.Map(
					document.getElementById('mapall'), {zoom: 15, center: place});

				var map2 = new google.maps.Map(
					document.getElementById('mapall2'), {zoom: 15, center: place2});

				var marker, i;
				var marker2, y;

				for (i = 0; i < locations.length; i++) {  
					marker = new google.maps.Marker({
						position: new google.maps.LatLng(<?php echo $latitud; ?>, <?php echo $longitud; ?>),
						map: map,
						title :locations[i][0],


					});
					marker.setTitle('new title');
				}

				for (y = 0; y < locations.length; y++) {  
					marker2 = new google.maps.Marker({
						position: new google.maps.LatLng(<?php echo $latitud2; ?>, <?php echo $longitud2; ?>),
						map: map2,
						title :locations[y][0],


					});

				}


			}
		</script>

		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHRMZzLxhg-mndWI1HkA5Uoos3fud9TZA&callback=initMap"
				async defer></script>

		
	</body>
</html>
