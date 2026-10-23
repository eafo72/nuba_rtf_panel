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
                            <h2>Registrar pago</h2>
                            <br>
                            <div align="left">

                                <h6><b>Cliente:</b></h6>
                                <select id="id_cliente" required>
                                    <option value="" hidden>Seleccione</option>
                                    <?php
                                    $sql = "SELECT * FROM clientes_paquetes_actuales INNER JOIN usuarios ON clientes_paquetes_actuales.id_cliente = usuarios.usuario_id INNER JOIN paquetes ON clientes_paquetes_actuales.id_paquete = paquetes.id_paquete ORDER BY usuarios.nombre_completo ASC";
                                    if ($resql = $mysqli->query($sql)) {
                                        while ($obsql = $resql->fetch_object()) {
                                            ?>
                                            <option value="<?php echo $obsql->usuario_id; ?>"><?php echo $obsql->nombre_completo; ?> / total a pagar: $<?php echo $obsql->precio; ?></option>
                                            <?php
                                        }
                                        $resql->close();
                                    }
                                    ?>
                                </select>
                                <br><br>

                                <input type="text" id="codigo_descuento" placeholder="Código de descuento"
                                    onchange="find_code(this.value)" />
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
            let id_cliente = document.getElementById("id_cliente").value;
            if(id_cliente != ''){
                let codigo_descuento = document.getElementById("codigo_descuento").value;
                $.ajax({
                    type: "POST",
                    url: 'clientes_actualizar_pago.php',
                    data: { id_cliente, codigo_descuento },
                    success: function (e) {
                        //console.log(e);
                        alert("Se ha registrado el pago.");
                        //window.location.assign("admin_registrar_pago.php");
                        window.location.assign("pagos_alta.php");
                    }
                });
            }else{
                alert("Debes seleccionar un cliente");
            }    
        }

    </script>
    <script>
        function find_code(codigo) {
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