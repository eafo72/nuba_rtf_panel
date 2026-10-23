    <?php
    $id_marca = $_POST['id_marca'];
    require_once('conexion.php');
    $sql = "SELECT * FROM relacion_m_t_c INNER JOIN tienda ON relacion_m_t_c.relacion_mtc_tienda_id = tienda.tienda_id
    WHERE relacion_m_t_c.relacion_mtc_marca_id = '$id_marca'";
    if ($resql = $mysqli->query($sql)){
        $count=mysqli_num_rows($resql);
        if ($count > 0){
            ?>
            <h6><b>Cliente:</b></h6>     
            <select  name="rol_id_tienda" id="btn_store" required>
                <option value="" hidden>Seleccione</option>
                <?php
                while ($obsql = $resql->fetch_object()){
                    ?>
                    <option value="<?php echo $obsql->relacion_mtc_tienda_id; ?>" ><?php echo $obsql->nombre_tienda; ?></option>
                    <?php
                }
                $resql->close();
                ?>
            </select>
            <br><br>
            <?php    
        }else{
            ?>
            <script>
                alert ('No existen ubicaciones relacionadas al cliente seleccionado');
                document.getElementById('brand').value = '';
            </script>
           
            <?php
        }
    }
    ?>
