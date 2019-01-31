<?php
include_once 'functions/sesiones.php';
include_once 'templates/header.php';
include_once 'templates/navBar.php';
include_once 'templates/sideBar.php';
include_once 'functions/bd_conexion.php';

$id = $_GET['id'];
if (!filter_var($id, FILTER_VALIDATE_INT)) {
    die("Error!");
}

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
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3><i class="fa fa-credit-card"></i> Editar Crédito</h3>
                                Complete el formulario para editar un crédito.
                            </div>

                            <div class="card-body">
                                <form autocomplete="off" role="form" id="form-credito" name="form-credito" method="POST"
                                    action="BLL/credit.php">
                                    <div class="row">
                                        <div class="form-group col-xl-6">
                                            <div class="form-group">
                                                <label for="code">No. de tarjeta<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="code" name="code"
                                                    placeholder="Ingrese el número de la tarjeta" autofocus>
                                            </div>
                                        </div>
                                        <div class="form-group col-xl-6">
                                            <div class="form-group">
                                                <label for="dateStart">Fecha<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="singledatepicker" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="idCollector">
                                            Cobrador <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control select2" id="idCollector" name="idCollector">
                                            <?php
try {
    $sql = "SELECT idCollector, firstName, lastName FROM collector WHERE state = 0 ORDER BY firstName ASC";
    $resultado = $conn->query($sql);
    while ($collector = $resultado->fetch_assoc()) {?>
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
                                        <label for="idCustomer">
                                            Cliente <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control select2" id="idCustomer" name="idCustomer">
                                            <?php
try {
    $sql = "SELECT idCustomer, firstName, lastName,
    (select name from commerce where idCommerce = _idCommerce) as name
     FROM customer WHERE state = 0 ORDER BY firstName ASC";
    $resultado = $conn->query($sql);
    while ($customer = $resultado->fetch_assoc()) {?>
                                            <option value="<?php echo $customer['idCustomer']; ?>">
                                                <?php echo $customer['firstName'] . " " . $customer['lastName'] . ' (' . $customer['name'] . ')'; ?>
                                            </option>
                                            <?php
}
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-xl-6">
                                            <div class="form-group">
                                                <label for="total">Total Q.<span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" id="total" name="total"
                                                    min="300.00" step="0.01" placeholder="Ingrese el total del crédito">
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="credito" value="nuevo">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>
                                        Guardar</button>
                                    <span class="text-danger"> *Debe llenar los campos obligatorios </span>
                                </form>

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