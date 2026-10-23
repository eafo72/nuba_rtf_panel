<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <br>
        <div class="nav">
            <?php
            if ($_SESSION['permisos'] == "Cliente") {
                ?>
                <a class="nav-link" href="admin.php">
                    <div class="sb-nav-link-icon"><i class="fa-regular fa-folder"></i></div>
                    DashBoard
                </a>

                <a class="nav-link" href="calendario.php">
                    <div class="sb-nav-link-icon"><i class="fa-regular fa-calendar"></i></div>
                    Calendario
                </a>

                <a class="nav-link" href="consultar.php">
                    <div class="sb-nav-link-icon"><i class="fa-regular fa-chart-bar"></i></div>
                    Consultar Visitas
                </a>

                <a class="nav-link" href="promotores.php">
                    <div class="sb-nav-link-icon"><i class="fa-regular fa-lightbulb"></i></div>
                    Actividad por Técnico
                </a>

                <a class="nav-link" href="colaboradores_panel.php">
                    <div class="sb-nav-link-icon"><i class="fa-regular fa-thumbs-up"></i></div>
                    Técnicos
                </a>

                <a class="nav-link" href="viaticos_panel.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-car"></i></div>
                    Viáticos
                </a>

                <a class="nav-link" href="tiendas_panel.php">
                    <div class="sb-nav-link-icon"><i class="fa-regular fa-face-smile"></i></div>
                    Clientes
                </a>

               

                <?php
            }
            ?>


            <?php
            if ($_SESSION['permisos'] == "Administrador") {
                ?>

                <a class="nav-link" href="asistencia.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-redo"></i></div>
                    Asistencia
                </a>

                <a class="nav-link" href="calendario.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-calendar"></i></div>
                    Calendario
                </a>

                <a class="nav-link" href="consultar.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Consultar Visitas
                </a>

                <a class="nav-link" href="promotores.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Actividad por Técnico
                </a>

                <a class="nav-link" href="colaboradores_panel.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-wrench"></i></div>
                    Técnicos
                </a>

                <a class="nav-link" href="viaticos_panel.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-car"></i></div>
                    Viáticos
                </a>

                <a class="nav-link" href="tiendas_panel.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-map-marker-alt"></i></div>
                    Clientes
                </a>


                <a class="nav-link" href="estados_cuenta_panel.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-edit"></i></div>
                    Estados de Cuenta
                </a>

                <a class="nav-link" href="pagos_alta.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-money-bill"></i></div>
                    Registrar Pago
                </a>

                <a class="nav-link" href="descuentos_panel.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-money-bill"></i></div>
                    Códigos de descuento
                </a>


                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#objetives" aria-expanded="false"
                    aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-bullseye"></i></div>
                    Objetivos
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="objetives" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="objetivo_panel.php">Catálogo</a>
                        <a class="nav-link" href="elementos_panel.php">Elementos</a>
                    </nav>
                </div>

                <a class="nav-link" href="marcas_panel.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-tie"></i></div>
                    Empresas
                </a>

                <!-- Roles -->
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#role" aria-expanded="false"
                    aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-edit"></i></div>
                    Roles
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="role" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="rol_maestro_panel.php">Rol Maestro</a>
                        <a class="nav-link" href="rol_main_panel.php">Crear Roles</a>
                    </nav>
                </div>

                <!-- Paquetes -->
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#paquetes" aria-expanded="false"
                    aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-edit"></i></div>
                    Paquetes
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="paquetes" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="paquetes_panel.php">Paquetes</a>
                        <a class="nav-link" href="paquetes_clientes_actuales.php">Clientes</a>
                        <a class="nav-link" href="paquetes_clientes_historial.php">Historial</a>
                    </nav>
                </div>


                <a class="nav-link" href="usuarios.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Usuarios
                </a>
                <?php
            }
            ?>



            <a class="nav-link" href="contacto_panel.php">
                <div class="sb-nav-link-icon"><i class="fa-regular fa-envelope"></i></div>
                Soporte
            </a>
            <!--
            <a class="nav-link" href="ventas_panel.php"><div class="sb-nav-link-icon"><i class="fas fa-money-bill"></i></div>
                Ventas</a>
            -->

        </div>
    </div>
    <div class="sb-sidenav-footer">
        <div class="small">Ingresaste como:</div>
        <?php
        if($_SESSION['permisos'] == "Cliente"){
            echo "Admin";
        }else{
            echo $_SESSION['permisos'];
        }
        ?>
    </div>
</nav>