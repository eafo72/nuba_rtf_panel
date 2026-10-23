<?php 
if(isset($_REQUEST['Solicitar'])){
    $from = $_REQUEST['correo'];
    $dominio = explode('@',$from);
    if(checkdnsrr($dominio[1])){ //checa si existe el dominio
              
        $nombre = $_REQUEST['nombre'];
        $descripcion = $_REQUEST['descripcion'];
       
        
        require("includes/class.phpmailer.php");
        require("includes/class.smtp.php");

        $asunto  = 'Solicitud de Objetivo';

        $mail = new PHPMailer();
        $mail->From     = $from;    // Correo Electronico para SMTP 
        $mail->FromName = $nombre; 

        
        $mail->AddAddress("contacto@gomalab.com");
        

        $mail->WordWrap = 50; 
        $mail->IsHTML(true);     
        $mail->Subject  =  $asunto;      // asunto

        $body = $nombre . " solicita un objetivo <br>"; 
        $body .= "Correo : ".$from.""; 
        $body .= "<br>"; 
        $body .= "Descripción : ".$descripcion.""; 
        
        $mail->Body = $body;

        $mail->IsSMTP(); 
        $mail->Host = "smtp.ionos.mx";  // mail. o solo dominio - Servidor de Salida. (recomiendo sin mail.)
        $mail->Port = 587; // or 587
        $mail->SMTPAuth = true; 
        $mail->SMTPSecure = 'tls'; // transferencia segura REQUERIDA para Gmail                                    
        $mail->Username = "contacto@gomalab.com";  // Correo Electrónico para SMTP correo@dominio.tld
        $mail->Password = "Gomalab2022&&"; // Contraseña para SMTP
        $mail->SMTPDebug = 1;                         

        if ($mail->Send()){
            ?>
            <script type="text/javascript">
                alert("Su mensaje se ha enviado satisfactoriamente, pronto estarémos en contacto, gracias..");
                window.location.assign('admin.php');
            </script>
            <?php
        }else{
            ?>
            <script type="text/javascript">
                alert('Error correo no enviado.');
                window.location.assign('clientes_solicitar_formulario.php');
            </script>
            <?php
        }
    }else{
        ?>
        <script type="text/javascript">
            alert("La cuenta de e-mail proporcionada no existe, inténtelo de nuevo, gracias..");
            window.location.assign('clientes_solicitar_formulario.php');
        </script>
        <?php
    }
}    
?>
