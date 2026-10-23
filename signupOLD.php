<?php session_start();
require_once("conexion.php");
?>
<!doctype html>
<html lang="zxx">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="landing/css/bootstrap.min.css">
    <link href="vendor/css/style.css" rel="stylesheet">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="landing/css/animate.min.css">
    <!-- Magnific CSS -->
    <link rel="stylesheet" href="landing/css/magnific-popup.css">
    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="landing/css/owl.carousel.min.css">
    <link rel="stylesheet" href="landing/css/owl.theme.default.min.css">
    <!-- Line Awesome CSS -->
    <link rel="stylesheet" href="landing/css/line-awesome.min.css">
   
    <!-- Stylesheet CSS -->
    <link rel="stylesheet" href="landing/css/style.css">
    <!-- Stylesheet Responsive CSS -->
    <link rel="stylesheet" href="landing/css/responsive.css">
    <!-- Favicon -->
    <link rel="icon" type="images/png" href="landing/images/favicon.png">

    
    
    <!-- Title -->
    <title>RFT-Sistema de gestión operativa</title>
    <style>
        input::placeholder {
            color: #242424 !important;
        }

        textarea::placeholder {
            color: #242424 !important;
        }
    </style>
</head>

<body data-spy="scroll" data-offset="70">
    <!--
    
    <div class="preloader">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="lds-hourglass"></div>
            </div>
        </div>
    </div>
    
    -->

    <!-- Nabvar Area -->
    <nav class="navbar fixed-top navbar-expand-lg main-navbar bg-white">
        <div class="container">
            <a class="navbar-brand" href="index.html">
                <img src="landing/images/logo-rtf-original.png" style="width: 150px;" alt="logo">
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="icon-bar top-bar"></span>
                <span class="icon-bar middle-bar"></span>
                <span class="icon-bar bottom-bar"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav m-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html#home">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.html#services">Características</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="index.html#pricing">Planes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.html#contact">Contacto</a>
                    </li>
                </ul>
                <div class="nav-btn">
                    <a href="login.php" class="default-btn bg-main mr-2">Ingresar</a>

                </div>
            </div>
        </div>
    </nav>
    <!-- End Nabvar Area -->







    <!-- Contact Area -->
    <div id="contact" class="contact-area ptb-100">
        <div class="container">
            <div class="section-title">
                <h2>Regístrate</h2>
            </div>

            <div class="contact-content">
                <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="paquete" value="<?php echo $_GET['id']; ?>">

                    <div class="row">
                        <div class="col-12 col-md-4"></div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <input type="text" name="nombre_completo" class="form-control"
                                    placeholder="Nombre Completo" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-4"></div>

                        <div class="col-12 col-md-4"></div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <input type="text" name="nombre_usuario" class="form-control"
                                    placeholder="Nombre de usuario" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-4"></div>

                        <div class="col-12 col-md-4"></div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <input type="password" name="password" class="form-control" placeholder="Contraseña"
                                    required>
                            </div>
                        </div>
                        <div class="col-12 col-md-4"></div>

                        <div class="col-12 col-md-4"></div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <input type="password" name="password2" class="form-control"
                                    placeholder="Confirma tu contraseña" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-4"></div>


                        <div class="col-12 text-center">
                            <br>
                            <input type="submit" name="Registrar" class="default-btn" value="Guardar" />
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </form>
                <?php
                if (isset($_REQUEST['Registrar'])) {

                    $paquete = $_POST['paquete'];
                    $nombre_completo = $_POST['nombre_completo'];
                    $nombre_usuario = $_POST['nombre_usuario'];
                    $password = $_POST['password'];
                    $password2 = $_POST['password2'];

                    if ($password === $password2) {

                        $buscarUsuario = "SELECT * FROM usuarios WHERE nombre_usuario = '$nombre_usuario'";
                        $result = $mysqli->query($buscarUsuario);
                        $count = mysqli_num_rows($result);
                        if ($count == 1) {
                            ?>
                            <script type="text/javascript">
                                alert('El nombre de usuario ya existe, escoge otro e inténtalo nuevamente.');
                            </script>
                        <?php
                        } else {
                            $hash = password_hash($password, PASSWORD_BCRYPT);

                            $alta = "INSERT INTO usuarios SET 
                                nombre_completo = '$nombre_completo',
                                nombre_usuario = '$nombre_usuario',
                                password = '$hash',
                                estado = 'Activo',
                                permisos = 'Cliente'
                                ";
                            $mysqli->query($alta);


                            //buscamos el id q acabamos de dar de alta
                            $con7 = "SELECT MAX(usuario_id) AS id FROM usuarios";
                            $res = $mysqli->query($con7);
                            $obY = $res->fetch_object();
                            $id_usuario = $obY->id;
                            $res->close();

                            $sql = "INSERT INTO clientes_paquetes_actuales SET
                                 id_cliente = $id_usuario,
                                 id_paquete = $paquete,
                                 status = 'Pausado'";
                            $mysqli->query($sql);

                            //enviamos a pagar
                            $_SESSION['loggedin'] = true;
                            $_SESSION['username'] = $nombre_usuario;
                            $_SESSION['nombre_completo'] = $nombre_completo;
                            $_SESSION['permisos'] = 'Cliente'; 
                            $_SESSION['user_id'] = $id_usuario;   

                            ?>
                            <script>
                                alert("Listo, has creado tu cuenta, ahora paga tu paquete");
                                window.location.assign("registrar_pago.php");
                            </script>
                            <?php    

                        }
                    } else {
                        ?>
                        <script>
                            alert("Las contraseñas no coinciden, corrige e inténtalo nuevamente.");
                        </script>
                        <?php    
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <!-- End Contact Area -->


    <!-- Footer Area -->
    <footer class="footer-area pt-200 bor-radius-right">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="footer-widget">
                        <div class="logo">
                            <img src="landing/images/logo-rtf-original.png" alt="logo">
                        </div>
                        <p>RTF Forms es sistema de gestión interna que contiene herramientas específicas que optimizan
                            los procesos de trabajo y el acceso a la información de su empresa desde las distintas áreas
                            de la misma. RTF conecta, simplifica y agiliza procesos.</p>


                    </div>
                </div>

                <div class="col-lg-5 col-md-6 col-sm-6">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="footer-widget">
                                <h3 class="title">Compañía</h3>
                                <ul class="footer-text">
                                    <li>
                                        <a href="aviso_de_privacidad.html">
                                            <i class="las la-angle-right"></i>
                                            Aviso de privacidad
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="las la-angle-right"></i>
                                            Soporte técnico
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="footer-widget">
                                <h3 class="title">Enlaces</h3>
                                <ul class="footer-text">
                                    <li>
                                        <a href="#">
                                            <i class="las la-angle-right"></i>
                                            Inicio
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 offset-md-4 offset-sm-4 offset-lg-0">
                    <div class="footer-widget">
                        <h3 class="title">Descargar</h3>
                        <div class="footer-image">
                            <a href="#">
                                <img src="landing/images/logo-rtf-bco.png" alt="Image" style="width:150px">
                            </a>

                        </div>
                    </div>
                </div>
            </div>

            <div class="copyright-text">
                <p>®Derechos Reservados 2020 RTF Forms.</p>
            </div>
        </div>
    </footer>
    <!-- End Footer Area -->

    <!-- Go Top -->
    <div class="go-top">
        <i class="las la-angle-double-up"></i>
    </div>
    <!-- End Go Top -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="landing/js/jquery.min.js"></script>
    <script src="landing/js/popper.min.js"></script>
    <script src="landing/js/bootstrap.min.js"></script>
    

</body>

</html>