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
                        <h1 class="mt-4">Reporte de Visitas</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="admin.php">Inicio </a></li>
                            <li class="breadcrumb-item active">Reporte</li>
                        </ol>
                        <div class="row">
                            <div class="col-12">
                                <form method="post" >
                                    <div class="row">
                                        <div class="col-6">


                                            <div class="form-group"> <!-- Date input -->
                                                <label class="control-label">Fecha Inicio</label>
                                                <input class="form-control" type="date" name="fecha_inicial"  />
                                            </div>

                                        </div>   
                                        <div class="col-6">          

                                            <div class="form-group"> <!-- Date input -->
                                                <label class="control-label" >Fecha Final</label>
                                                <input class="form-control" type="date" name="fecha_final"  />
                                            </div>


                                        </div>
                                    </div>
                                    <div class="form-group"> <!-- Submit button -->
                                        <button class="btn btn-success " name="submit" type="submit">Crear Reporte</button>

                                    </div>
                                </form>
                                <br>
                            </div>
                        </div>
                    </div>
                </main>

            </div>
        </div>

        
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>

    </body>
</html>
