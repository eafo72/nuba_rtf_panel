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
                            <div align="center" class="col-12">
                                <form method="post" enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']; ?>">

                                    <br>

                                    <?php
                                    require_once("conexion.php");
                                    $id=$_GET['id'];
                                    $consulta = "SELECT * FROM tienda WHERE tienda_id = $id";
                                    $resultado = $mysqli->query($consulta);
                                    $obj = $resultado->fetch_object();
                                    $nombre_tienda = $obj->nombre_tienda;
                                    $resultado->close();

                                    //buscamos a que marca pertenece la tienda
                                    $consulta = "SELECT * FROM relacion_m_t_c WHERE relacion_mtc_tienda_id = $id";
                                    $resultado = $mysqli->query($consulta);
                                    $obj = $resultado->fetch_object();
                                    $id_marca = $obj->relacion_mtc_marca_id; 
                                    $resultado->close();

                                    

                                    ?>
                                    <h2 style="font-size:25px;">Relacionar Cliente : <?php echo $nombre_tienda; ?></h2>
                                    <br>
                                    <h6><b>Objetivo:</b></h6>     
                                    <select id="objective" name="relacion_ot_objetivo_id" required>
                                        <option value="" hidden>Seleccione</option>
                                        <?php
                                        require_once('conexion.php');
                                        $sql = "SELECT * FROM relacion_o_m INNER JOIN objetivos ON  relacion_o_m.relacion_om_objetivo_id = objetivos.objetivo_id WHERE relacion_om_mtc_id = $id_marca";
                                        if ($resql = $mysqli->query($sql)){
                                            while ($obsql = $resql->fetch_object()){
                                        ?>   
                                        <option value="<?php echo $obsql->objetivo_id.'/'.$obsql->tipo_objetivo; ?>"><?php echo $obsql->nombre_objetivo; ?></option>
                                        <?php
                                            }
                                            $resql->close();
                                        }
                                        ?>
                                    </select>
                                    <br><br>


                                    <br>      
                                    <div class="text-center">
                                        <input  class="btn btn-success btn-rounded" type="submit" name="Editar"   value="Guardar"/>
                                    </div>    
                                    <br>
                                </form>
                            </div> 
                            <?php
                            if(isset($_REQUEST['Editar'])){
                                require_once 'conexion.php'; 

                                $id_tienda = $_GET['id'];


                                $pack_relacion_ot_objetivo_id = explode("/",$_REQUEST['relacion_ot_objetivo_id']);
                                $relacion_ot_objetivo_id = $pack_relacion_ot_objetivo_id[0];
                                $tipo_objetivo = $pack_relacion_ot_objetivo_id[1];

                               
                                $sql = "INSERT INTO relacion_o_t SET
                                relacion_ot_tienda_id = '$id_tienda', 
                                relacion_ot_objetivo_id = '$relacion_ot_objetivo_id'
                                ";
                                $mysqli->query($sql);    
                            ?>
                            <script type="text/javascript">
                                
                                var js = "<?php echo $id; ?>";
                                window.location.assign("tiendas_relacionar_obj.php?id="+js);
                            </script>
                            <?php
                            }
                            ?>

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
        <script>
            $("#objective").select2( {
                placeholder: "Selecciona",
                allowClear: true
            } );
        </script>
    </body>
</html>