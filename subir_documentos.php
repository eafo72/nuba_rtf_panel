<?php
if (isset($_REQUEST['Cambiar'])) {
    $id = $_REQUEST['id'];
    $file_name = $_FILES['image']['name'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $filenewname = "id_";
    $filenewname .= $id;
    $filenewname .= '_';
    $filenewname .= strtolower($file_name);

    if (file_exists('assets/documentos/' . $filenewname)) {
        $counter = 1;
        while (@file_exists('assets/documentos/(' . $counter . ')' . $filenewname)) {
            $counter++;
        }
        $filenewname = '(' . $counter . ')' . $filenewname;
    }

    move_uploaded_file($file_tmp, "assets/documentos/" . $filenewname);

    include("conexion.php");
    $consulta2 = "SELECT * FROM marcas WHERE marca_id = '$id'";
    $resultado2 = $mysqli->query($consulta2);
    $Obj = $resultado2->fetch_object();

    if ($Obj->documentos == '') {
        $acumulado = $filenewname;
    } else {
        $acumulado = $Obj->documentos . ',' . $filenewname;
    }
    

    $consulta = "UPDATE marcas SET documentos ='$acumulado' WHERE marca_id = '$id'";
    $mysqli->query($consulta);
    $resultado2->close();
   

    ?>
    <script type="text/javascript">
        window.location.assign("marcas_panel.php");
    </script>
    <?php
}
?>