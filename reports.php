<?php
include_once 'functions/sesiones.php';
include_once 'templates/header.php';
include_once 'templates/navBar.php';
include_once 'templates/sideBar.php';
include_once 'functions/bd_conexion.php';
?>

<div class="content-page">

    <!-- Start content -->
    <div class="content">

        <div class="container-fluid">


            <div class="row">
                <div class="col-xl-12">
                    <div class="breadcrumb-holder">
                        <h1 class="main-title float-left">Reportes</h1>
                        <ol class="breadcrumb float-right">
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        <!-- Modal REPORTE -->
            <div class="modal fade custom-modal" id="ModalReporte" tabindex="-1" role="dialog" aria-labelledby="customModal" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">Reporte</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <div id="divreporte" class="w3-rest">
                            <iframe src="" style="width: 100%; height: 700px; min-width: 300px;"></iframe>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        <!-- Modal REPORTE -->

            <div class="row">
                <div class="col-xl-12">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3><i class="fas fa-file-alt"></i> Reportes</h3>
                                Aquí puede generar los reportes necesarios.
                            </div>

                            <div class="card-body">
                                <div class="card text-center">
                                    <div class="card-header">
                                        <ul class="nav nav-tabs card-header-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link" href="#tab_1" data-toggle="tab"><i
                                                        class="fas fa-address-card"></i> Clientes por cobrador</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#tab_2" data-toggle="tab"><i
                                                        class="fas fa-user-check"></i> Créditos terminados por cobrador</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#tab_3" data-toggle="tab"><i
                                                        class="far fa-money-bill-alt"></i> Ingresos por fecha</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade" id="tab_1" role="tabpanel">
                                        <br>
                                            <h4 class="box-title">Listado de clientes con saldo pendiente
                                                </h4>
                                            <form autocomplete="off" role="form" id="form-rpt1" name="form-rpt1"
                                                method="POST" action="BLL/rptCustByCol.php">
                                                <br>
                                                <div class="row">
                                                <div class="form-group col-xl-2">
                                                    <label for="idCollector">
                                                        Cobrador <span class="text-danger">*</span>
                                                    </label>
                                                    <select class="form-control select2 pull-right" style="width: 100% !important;"
                                                        id="idCollector" name="idCollector">
                                                        <option value="">Seleccione cobrador</option>
                                                        <?php
