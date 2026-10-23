<?php include('pass.php');?>
<!DOCTYPE html>
<html lang="en">
    <?php include('cabecera_panel.php'); ?>
    <style>
        .dow-clickable{
            cursor: pointer;
        }
        .non-clickable{
            cursor: pointer;
            background-color:#e7e7e7 !important;
            opacity:.5;
        }
        .day {
            font-weight: 900;
        }

        div.zabuto_calendar .table tr.calendar-dow-header th {
            background-color:#111c43;
        }    
    </style>
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
                                <br><br>
                                <a href="rol_maestro_alta_cliente.php" class="btn btn-success btn-rounded" ><i class="fa fa-plus-circle m-r-5"></i> Crear Visita</a>
                                <br><br>   
                            </div>    
                           
                            <button style="background-color:#129fd620;border:0;padding-left:15px;padding-right:15px;padding-bottom:10px;padding-top:5px"><span style="font-size: 0.95em;padding-left: 8px;padding-right: 8px;padding-bottom: 4px;  background-color: #129fd6; color: #ffffff;text-shadow: none;">Con Actividades</span></button>
                        
                            <div id="calendar" style="width:100%"></div>

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
        <script type="text/javascript" src="js/zabuto_calendar.js"></script>
        <script>
            $(document).ready(function () {
                $('#calendar').zabuto_calendar({
                    ajax: {
                        url: "show_data.php",
                        modal: false
                    },
                    action: function () {
                        var date = $("#" + this.id).data("date");
                        var tieneEventos = $("#" + this.id).data("hasEvent");

                        if(tieneEventos == true){
                            window.location.assign('consultar.php?fecha_inicial='+date+'&fecha_final='+date);
                        }else{
                            //valido solo si es mayor o igual a hoy
                            var hoy = new Date();      

                            //si es mayor a este mes
                            if (hoy.getMonth() < new Date(date).getMonth()){
                                window.location.assign('rol_maestro_alta_cliente.php?fecha='+date);
                            }else if (hoy.getMonth() == new Date(date).getMonth()){
                                if( (hoy.getDate() < new Date(date).getDate()+2)){    
                                    window.location.assign('rol_maestro_alta_cliente.php?fecha='+date);
                                }
                            }   
    
                        }
                    },
                    cell_border: true,
                    show_days: true,
                    language: "es",
                    show_previous: false,
                    today: true,
                    nav_icon: {
                        prev: '<i class="fa fa-arrow-left"></i>',
                        next: '<i class="fa fa-arrow-right"></i>'
                    }});
            });
        </script>
    </body>
</html>