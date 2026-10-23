<?php session_start();
$user_id = $_SESSION['user_id'];  

require_once 'conexion.php';
$ot = $_GET['ot'];
$id_rol = $_GET['id_rol'];

//datos mision
$consultas = "SELECT * FROM rol_maestro_misiones INNER JOIN marcas ON rol_maestro_misiones.rol_marca_id = marcas.marca_id INNER JOIN tienda on rol_maestro_misiones.rol_id_tienda = tienda.tienda_id INNER JOIN misiones on rol_maestro_misiones.rol_id_orden_trabajo = misiones.mision_id_orden_trabajo INNER JOIN colaboradores on rol_maestro_misiones.colaborador_id_asignado_rol = colaboradores.col_usuario_id WHERE rol_maestro_id = '$id_rol' LIMIT 1";
if ($resultados = $mysqli->query($consultas)) {
	$objs = $resultados->fetch_object();
	$tienda = $objs->nombre_tienda;
	$codigoqr = $objs->codigoqr;
	$marca = $objs->nombre_marca;
	$tecnico = $objs->nombre_col . " " . $objs->apellido_col;
	$fecha_programada = $objs->fecha_programada_visita_rol;
	$fecha_llegada = $objs->fecha_inicio_mision;
	$fecha_entrega = $objs->fecha_entrega_mision;
	$hora_programada = $objs->hora_programada_visita_rol;
	$hora_llegada = $objs->hora_inicio_mision;
	$hora_entrega = $objs->hora_entrega_mision;


	$arranque = strtotime($objs->hora_inicio_mision);
	$final = strtotime($objs->hora_entrega_mision);
	$efectivo = round(($final - $arranque) / 60, 2);
	$programa = strtotime($objs->hora_programada_visita_rol);
	$arrivo = strtotime($objs->hora_inicio_mision);
	$retraso = round(($arrivo - $programa) / 60, 2);
	$programada = strtotime($objs->fecha_programada_visita_rol);
	$actividad = strtotime($objs->fecha_inicio_mision);
	$geoinicio = $objs->geo_inicio_mision;
	$geoentrega = $objs->geo_entrega_mision;
	$dif = ($actividad - $programada);
	$combo = explode(',', $geoinicio);
	$latitud = $combo[0];
	$longitud = $combo[1];
	$combo2 = explode(',', $geoentrega);
	$latitud2 = $combo2[0];
	$longitud2 = $combo2[1];

	$combo_horas_pausas = explode("/", $objs->pausas_mision);
	$combo_horas_reinicios = explode("/", $objs->reinicios_mision);
	$combo_prcomentarios = explode("/", $objs->prcomentarios);

	$SOS_causa = $objs->sos_causa;
	$SOS_comentario = $objs->sos_comentario;

	$resultados->close();
}

//datos objetivo
$consultas = "SELECT DISTINCT entrega_objetivo_id FROM entregable WHERE entrega_rol_id = '$id_rol'";
if ($resultados = $mysqli->query($consultas)) {
	while ($objs = $resultados->fetch_object()) {
		$objetivo_id = $objs->entrega_objetivo_id;

		$consulta = "SELECT * FROM entregable INNER JOIN objetivos ON entregable.entrega_objetivo_id = objetivos.objetivo_id WHERE entrega_rol_id = '$id_rol' AND entrega_objetivo_id = '$objetivo_id'";
		if ($resql = $mysqli->query($consulta)) {
			$obsql = $resql->fetch_object();
			$nombre_objetivo = $obsql->nombre_objetivo;
			$resql->close();
		}

		$consulta = "SELECT * FROM entregable WHERE entrega_rol_id = '$id_rol' AND entrega_objetivo_id = '$objetivo_id'";
		if ($resultado = $mysqli->query($consulta)) {
			while ($obj = $resultado->fetch_object()) {
				$objetivo = $objs->entrega_objetivo_id;
				$entrega = $obj->entrega_id;

				$consultan = "SELECT * FROM entregable WHERE entrega_objetivo_id = '$objetivo' AND entrega_id = '$entrega' ";
				if ($resultadon = $mysqli->query($consultan)) {
					while ($objn = $resultadon->fetch_object()) {
						if (empty($obj->entrega_tipo_imagen) == false && $obj->entrega_nombre_elemento == 'Foto') {
							$foto = $obj->entrega_tipo_imagen;

						}
						if (empty($obj->entrega_tipo_imagen) == false && $obj->entrega_nombre_elemento == 'Firma') {
							$firma = $obj->entrega_tipo_imagen;

						}
						if (empty($obj->entrega_tipo_texto) == false && $obj->entrega_nombre_elemento == 'Comentario') {
							$comentario = $obj->entrega_tipo_texto;

						}
						if (empty($obj->entrega_tipo_texto) == false && $obj->entrega_nombre_elemento == 'QR') {
							$contenidoqr = $obj->entrega_tipo_texto;

						}
					}
					$resultadon->close();
				}
			}
			$resultado->close();
		}
	}
	$resultados->close();
}

