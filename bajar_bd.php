<?php
$user_id = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1 ">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>RTF</title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<script src="js/jquery.js"></script>
		<script src="js/dexie.js"></script>    
		<script src="js/bootstrap.min.js"></script>
	</head>
	<body style="height:100vh;">

		<div align="center" style="margin-top:10vh">
			<img src="images/loader.gif">  
			<h6>Cargando...</h6>
		</div>    


		<script>

			Dexie.delete('armenta');
			var db = new Dexie("armenta");
			db.version(1).stores({
				relacioneo : 'id, relacioneoid,	relacioneoobjetivoid, relacioneoelementosid, ordenaparicion',    
				elementosllegada : 'id, elementoid, nombreelemento, scriptelemento, name, tipoentrega ',   
				relacionom : 'id, relacionomid, relacionommtcid, relacionomobjetivoid',
				objetivos : 'id, objetivoid, nombreobjetivo, imagenobjetivo, tipoobjetivo, limiterepeticion, meta, entregados, firma',
				entregable : '++entrega_id, entregarolid, entrega_nombre_elemento, entrega_tipo_texto, entrega_tipo_numero, entrega_tipo_fecha, entrega_tipo_hora, entrega_tipo_imagen, entrega_fecha_llegada, entrega_hora_llegada, entregaobjetivoid, entregahoracierre, entregafechacierre, meta_venta',
				misiones : '++mision_id, misionrol_maestroid, misionidordentrabajo, misionidmarca, fechainiciomision, horainiciomision, geoiniciomision, pausasmision, reiniciosmision, prcomentarios, fechaentregamision, horaentregamision,  geoentregamision, soscausa, soscomentario, status',
				leerelementos : 'id_elemento, nombre_elemento, name, tipo_entrega',
				rolmaestromisiones : 'rolmaestroid, rolmarcaid, rolidtienda, rolidordentrabajo, fechahoracreacionvisitarol, fechaprogramadavisitarol, horaprogramadavisitarol, usuarioidcreadorrol, colaboradoridasignadorol, fechayhorasubida, geosubida',
				rolmaestromisionesUNIQUE : 'rolmaestroid, rolmarcaid, rolidtienda, rolidordentrabajo, fechahoracreacionvisitarol, fechaprogramadavisitarol, horaprogramadavisitarol, usuarioidcreadorrol, colaboradoridasignadorol, fechayhorasubida, geosubida',    
				tienda : 'tiendaid, nombretienda, ubicaciontienda, geotienda, encargadotienda, documentoslista, cadenaidtienda',
				marcas : 'marcaid, marclienteid, nombremarca, descripcionmarca, tipomarca, nomarca, incluyeinventario',
				verificacionmarcas : 'idmarca, status',
				geouser : 'id, lat, long'
			});
			db.geouser.put({
				id : 1
			}).catch(function(error) {alert ("Ooops: " + error);});    

			//buscamos geolocalizacion
			
			navigator.geolocation.getCurrentPosition(guardarCoordenadas);
			function guardarCoordenadas(position) {
				var latitud =  position.coords.latitude;
				var longitud = position.coords.longitude;

				var d2 = latitud+'/'+longitud;
				//guardamos la sincronizacion
				var user_id = "<?php echo $user_id;?>";
				$.ajax({
					type: "POST",
					url: 'sincronizacion_guardar.php',
					data:  {latlong: d2, user_id: user_id},
					success: function(){
						
					}
				});   
			}
			
		</script>
		<?php


		require_once('conexion.php');


		$sql = "SELECT * FROM relacion_o_m";
		if ($resql = $mysqli->query($sql)){
			while ($obsql = $resql->fetch_object()){
		?>
		<script>
			var datone = "<?php echo $obsql->relacion_om_id; ?>";
			var dattwo = "<?php echo $obsql->relacion_om_mtc_id; ?>";
			var dattree = "<?php echo $obsql->relacion_om_objetivo_id; ?>";

			var dat1 = parseInt(datone);
			var dat2 = parseInt(dattwo);
			var dat3 = parseInt(dattree);


			db.relacionom.put({
				id : dat1,
				relacionomid : dat1,
				relacionommtcid :dat2,
				relacionomobjetivoid : dat3
			}).catch(function(error) {alert ("Ooops: " + error);});    

		</script>

		<?php
			}
			$resql->close();
		}

		$sql = "SELECT * FROM objetivos";
		if ($resql = $mysqli->query($sql)){
			while ($obsql = $resql->fetch_object()){
		?>
		<script>
			var datone = "<?php echo $obsql->objetivo_id; ?>";
			var dat1 = parseInt(datone);
			var dat2 = "<?php echo $obsql->nombre_objetivo; ?>";
			var dat3 = "<?php echo $obsql->imagen_objetivo; ?>";
			var dat4 = "<?php echo $obsql->tipo_objetivo; ?>";
			var dattwo = "<?php echo $obsql->meta; ?>";
			var dat5 = parseInt(dattwo);
			var dattree = "<?php echo $obsql->entregados; ?>";
			var dat6 = parseInt(dattree);
			var dat7 = "<?php echo $obsql->firma; ?>";

			db.objetivos.put({
				id : dat1,
				objetivoid : dat1,
				nombreobjetivo : dat2,
				imagenobjetivo : dat3,
				tipoobjetivo : dat4,
				meta : dat5,
				entregados : dat6,
				firma : dat7
			}).catch(function(error) {alert ("Ooops: " + error);});    

		</script>

		<?php
			}
			$resql->close();
		}

		$sql = "SELECT * FROM relacion_e_o";
		if ($resql = $mysqli->query($sql)){
			while ($obsql = $resql->fetch_object()){
		?>
		<script>
			var datone = "<?php echo $obsql->relacion_eo_id; ?>";
			var dattwo = "<?php echo $obsql->relacion_eo_objetivo_id; ?>";
			var dattree = "<?php echo $obsql->relacion_eo_elementos_id; ?>";
			var datfour = "<?php echo $obsql->orden_aparicion; ?>";


			var dat1 = parseInt(datone);
			var dat2 = parseInt(dattwo);
			var dat3 = parseInt(dattree);
			var dat4 = parseInt(datfour);



			db.relacioneo.put({
				id : dat1,
				relacioneoid : dat1,
				relacioneoobjetivoid : dat2,
				relacioneoelementosid : dat3,
				ordenaparicion : dat4
			}).catch(function(error) {alert ("Ooops: " + error);});    
		</script>
		<?php
			}
			$resql->close();
		}

		$sql = "SELECT * FROM elementos_llegada";
		if ($resql = $mysqli->query($sql)){
			while ($obsql = $resql->fetch_object()){
		?>
		<script>
			var datone = "<?php echo $obsql->elemento_id; ?>";
			var dat1 = parseInt(datone);
			var dat2 = "<?php echo $obsql->nombre_elemento; ?>";
			var dat3 = '<?php echo $obsql->script_elemento; ?>';
			var dat4 = "<?php echo $obsql->name; ?>";
			var dat5 = "<?php echo $obsql->tipo_entrega; ?>";


			db.elementosllegada.put({
				id : dat1,
				elementoid : dat1,
				nombreelemento : dat2,
				scriptelemento : dat3,
				name : dat4,
				tipoentrega : dat5
			}).catch(function(error) {alert ("Ooops: " + error);});    
		</script>
		<?php
			}
			$resql->close();
		}

		$sql = "SELECT * FROM rol_maestro_misiones WHERE colaborador_id_asignado_rol = '$user_id'";
		if ($resql = $mysqli->query($sql)){
			while ($obsql = $resql->fetch_object()){
		?>
		<script>
			var datone = "<?php echo $obsql->rol_maestro_id; ?>";
			var dat1 = parseInt(datone);
			var dattwo = "<?php echo $obsql->rol_marca_id; ?>";
			var dat2 = parseInt(dattwo);
			var dattree = "<?php echo $obsql->rol_id_tienda; ?>";
			var dat3 = parseInt(dattree);
			var datfour = "<?php echo $obsql->rol_id_orden_trabajo; ?>";
			var dat4 = parseInt(datfour);
			var dat5 = '<?php echo $obsql->fecha_hora_creacion_visita_rol; ?>';
			var dat6 = "<?php echo $obsql->fecha_programada_visita_rol; ?>";
			var dat7 = "<?php echo $obsql->hora_programada_visita_rol; ?>";
			var dat8 = "<?php echo $obsql->usuario_id_creador_rol; ?>";
			var dattree = "<?php echo $obsql->colaborador_id_asignado_rol; ?>";
			var dat9 = parseInt(dattree);
			var dat10 = "<?php echo $obsql->fechayhorasubida; ?>";
			var dat11 = "<?php echo $obsql->geosubida; ?>";




			db.rolmaestromisiones.put({
				rolmaestroid: dat1,
				rolmarcaid: dat2,
				rolidtienda: dat3,
				rolidordentrabajo: dat4,
				fechahoracreacionvisitarol: dat5,
				fechaprogramadavisitarol: dat6,
				horaprogramadavisitarol: dat7,
				usuarioidcreadorrol: dat8,
				colaboradoridasignadorol: dat9,
				fechayhorasubida: dat10,
				geosubida: dat11
			}).catch(function(error) {alert ("Ooops: " + error);});    
		</script>
		<?php

				//tambien agrega solo la tienda del rol maestro
				$sqlQ = "SELECT * FROM tienda WHERE tienda_id = '$obsql->rol_id_tienda'";
				if ($resqlQ = $mysqli->query($sqlQ)){
					while ($obsqlQ = $resqlQ->fetch_object()){
		?>
		<script>
			var datone = "<?php echo $obsqlQ->tienda_id; ?>";
			var dat1 = parseInt(datone);
			var dat2 = "<?php echo $obsqlQ->nombre_tienda; ?>";
			var dat3 = "<?php echo $obsqlQ->ubicacion_tienda; ?>";
			var dat4 = "<?php echo $obsqlQ->geo_tienda; ?>";
			var dat5 = "<?php echo $obsqlQ->encargado_tienda; ?>";
			var dat6 = "<?php echo $obsqlQ->documentos; ?>";
			var dat7 = "<?php echo $obsqlQ->cadena_id_tienda; ?>";

			db.tienda.put({
				tiendaid : dat1,
				nombretienda : dat2, 
				ubicaciontienda : dat3, 
				geotienda : dat4, 
				encargadotienda : dat5, 
				documentoslista : dat6, 
				cadenaidtienda : dat7
			}).catch(function(error) {alert ("Ooops: " + error);});    
		</script>
		<?php
					}
					$resqlQ->close();
				}  
				//tambien agrega solo la marca del rol maestro
				$sqlM = "SELECT * FROM marcas WHERE marca_id = '$obsql->rol_marca_id'";
				if ($resqlM = $mysqli->query($sqlM)){
					while ($obsqlM = $resqlM->fetch_object()){
		?>
		<script>
			var datone = "<?php echo $obsqlM->marca_id; ?>";
			var dat1 = parseInt(datone);
			var dat2 = "<?php echo $obsqlM->mar_cliente_id; ?>";
			var dat3 = "<?php echo $obsqlM->nombre_marca; ?>";
			var dat4 = "<?php echo $obsqlM->descripcion_marca; ?>";
			var dat5 = "<?php echo $obsqlM->tipo_marca; ?>";
			var dat6 = "<?php echo $obsqlM->no_marca; ?>";
			var dat7 = "<?php echo $obsqlM->incluye_inventario; ?>";


			db.marcas.put({
				marcaid : dat1,
				marclienteid : dat2,
				nombremarca : dat3,
				descripcionmarca : dat4,
				tipomarca : dat5, 
				nomarca : dat6,
				incluyeinventario : dat7
			}).catch(function(error) {alert ("Ooops: " + error);});    
		</script>
		<?php
					}
					$resqlM->close();
				}      

			}
			$resql->close();
		}

		$sql = "SELECT * FROM rol_maestro_misiones WHERE colaborador_id_asignado_rol = '$user_id' GROUP BY rol_id_orden_trabajo";

		if ($resql = $mysqli->query($sql)){
			while ($obsql = $resql->fetch_object()){
		?>
		<script>
			var datone = "<?php echo $obsql->rol_maestro_id; ?>";
			var dat1 = parseInt(datone);
			var dattwo = "<?php echo $obsql->rol_marca_id; ?>";
			var dat2 = parseInt(dattwo);
			var dattree = "<?php echo $obsql->rol_id_tienda; ?>";
			var dat3 = parseInt(dattree);
			var datfour = "<?php echo $obsql->rol_id_orden_trabajo; ?>";
			var dat4 = parseInt(datfour);
			var dat5 = '<?php echo $obsql->fecha_hora_creacion_visita_rol; ?>';
			var dat6 = "<?php echo $obsql->fecha_programada_visita_rol; ?>";
			var dat7 = "<?php echo $obsql->hora_programada_visita_rol; ?>";
			var dat8 = "<?php echo $obsql->usuario_id_creador_rol; ?>";
			var dattree = "<?php echo $obsql->colaborador_id_asignado_rol; ?>";
			var dat9 = parseInt(dattree);
			var dat10 = "<?php echo $obsql->fechayhorasubida; ?>";
			var dat11 = "<?php echo $obsql->geosubida; ?>";

			db.rolmaestromisionesUNIQUE.put({
				rolmaestroid: dat1,
				rolmarcaid: dat2,
				rolidtienda: dat3,
				rolidordentrabajo: dat4,
				fechahoracreacionvisitarol: dat5,
				fechaprogramadavisitarol: dat6,
				horaprogramadavisitarol: dat7,
				usuarioidcreadorrol: dat8,
				colaboradoridasignadorol: dat9,
				fechayhorasubida: dat10,
				geosubida: dat11
			}).catch(function(error) {alert ("Ooops: " + error);});    
		</script>
		<?php

			}
			$resql->close();
		}

		?>  
		<script>
			setTimeout(function(){
				window.location.assign("inicio.html");
			},5000);
		</script>

	</body>
</html>