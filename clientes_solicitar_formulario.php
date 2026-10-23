<?php include('pass.php');?>
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
                             
                           <div class="col-12 col-md-4"></div>
                           <div class="col-12 col-md-4 text-center">
                            <h2>Solicitar Objetivo</h2>
                            <br>
                            <form method="post" action="mail_handler.php">

                                <input type="hidden" name="nombre" value="<?php echo $_SESSION['nombre_completo'];?> "/>

                                <h4>Describe los requerimientos de tu objetivo:</h4>
                                <br>

                                <div class="form-group">
                                    <h4>Correo:</h4>
                                    <input type="email" class="form-control" name="correo" placeholder="Escribe tu correo" required/>
                                </div>    

                                <div class="form-group">
                                    <textarea class="form-control" rows="10" name="descripcion" placeholder="Describe tu objetivo" required></textarea>
                                </div>    
                                <br><br>  

                                <input class="btn btn-success" type="submit" name="Solicitar" value="Solicitar">

                            </form>
                           </div>
                           <div class="col-12 col-md-4"></div>

                        </div>    
                    </div>
                </main>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
       
        
    </body>
</html>