include('fpdf/fpdf.php');
#Creamos el objeto pdf (con medidas en milímetros): 
$pdf = new FPDF('P', 'mm', 'A4'); //poner la hoja vertical
//$pdf=new FPDF('L','mm','A4'); //poner la hoja horizontal


$pdf->AddPage();


//hoja1 total ancho sin margenes en horizontal = 300
//hoja1 total ancho sin margenes en vertical = 210

$left = 10;
$right = 10;
$top = 10;
$ancho_total_portrait = (210 - $left - $right);
$ancho_total_landscape = (300 - $left - $right);
$mitad_ancho_total_portrait = $ancho_total_portrait / 2;
$mitad_ancho_total_landscape = $ancho_total_landscape / 2;
$mitad_dela_hoja = 210 / 2;
$mitad_dela_hoja_landscape = 300 / 2;

//LOGO
$pdf->SetFont('Helvetica', '', 8);


if($user_id == 23){
	$pdf->Image('landing/images/hpmled_logo.jpg', 0, 5, 70, 14, '', ''); //left,top,ancho,alto
	$top = $top + 15;
}else if($user_id == 31){
	$pdf->Image('landing/images/lup_logo.jpg', 10, 5, 20, 20, '', ''); //left,top,ancho,alto
	$top = $top + 15;
}else{
	$pdf->Image('assets/images/logo_nubartforms.jpeg', 0, 0, 85, 40, '', ''); //left,top,ancho,alto
	$top = $top + 20;
}




$pdf->SetFont('Helvetica', '', 15);
$pdf->SetXY($left, $top);
$pdf->MultiCell($ancho_total_portrait, 15, utf8_decode("VISITA A CLIENTE"), 0, 'C', 0);
$pdf->SetFont('Helvetica', '', 8);

//right
$top = $top + 20;

$pdf->SetFont('Helvetica', '', 12);
$pdf->SetXY($left, $top);
$texto = utf8_decode('Información de la visita');
$pdf->SetTextColor(255, 255, 255);
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetFillColor(55, 155, 41);
$pdf->cell(0, 10, $texto, 1, 0, 'L', 1);
$pdf->SetFont('Helvetica', '', 8);
$pdf->SetTextColor(0, 0, 0);
$top = $top + 12;

$pdf->SetXY($left, $top);
$pdf->MultiCell($mitad_ancho_total_portrait, 5, utf8_decode("Cliente:" . $tienda), 0, 1);

//left
$pdf->SetXY($left + 100, $top);
$pdf->MultiCell($mitad_ancho_total_portrait, 5, utf8_decode("Fecha Programada:" . $fecha_programada), 0, 1);


//right
$top = $top + 4;
$pdf->SetXY($left, $top);
$pdf->MultiCell($mitad_ancho_total_portrait, 5, utf8_decode("OT:" . $ot), 0, 1);

//left
$pdf->SetXY($left + 100, $top);
$pdf->MultiCell($mitad_ancho_total_portrait, 5, utf8_decode("Fecha Llegada:" . $fecha_llegada), 0, 1);

