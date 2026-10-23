<?php
session_start();
?>
<?php



$host_db = "db5000864815.hosting-data.io";
$user_db = "dbu134514";
$pass_db = "eQUIP@89%%%";
$db_name = "dbs761031";



$tbl_name = "usuarios";
$conexion = new mysqli($host_db, $user_db, $pass_db, $db_name);
if ($conexion->connect_error) {
 die("La conexion falló: " . $conexion->connect_error);
}
$username = $_POST['username'];
$password = $_POST['password'];
$sql = "SELECT * FROM $tbl_name WHERE BINARY nombre_usuario = '$username' AND estado='Activo'"; /*OJO EL BINARY ES PARA HACER LA CONSULTA SENSITIVE */
$result = $conexion->query($sql);
$resultado = $conexion->query($sql);
if ($result->num_rows > 0) {     
    $obj = $resultado->fetch_object();
    
    $permisos = $obj->permisos;
    $nombre_completo = $obj->nombre_completo;
    $user_id = $obj->usuario_id;    
    
    $row = $result->fetch_array(MYSQLI_ASSOC);
    if (password_verify($password, $row['password'])) { 
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['nombre_completo'] = $nombre_completo;
        $_SESSION['permisos'] = $permisos; 
        $_SESSION['user_id'] = $user_id;   
    
        if ($permisos == 'Colaborador' ){
            /*
            
            //ir a buscar en colaboradores la sig info    
            $sql ="SELECT * FROM colaboradores WHERE col_usuario_id = '$user_id'";
            if ($resql = $conexion->query($sql)){
                $count = mysqli_num_rows($resql);
                if ($count > 0){
                    $obsql = $resql->fetch_object();
                    $user_nombre = $obsql->nombre_col." ".$obsql->apellido_col;
                    $user_address = $obsql->direccion;   
                    $user_photo = $obsql->foto;  
                    if ($user_photo != ''){
                        $imagen = file_get_contents('assets/images/'.$user_photo);
                        $imagendata = base64_encode($imagen);    
                    }else{
                        $imagendata = '';    
                    }
                    $resql->close();
                }
            }
        
            ?>
            <script>
                var passjs = "<?php echo $password; ?>";
                var usernamejs = "<?php echo $username; ?>";
                var idusernamejs = "<?php echo $user_id; ?>";
                var nameuserjs = "<?php echo $user_nombre; ?>";
                var adruserjs = "<?php echo $user_address; ?>";
                var phuserjs = "<?php echo $imagendata; ?>";
                var permisosjs = "<?php echo $permisos; ?>";
                
                localStorage.setItem('pass', passjs);
                localStorage.setItem('user', usernamejs);
                localStorage.setItem('id_user', idusernamejs);
                localStorage.setItem('nombre_user', nameuserjs);
                localStorage.setItem('direccion_user', adruserjs);
                localStorage.setItem('foto_user', phuserjs);
                localStorage.setItem('permisos', permisosjs);
                
                window.location.assign("inicio.html");
            </script>
            <?php
            */
            ?>
            <script>
                alert("Descargue la app de google playstore o apple store");
                window.location.assign("login.php");
            </script>
            <?php

        }   
        if ($permisos == 'Administrador'){ 
            ?>
            <script>
                var passjs = "<?php echo $password; ?>";
                var usernamejs = "<?php echo $username; ?>";
                var idusernamejs = "<?php echo $user_id; ?>";
                var permisosjs = "<?php echo $permisos; ?>";
                
                localStorage.setItem('pass', passjs);
                localStorage.setItem('user', usernamejs);
                localStorage.setItem('id_user', idusernamejs);
                localStorage.setItem('permisos', permisosjs);
                
                window.location.assign("asistencia.php");
            </script>
            <?php
     
        }
        if ($permisos == 'Cliente'){ 
            ?>
            <script>
                var passjs = "<?php echo $password; ?>";
                var usernamejs = "<?php echo $username; ?>";
                var idusernamejs = "<?php echo $user_id; ?>";
                var permisosjs = "<?php echo $permisos; ?>";
                
                localStorage.setItem('pass', passjs);
                localStorage.setItem('user', usernamejs);
                localStorage.setItem('id_user', idusernamejs);
                localStorage.setItem('permisos', permisosjs);
                
                window.location.assign("admin.php");
            </script>
            <?php
     
        }
     
    }else{ 
        ?>
        <script type="text/javascript">
            alert('Nombre de Usuario o Password incorrectos....');
            window.location.assign("login.php");
        </script>
        <?php         
    }
}else{ 
   ?>
    <script type="text/javascript">
        alert('Nombre de Usuario o Password incorrectos....');
        window.location.assign("login.php");
    </script>
    <?php         
}
mysqli_close($conexion);
?>
 

