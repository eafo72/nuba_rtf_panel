<?php session_start();
require_once("conexion.php");
?>
<?php
if ($_SESSION['permisos'] == 'Administrador' OR $_SESSION['permisos'] == 'Cliente' OR $_SESSION['permisos'] == 'Supervisor' ) {
    
    if($_SESSION['permisos'] == 'Cliente'){
        $user_id = $_SESSION['user_id'];   
        //buscamos el status del cliente
        $sql ="SELECT * FROM clientes_paquetes_actuales WHERE id_cliente = '$user_id'";
        if ($resql = $mysqli->query($sql)){
            $obsql = $resql->fetch_object();
            $status  = $obsql->status;
            $resql->close();
        }   

        if($status == 'Pausado'){   
            ?>
            <script>
                alert('Lo sentimos su cuenta está en pausa.');
                window.location.assign("registrar_pago.php");
            </script>    
            <?php     
            exit;
        }

    }    
    
} else {
?>
<script>
    alert('Lo sentimos usted no tiene permiso para accesar a esta página..');
    window.location.assign("login.php");
</script>    
<?php 
exit;
}
?>