//right
$top = $top + 4;
$pdf->SetXY($left, $top);
$pdf->MultiCell($mitad_ancho_total_portrait, 5, utf8_decode("Técnico Asignado:" . $tecnico), 0, 1);

//left
$pdf->SetXY($left + 100, $top);
$pdf->MultiCell($mitad_ancho_total_portrait, 5, utf8_decode("Fecha Entrega:" . $fecha_entrega), 0, 1);

//right
$top = $top + 4;
$pdf->SetXY($left, $top);
$pdf->MultiCell($mitad_ancho_total_portrait, 5, utf8_decode("Tiempo efectivo dentro de la ubicación:" . $efectivo . " min."), 0, 1);

//left
$pdf->SetXY($left + 100, $top);
$pdf->MultiCell($mitad_ancho_total_portrait, 5, utf8_decode("Hora Programada:" . $hora_programada), 0, 1);



//right
$top = $top + 4;
$pdf->SetXY($left, $top);
if ($dif < 0) {
	$pdf->MultiCell($mitad_ancho_total_portrait, 5, utf8_decode("Retraso en arrivo:Ninguno"), 0, 1);
} else {
	$pdf->MultiCell($mitad_ancho_total_portrait, 5, utf8_decode("Retraso en arrivo:" . $retraso . " min."), 0, 1);
}

//left
$pdf->SetXY($left + 100, $top);
$pdf->MultiCell($mitad_ancho_total_portrait, 5, utf8_decode("Hora Llegada:" . $hora_llegada), 0, 1);


//right
$top = $top + 4;
$pdf->SetXY($left, $top);
$pdf->MultiCell($mitad_ancho_total_portrait, 5, utf8_decode("Pausas:"), 0, 1);

//left
$pdf->SetXY($left + 100, $top);
$pdf->MultiCell($mitad_ancho_total_portrait, 5, utf8_decode("Hora entrega:" . $hora_entrega), 0, 1);


for ($i = 0; $i < count($combo_horas_pausas); $i++) {
	if ($combo_horas_pausas[$i] != '') {
		$top = $top + 4;
		$pdf->MultiCell($mitad_ancho_total_portrait, 5, utf8_decode($combo_horas_pausas[$i]), 0, 1);
	}
}


$top = $top + 8;
$pdf->SetXY($left, $top);
$pdf->MultiCell($mitad_ancho_total_portrait, 5, utf8_decode("Comentarios Pausas:"), 0, 1);



for ($i = 0; $i < count($combo_prcomentarios); $i++) {
	$tipo = substr($combo_prcomentarios[$i], 0, 2);
	if ($tipo == 'P:') {
		$comboP = explode(":", $combo_prcomentarios[$i]);
		$top = $top + 4;
		$pdf->MultiCell($mitad_ancho_total_portrait, 5, utf8_decode($comboP[1]), 0, 1);
	}
}


$top = $top + 8;
$pdf->SetXY($left, $top);
$pdf->MultiCell($mitad_ancho_total_portrait, 5, utf8_decode("Reinicios:"), 0, 1);


for ($i = 0; $i < count($combo_horas_reinicios); $i++) {
	if ($combo_horas_reinicios[$i] != '') {
		$top = $top + 4;
		$pdf->MultiCell($mitad_ancho_total_portrait, 5, utf8_decode($combo_horas_reinicios[$i]), 0, 1);
	}
}

$top = $top + 8;
$pdf->SetXY($left, $top);
$pdf->MultiCell($mitad_ancho_total_portrait, 5, utf8_decode("Comentarios Reinicios:"), 0, 1);


for ($i = 0; $i < count($combo_prcomentarios); $i++) {
	$tipo = substr($combo_prcomentarios[$i], 0, 2);
	if ($tipo == 'R:') {
		$comboR = explode(":", $combo_prcomentarios[$i]);
		$top = $top + 4;
		$pdf->MultiCell($mitad_ancho_total_portrait, 5, utf8_decode($comboR[1]), 0, 1);
	}
}

