<!-- Left Sidebar -->
<div class="left main-sidebar">

    <div class="sidebar-inner leftscroll">

        <div id="sidebar-menu">

            <ul class="navv">
            <?php
            if ($_SESSION['rol'] == '0') { ?>
                <li class="submenu">
                <a href="index.php"><i class="fa fa-fw fa-area-chart"></i><span> Dashboard </span>
                </a>
                </li>
                <li class="submenu">
                    <a href="newIncome.php"><i class="fa fa-fw fa-money"></i><span> Ingreso diario </span>
                    </a>
                </li>
                <li class="submenu">
                    <a href="#"><i class="fas fa-fw fa-credit-card"></i><span> Créditos </span> <span
                            class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li><a href="listCredits.php"><i class="fa fa-fw fa-list"></i> Ver Activos</a></li>
                        <li><a href="listCreditsC.php"><i class="fa fa-fw fa-list"></i> Ver Cancelados</a></li>
                        <li><a href="newCredit.php"><i class="fa fa-fw fa-handshake-o"></i> Nuevo Crédito</a></li>
                        <li><a href="newhistory.php"><i class="fa fa-fw fa-history"></i> Ingresar Existente</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="fa fa-fw fa-vcard"></i><span> Clientes </span> <span
                            class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li><a href="listCustomers.php"><i class="fa fa-fw fa-list"></i> Ver todos</a></li>
                        <li><a href="newCustomer.php"><i class="fa fa-fw fa-plus-square"></i> Nuevo Cliente</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="fa fa-fw fa-road"></i><span> Rutas </span> <span
                            class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li><a href="listRoutes.php"><i class="fa fa-fw fa-list"></i> Ver todas</a></li>
                        <li><a href="newRoute.php"><i class="fa fa-fw fa-plus-square"></i> Nueva Ruta</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="fa fa-fw fa-automobile"></i><span> Cobradores </span> <span
                            class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li><a href="listCollectors.php"><i class="fa fa-fw fa-list"></i> Ver todos</a></li>
                        <li><a href="newCollector.php"><i class="fa fa-fw fa-plus-square"></i> Nuevo Cobrador</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="fa fa-fw fa-users"></i><span> Usuarios </span> <span
                            class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li><a href="listUsers.php"><i class="fa fa-fw fa-list"></i> Ver todos</a></li>
                        <li><a href="newUser.php"><i class="fa fa-fw fa-plus-square"></i> Nuevo Usuario</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="reports.php"><i class="fas fa-file-alt"></i><span> Reportes </span><span
                            class="menu"></span>
                    </a>
                </li>
            <?php } elseif ($_SESSION['rol'] == '1') { ?>
                <li class="submenu">
                    <a href="#"><i class="fas fa-briefcase"></i><span> Operativos </span><span
                            class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li><a href="listIncomesOp.php"><i class="fa fa-fw fa-list"></i> Ver pagos de hoy </a></li>
                        <li><a href="listCreditsOp.php"><i class="fa fa-fw fa-plus-square"></i> Ingresar pago </a></li>
                    </ul>
                </li>
            <?php } ?>
            </ul>

            <div class="clearfix"></div>

        </div>

        <div class="clearfix"></div>

    </div>

</div>
<!-- End Sidebar -->