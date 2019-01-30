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
                        <h1 class="main-title float-left">Créditos</h1>
                        <ol class="breadcrumb float-right">
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- end row -->
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
                                            <th>Cobrador</th>
                                            <th>Cliente</th>
                                            <th>Dirección</th>
                                            <th>Comercio</th>
                                            <th>Teléfono</th>
                                            <th>Fecha</th>
                                            <th>Total Q.</th>
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
    FROM credit C WHERE state = 0 AND cancel = 0;");

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
                                                <b class="text-success">
                                                    <?php echo $credit['total']; ?>
                                                </b>
                                            </td>
                                            <td>
                                                <a href="#" data-id="<?php echo $credit['idCredit']; ?>"
                                                    data-tipo="credit" class="btn btn-outline-danger pull-right"
                                                    style="
													margin-left: 5px;"><i class="fa fa-trash"></i>
                                                    Eliminar</a>
                                                <a class="btn btn-outline-primary pull-right"
                                                    href="editCredit.php?id=<?php echo $credit['idCredit']; ?>"><i
                                                        class="fas fa-edit"></i> Editar</a>
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