$top = $top + 8;
$pdf->SetXY($left, $top);
$pdf->MultiCell($mitad_ancho_total_portrait, 5, utf8_decode("SOS causa:" . $SOS_causa), 0, 1);

$top = $top + 4;
$pdf->SetXY($left, $top);
$pdf->MultiCell($mitad_ancho_total_portrait, 5, utf8_decode("SOS comentario:" . $SOS_comentario), 0, 1);



//encabezado
$top = $top + 10;
$pdf->SetFont('Helvetica', '', 12);
$pdf->SetXY($left, $top);
$texto = utf8_decode('Geolocalización de la visita');
$pdf->SetTextColor(255, 255, 255);
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetFillColor(55, 155, 41);
$pdf->cell(0, 10, $texto, 1, 0, 'L', 1);
$pdf->SetFont('Helvetica', '', 8);
$pdf->SetTextColor(0, 0, 0);
$top = $top + 12;

$pdf->SetXY($left, $top);
$pdf->MultiCell($mitad_ancho_total_portrait, 5, utf8_decode("Entrada:" . $geoinicio), 0, 1);

//mapa1
$url = "https://maps.googleapis.com/maps/api/staticmap?center=" . $latitud . "," . $longitud . "&zoom=15&markers=color:red%7Clabel:E%7C" . $latitud . "," . $longitud . "&size=500x200&key=AIzaSyBHRMZzLxhg-mndWI1HkA5Uoos3fud9TZA";
$img1 = __DIR__ . '/assets/mapas/map1.png';
file_put_contents($img1, file_get_contents($url));
$pdf->Image($img1, $left, $top + 10, 90, 50, '', '');


//mapa2
$pdf->SetXY($left + 100, $top);
$pdf->MultiCell($mitad_ancho_total_portrait, 5, utf8_decode("Salida:" . $geoentrega), 0, 1);
$url = "https://maps.googleapis.com/maps/api/staticmap?center=" . $latitud2 . "," . $longitud2 . "&zoom=15&markers=color:red%7Clabel:S%7C" . $latitud2 . "," . $longitud2 . "&size=500x200&key=AIzaSyBHRMZzLxhg-mndWI1HkA5Uoos3fud9TZA";
$img2 = __DIR__ . '/assets/mapas/map2.png';
file_put_contents($img2, file_get_contents($url));
$pdf->Image($img2, $left + 100, $top + 10, 90, 50, '', '');





$pdf->SetXY(180, 265);
$pdf->MultiCell($ancho_total_portrait, 5, utf8_decode("Página 1/2"), 0, 1);

$pdf->SetXY($left, 270);
$pdf->MultiCell($ancho_total_portrait, 5, utf8_decode("Nuba RTForms"), 0, 'C', 0);


//////////////////////////	HOJA 2 //////////////////////////////////////////


$pdf->AddPage();


//hoja1 total ancho sin margenes en horizontal = 300
//hoja1 total ancho sin margenes en vertical = 210

$left = 10;
$right = 10;
$top = 10;
$ancho_total_portrait = (210 - $left - $right);
$ancho_total_landscape = (300 - $left - $right);
$mitad_ancho_total_portrait = $ancho_total_portrait / 2;
$mitad_ancho_total_landscape = $ancho_total_landscape / 2;
$mitad_dela_hoja = 210 / 2;
$mitad_dela_hoja_landscape = 300 / 2;

//LOGO
$pdf->SetFont('Helvetica', '', 8);

if($user_id == 23){
	$pdf->Image('landing/images/hpmled_logo.jpg', 0, 5, 70, 14, '', ''); //left,top,ancho,alto
	$top = $top + 15;
}else if($user_id == 31){
	$pdf->Image('landing/images/lup_logo.jpg', 10, 5, 20, 20, '', ''); //left,top,ancho,alto
	$top = $top + 15;
}else{
	$pdf->Image('assets/images/logo_nubartforms.jpeg', 0, 0, 85, 40, '', ''); //left,top,ancho,alto
	$top = $top + 20;
}


