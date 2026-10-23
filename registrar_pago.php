<?php session_start();
require_once("conexion.php");
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

						<div class="col-12">
							<h2>Realiza tu pago</h2>
							<br>
							<?php
							$id_administrador = $_SESSION['user_id'];
							$nombre_administrador = $_SESSION['nombre_completo'];

							$consulta = "SELECT * FROM clientes_paquetes_actuales INNER JOIN paquetes ON clientes_paquetes_actuales.id_paquete = paquetes.id_paquete  WHERE clientes_paquetes_actuales.id_cliente = $id_administrador";
							if ($resultado = $mysqli->query($consulta)) {
								$obj = $resultado->fetch_object();

								$nombre_paquete = $obj->nombre;
								$precio = $obj->precio;
								$vigencia = "del: " . $obj->fecha_inicio . " al " . $obj->fecha_final;
								$fecha_final = $obj->fecha_final;
								$colaboradores = $obj->colaboradores;
								$ubicaciones = $obj->ubicaciones;
								$status = $obj->status;

								$resultado->close();
							}
							?>

							<h4 align="left">Paquete Actual:</h4>
							<br>
							<div align="left">
								<h6>Contrato a nombre de: <span>
										<?php echo $nombre_administrador; ?>
									</span> </h6>
								<h6>Paquete: <span>
										<?php echo $nombre_paquete; ?>
									</span></h6>
								<h6>Precio: <span>$
										<?php echo $precio; ?> MXN
									</span></h6>
								<h6>Vigencia: <span>
										<?php echo $vigencia; ?>
									</span></h6>
								<h6>Máx.Colaboradores: <span>
										<?php echo $colaboradores; ?>
									</span></h6>
								<h6>Máx.Ubicaciones: <span>
										<?php echo $ubicaciones; ?>
									</span></h6>
								<h6>Status: <span>
										<?php echo $status; ?>
									</span></h6>

								<br><br>
								<h4>Total a pagar: $
									<?php echo $precio; ?> MXN
								</h4>
								<br>

								<input type="text" id="codigo_descuento"  placeholder="Código de descuento" onchange="find_code(this.value)"/>

								<br><br>

								<button class='btn btn-success btn-rounded' onclick='go_pay()'>Pagar</button>


							</div>
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

	<script>
		function go_pay() {
			let id_cliente = "<?php echo $id_administrador; ?>";
			let codigo_descuento = document.getElementById("codigo_descuento").value;
			$.ajax({
				type: "POST",
				url: 'clientes_actualizar_pago.php',
				data: { id_cliente, codigo_descuento },
				success: function (e) {
					//console.log(e);
					window.location.assign("admin.php");
				}
			});
		}

	</script>
	<script>
		function find_code(codigo){
			$.ajax({
				type: "POST",
				url: 'clientes_buscar_codigo_descuento.php',
				data: { codigo },
				success: function (e) {

					alert(e);
				}
			});
		}
	</script>	

</body>

</html>