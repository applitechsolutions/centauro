<?php
include_once 'functions/sesiones.php';
include_once 'templates/header.php';
include_once 'templates/navBar.php';
include_once 'templates/sideBar.php';
include_once 'functions/bd_conexion.php';
?>

<style>
.daterangepicker {
    z-index: 1151 !important;
}
</style>

<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="breadcrumb-holder">
                        <h1 class="main-title float-left">Créditos</h1>
                        <ol class="breadcrumb float-right">
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        <!-- MODAL BALANCE -->
            <div class="modal fade bd-example-modal-lg" id="balanceC" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="fa fa-balance-scale"></i> Balance de Pagos</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3> Historial <i class="fa fa-history pull-left"></i></h3>
                                Historial de saldos y pagos ingresados.
                            </div>
                            <!-- /.box-header -->
                            <div class="card-body table-responsive">
                                <table id="detallesBC" class="table table-bordered table-hover display">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Tipo</th>
                                            <th>Monto</th>
                                            <th>Saldo</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <!-- /.box-body -->
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3> Anulaciones <i class="fa fa-ban pull-left"></i></h3>
                                Listado de saldos y pagos anulados.
                            </div>
                            <!-- /.box-header -->
                            <div class="card-body table-responsive">
                                <table id="anuladosBC" class="table table-bordered table-hover display">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Tipo</th>
                                            <th>Monto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- MODAL BALANCE -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3><i class="fa fa-credit-card"></i> Listado general de créditos cancelados</h3>
                            -> Aquí puede consultar la infomación de los créditos.
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-hover display">
                                    <thead>
                                        <tr>
                                            <th>No. de tarjeta</th>
                                            <th>Cobrador</th>
                                            <th>Cliente</th>
                                            <th>Dirección</th>
                                            <th>Comercio</th>
                                            <th>Teléfono</th>
                                            <th>Fecha</th>
                                            <th>Total</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- PHP LiSTADO -->
                                        <?php
try {
    $sql = ("SELECT C.idCredit, C.code, (select concat(firstName,' ',lastName) from collector where idCollector = C._idCollector) as collector,
    (select concat(firstName,' ',lastName) from customer where idCustomer = C._idCustomer) as customer,
    (select address from customer where idCustomer = C._idCustomer) as address,
    (select name from commerce where idCommerce = (select _idCommerce from customer where idCustomer = C._idCustomer)) as commerce,
    (select mobile from customer where idCustomer = C._idCustomer) as mobile, C.dateStart, C.total
    FROM credit C WHERE cancel = 1;");

    $resultado = $conn->query($sql);
} catch (Exception $e) {
    $error = $e->getMessage();
    echo $error;
}

while ($credit = $resultado->fetch_assoc()) {
    $fecha = date_create($credit['dateStart']);
    ?>
                                        <!-- PHP LiSTADO -->
                                        <tr>
                                            <td>
                                                <H6>
                                                    <?php echo $credit['code']; ?>
                                                </H6>
                                            </td>
                                            <td>
                                                <STRONg>
                                                    <?php echo $credit['collector']; ?>
                                                </STRONg>
                                            </td>
                                            <td>
                                                <?php echo $credit['customer']; ?>
                                            </td>
                                            <td>
                                                <?php echo $credit['address']; ?>
                                            </td>
                                            <td>
                                                <?php echo $credit['commerce']; ?>
                                            </td>
                                            <td>
                                                <?php echo $credit['mobile']; ?>
                                            </td>
                                            <td>
                                                <H6>
                                                    <?php echo date_format($fecha, 'd/m/Y'); ?>
                                                </H6>
                                            </td>
                                            <td>
                                                <h6>
                                                    <b class="text-success">
                                                        <?php echo 'Q.' . $credit['total']; ?>
                                                    </b>
                                                </h6>
                                            </td>
                                            <td>
                                                <div class="btn-group mr-2" role="group" aria-label="Basic example">
                                                    <a class="btn btn-success detalle_balanceC" hfre="#" data-tipo="listBalance" data-id="<?php echo $credit['idCredit']; ?>"><i class="fas fa-balance-scale"></i>
                                                        Balance</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- FIN PHP LISTADO -->
                                        <?php
}
?>
                                        <!-- FIN PHP LISTADO -->
                                    </tbody>
                                </table>
                            </div>

                        </div>
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