$pdf->SetFont('Helvetica', '', 15);
$pdf->SetXY($left, $top);
$pdf->MultiCell($ancho_total_portrait, 15, utf8_decode("VISITA A CLIENTE"), 0, 'C', 0);
$pdf->SetFont('Helvetica', '', 8);

//encabezado
$top = $top + 20;
$pdf->SetFont('Helvetica', '', 12);
$pdf->SetXY($left, $top);
$texto = utf8_decode('Entregables');
$pdf->SetTextColor(255, 255, 255);
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetFillColor(55, 155, 41);
$pdf->cell(0, 10, $texto, 1, 0, 'L', 1);
$pdf->SetFont('Helvetica', '', 8);
$pdf->SetTextColor(0, 0, 0);
$top = $top + 12;

//titulo objetivo
$pdf->SetXY($left, $top);
$pdf->MultiCell($mitad_ancho_total_portrait, 5, utf8_decode("Objetivo:" . $nombre_objetivo), 0, 1);
$top = $top + 5;


//foto
if ($foto != '') {
	$photo = __DIR__ . "/tmp/" . $foto;

	include ("class.ExifCleaning.php");
	chmod($photo, 0755);
	ExifCleaning::adjustImageOrientation($photo); 

	list($width, $height) = getimagesize($photo);

	include('Thumbnail.clase.php');

	$thumb = new Thumbnail($photo);
	if ($thumb->error) {
		echo $thumb->error;
	} else {

		if($height > $width){
			$thumb->resize(100,240);
		}else{
			$thumb->resize(240,100);
		}
		$thumb->save_jpg("foto.jpg"); //si lo guardamos con png falla
		$photo_resized = __DIR__ . "/tmp/foto.jpg"; //si lo guardamos con png falla
	}
	$pdf->SetXY($left + 20, $top);
	$pdf->MultiCell(50, 5, "Foto", 0, 1);
	$pdf->SetXY($left, $top);
	$pdf->Image($photo_resized, $left, $top + 10, 50, 50, '', '');
}

//firma
if ($firma != '') {
	$sign = __DIR__ . "/tmp/" . $firma;

	$thumb2 = new Thumbnail($sign);
	if ($thumb2->error) {
		echo $thumb2->error;
	} else {
		$thumb2->resize(240, 100);
		$thumb2->save_jpg("firma.jpg"); //si lo guardamos con png falla
		$sign_resized = __DIR__ . "/tmp/firma.jpg"; //si lo guardamos con png falla
	}
	$pdf->SetXY($left + 80, $top);
	$pdf->MultiCell(50, 5, "Firma", 0, 1);
	$pdf->SetXY($left, $top);
	$pdf->Image($sign_resized, $left + 60, $top + 10, 50, 50, '', '');
}

//comentario
if ($comentario != '') {
	$pdf->SetXY($left + 140, $top);
	$pdf->MultiCell(50, 5, "Comentario", 0, 1);
	$pdf->SetXY($left + 120, $top + 5);
	$pdf->MultiCell(50, 5, $comentario, 0, 1);
}

//qr
if ($codigoqr == 'Si') {
	$top = $top + 70;
	$pdf->SetXY($left, $top);
	$pdf->MultiCell(10, 5, "QR:", 0, 1);
	$pdf->SetXY($left+7, $top);
	$pdf->MultiCell(50, 5, $contenidoqr, 0, 1);
}






$pdf->SetXY(180, 265);
$pdf->MultiCell($ancho_total_portrait, 5, utf8_decode("Página 2/2"), 0, 1);

$pdf->SetXY($left, 270);
$pdf->MultiCell($ancho_total_portrait, 5, utf8_decode("Nuba RTForms"), 0, 'C', 0);










//FINAL
$file_name = "visita.pdf";

$pdf->Output("assets/pdfs/$file_name", 'F');

echo "<script language='javascript'>window.open('assets/pdfs/$file_name','_blank');</script>";
?>

<script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
<script type="text/javascript">
	var id_rol = "<?php echo $id_rol; ?>";
	var id_ot = "<?php echo $ot; ?>";
	window.location.assign("consultar_tienda_info.php?id=" + id_rol + "&ot=" + id_ot);
</script>