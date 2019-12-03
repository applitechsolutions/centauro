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
            <div class="modal fade bd-example-modal-lg" id="balance" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="fa fa-balance-scale"></i> Balance de Saldos</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form role="form" id="form-pay" name="form-pay" method="post" action="BLL/balance.php">
                                <div class="col-xl-5 pull-left">
                                    <div class="card-box noradius noborder bg-success">
                                        <i class="fa fa-money float-right text-white"></i>
                                        <h6 class="text-white text-uppercase m-b-20">Saldo actual:</h6>
                                        <h3 class="m-b-20 text-white counter totalBal">0.00</h3>
                                        <span class="text-white">En Quetzales</span>
                                    </div>
                                </div>
                                <div class="col-xl-7 pull-right">
                                    <h6>Ingreso de pagos: </h6><br>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="fecha">Fecha<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="fechaBalance"
                                                    name="singledatepicker">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="monto">Monto<span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" id="amountPay" name="amountPay"
                                                    min="0.00" step="0.01" placeholder="Ingrese un monto">
                                            </div>
                                            <input type="hidden" name="tipo" value="pago">
                                            <input type="hidden" id="idCredito" name="idCredito" value="0">
                                            <input type="hidden" id="totalB" name="totalB" value="0">
                                            <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i>
                                                Guardar</button><br>
                                            <span class="text-danger pull-right"> *Debe llenar los campos obligatorios </span>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3> Historial <i class="fa fa-history pull-left"></i></h3>
                                Historial de saldos y pagos ingresados.
                            </div>
                            <!-- /.box-header -->
                            <div class="card-body table-responsive">
                                <table id="detallesB" class="table table-bordered table-hover display">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Tipo</th>
                                            <th>Monto</th>
                                            <th>Saldo</th>
                                            <th>Acciones</th>
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
                                Listado de pagos anulados.
                            </div>
                            <!-- /.box-header -->
                            <div class="card-body table-responsive">
                                <table id="anuladosB" class="table table-bordered table-hover display">
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
                        </form>
                    </div>
                </div>
            </div>
        <!-- MODAL BALANCE -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3><i class="fa fa-credit-card"></i> Listado general de créditos activos</h3>
                            -> Aquí puede consultar la infomación de los créditos.
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-hover display">
                                    <thead>
                                        <tr>
                                            <th>No. de tarjeta</th>
                                            <th>Cliente</th>
                                            <th>Fecha</th>
                                            <th>No. Pagos</th>
                                            <th>Total</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- PHP LiSTADO -->
                                        <?php
try {
    $sql = ("SELECT C.idCredit, C.code,
    (SELECT COUNT(idBalance) FROM balance WHERE _idCredit = C.idCredit AND state = 0 AND balpay = 1) as pagos,
    (select concat(firstName,' ',lastName) from customer where idCustomer = C._idCustomer) as customer,
    C.dateStart, C.total FROM credit C WHERE cancel = 0;");

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
                                                <?php echo $credit['customer']; ?>
                                            </td>
                                            <td>
                                                <H6>
                                                    <?php echo date_format($fecha, 'd/m/Y'); ?>
                                                </H6>
                                            </td>
                                            <td>
                                                <h6>
                                                    <b class="text-success">
                                                        <?php echo $credit['pagos']; ?>
                                                    </b>
                                                </h6>
                                            </td>
                                            <td>
                                                <h6>
                                                    <b class="text-success">
                                                        <?php echo 'Q.' . $credit['total']; ?>
                                                    </b>
                                                </h6>
                                            </td>
                                            <td>
                                                <div class="btn-group mr-3" role="group" aria-label="Basic example">
                                                    <a class="btn btn-success detalle_balance" hfre="#" data-tipo="listBalance" data-id="<?php echo $credit['idCredit']; ?>"><i class="fas fa-balance-scale"></i>
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