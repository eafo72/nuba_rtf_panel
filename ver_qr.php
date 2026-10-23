<!-- inicio contenido -->
<?php
require_once 'conexion.php';

$id_tienda = $_GET['id'];


$consultas = "SELECT * FROM tienda WHERE tienda_id = $id_tienda";
if ($resultados = $mysqli->query($consultas)) {
    $objs = $resultados->fetch_object();

    $nombre_tienda = $objs->nombre_tienda;
    $nombre_tienda = str_replace(" ", "_", $nombre_tienda);
    $nombre_tienda = str_replace("ñ", "n", $nombre_tienda);
    $nombre_tienda = str_replace("Ñ ", "Ñ", $nombre_tienda);
    $nombre_tienda = str_replace("á", "a", $nombre_tienda);
    $nombre_tienda = str_replace("é", "e", $nombre_tienda);
    $nombre_tienda = str_replace("í", "i", $nombre_tienda);
    $nombre_tienda = str_replace("ó", "o", $nombre_tienda);
    $nombre_tienda = str_replace("ú", "u", $nombre_tienda);
    $nombre_tienda = str_replace("Á", "A", $nombre_tienda);
    $nombre_tienda = str_replace("É", "E", $nombre_tienda);
    $nombre_tienda = str_replace("Í", "I", $nombre_tienda);
    $nombre_tienda = str_replace("Ó", "O", $nombre_tienda);
    $nombre_tienda = str_replace("Ú", "U", $nombre_tienda);

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

$top = $top + 20;
$pdf->SetFont('Helvetica', '', 15);
$pdf->SetXY($left, $top);
$pdf->Image('https://chart.googleapis.com/chart?chs=400x400&cht=qr&chl=id=' . $id_tienda . '-' . $nombre_tienda . '&code.png', $left + 45, $top, 100, 100, '', '');



//FINAL
$file_name = "codigoQR.pdf";

$pdf->Output("assets/pdfs/$file_name", 'F');

echo "<script language='javascript'>window.open('assets/pdfs/$file_name','_blank');</script>";
?>

<script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
<script type="text/javascript">
    window.location.assign("tiendas_panel.php");
</script>