try {
    $sql = "SELECT idCollector, firstName, lastName FROM collector WHERE state = 0 ORDER BY firstName ASC";
    $resultado = $conn->query($sql);
    while ($collector = $resultado->fetch_assoc()) {
        ?>
                                                        <option value="<?php echo $collector['idCollector']; ?>">
                                                            <?php echo $collector['firstName'] . " " . $collector['lastName']; ?>
                                                        </option>
                                                        <?php
}
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-xl-6">
                                                <br>
                                                <button type="submit" class="btn btn-primary pull-left"><i class="fab fa-rev"></i>
                                                    Generar Listado</button>
                                                </div>
                                                <div class="form-group col-xl-3">
                                                    <div class="card-box noradius noborder bg-info">
                                                        <i class="fas fa-money-bill-alt float-right text-white"></i>
                                                        <h6 class="text-white text-uppercase m-b-20">Total Por Recaudar:</h6>
                                                        <h3 class="m-b-20 text-white counter totalCustomer">0.00</h3>
                                                        <span class="text-white">En Quetzales</span>
                                                    </div>
                                                </div>
                                                </div>
                                                <div id="listadoReporte1" class="modal-body">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="tab_2" role="tabpanel">
                                        <br>
                                            <h4 class="box-title">Listado de créditos terminados en un rango de fechas
                                                </h4>
                                            <form autocomplete="off" role="form" id="form-rpt2" name="form-rpt2"
                                                method="POST" action="BLL/rptCredits.php">
                                                <br>
                                                <div class="row">
                                                <div class="form-group col-xl-2">
                                                    <label for="idCollector">
                                                        Cobrador <span class="text-danger">*</span>
                                                    </label>
                                                    <select class="form-control select2 pull-right" style="width: 100% !important;"
                                                        id="idCollectorRPT2" name="idCollectorRPT2">
                                                        <option value="">Seleccione cobrador</option>
                                                        <?php
try {
    $sql = "SELECT idCollector, firstName, lastName FROM collector WHERE state = 0 ORDER BY firstName ASC";
    $resultado = $conn->query($sql);
    while ($collector = $resultado->fetch_assoc()) {
        ?>
                                                        <option value="<?php echo $collector['idCollector']; ?>">
                                                            <?php echo $collector['firstName'] . " " . $collector['lastName']; ?>
                                                        </option>
                                                        <?php
}
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="date">Fecha Inicial<span class="text-danger">*</span></label>
                                                    <input type="text" id="date" class="form-control"
                                                        name="singledatepicker" />
                                                </div>
                                                <div class="form-group">
                                                    <label for="date">Fecha Final<span class="text-danger">*</span></label>
                                                    <input type="text" id="date2" class="form-control"
                                                        name="singledatepicker2" />
                                                </div>
                                                <div class="form-group col-xl-6">
                                                <br>
                                                <button type="submit" class="btn btn-primary pull-left"><i class="fab fa-rev"></i>
                                                    Generar Listado</button>
                                                </div>
                                                </div>
                                                <div id="listadoReporte2" class="modal-body">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="tab_3" role="tabpanel">
                                        <br>
                                            <h4 class="box-title">Listado de ingresos en una fecha determinada por cobrador
                                                </h4>
                                            <form autocomplete="off" role="form" id="form-rpt3" name="form-rpt3"
                                                method="POST" action="BLL/rptIncomesByColl.php">
                                                <br>
                                                <div class="row">
                                                <div class="form-group col-xl-2">
                                                    <label for="idCollector">
                                                        Cobrador <span class="text-danger">*</span>
                                                    </label>
                                                    <select class="form-control select2 pull-right" style="width: 100% !important;"
                                                        id="idCollectorRPT2" name="idCollectorRPT3">
                                                        <option value="">Seleccione cobrador</option>
                                                        <?php
try {
    $sql = "SELECT idCollector, firstName, lastName FROM collector WHERE state = 0 ORDER BY firstName ASC";
    $resultado = $conn->query($sql);
    while ($collector = $resultado->fetch_assoc()) {
        ?>
                                                        <option value="<?php echo $collector['idCollector']; ?>">
                                                            <?php echo $collector['firstName'] . " " . $collector['lastName']; ?>
                                                        </option>
                                                        <?php
}
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-xl-2">
                                                    <label for="date">Fecha Inicial<span class="text-danger">*</span></label>
                                                    <input type="text" id="date" class="form-control"
                                                        name="singledatepicker" />
                                                </div>
                                                <div class="form-group col-xl-2">
                                                <br>
                                                <button type="submit" class="btn btn-primary pull-left"><i class="fab fa-rev"></i>
                                                    Generar Listado</button>
                                                </div>
                                                <div class="form-group col-xl-3">
                                                    <div class="card-box noradius noborder bg-info">
                                                        <i class="fas fa-money-bill-alt float-right text-white"></i>
                                                        <h6 class="text-white text-uppercase m-b-20">Total Ingresos:</h6>
                                                        <h3 class="m-b-20 text-white counter totalIncomes">0.00</h3>
                                                        <span class="text-white">En Quetzales</span>
                                                    </div>
                                                </div>
                                                <div id="listadoReporte3" class="modal-body">
                                                    <div class="card-body table-responsive">
                                                        <table id="example1" class="table table-bordered table-hover display">
                                                            <thead>
                                                                <tr>
                                                                    <th>No. Tarjeta</th>
                                                                    <th>Fecha Inicio</th>
                                                                    <th>Cliente</th>
                                                                    <th>Comercio</th>
                                                                    <th>Total (Q.)</th>
                                                                    <th>Pago (Q.)</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                        <!-- /.box-body -->
                                                    </div>
                                                    <div class="row">
                                                        <button type="button" onclick="printReport3()" class="btn bg-teal-active btn-md"><i class="fas fa-print"></i>
                                                        Imprimir</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- end card-->
                    </div>
                </div>
            </div>

        </div>
        <!-- END container-fluid -->

    </div>
    <!-- END content -->

</div>
<!-- END content-page -->

<?php
include_once 'templates/footer.php';
?>