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
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3><i class="fa fa-credit-card"></i> Crear Crédito</h3>
                            Complete el formulario para crear un nuevo crédito.
                        </div>

                        <div class="card-body">
                            <form autocomplete="off" role="form" id="form-historial" name="form-historial" method="POST"
                                action="BLL/credit.php">
                                <div class="row">
                                    <div class="form-group col-xl-6">
                                        <div class="form-group">
                                            <label for="code">No. de tarjeta<span class="text-danger">*</span></label>
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
                                    <select class="form-control select2" id="idCollector" name="idCollector"
                                        onchange="listCustomer2();">
                                        <option value="">Seleccione un cobrador</option>
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
                        </div>
                    </div><!-- end card-->
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3><i class="fa fa-money"></i> Historial de pagos</h3>
                            Ingrese los pagos realizados hasta la fecha en orden de la tarjeta.
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="date">Fecha<span class="text-danger">*</span></label>
                                        <input type="text" id="fechapago" class="form-control"
                                            name="singledatepicker2" />
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="monto">Monto Q.<span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="monto" name="monto" min="1.00"
                                            step="0.01" placeholder="Ingrese el monto del pago">
                                    </div>
                                </div>
                            </div>
                            <a role="button" href="#" class="btn btn-success btn-sm agregar_pago"><span
                                    class="btn-label"><i class="fa fa-check"></i></span>Agregar</a>
                            <table id="example2" class="table table-responsive-xl table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Monto Q.</th>
                                        <th scope="col">Quitar</th>
                                    </tr>
                                </thead>
                                <tbody id="agregados">

                                </tbody>
                            </table>
                            <br>
                            <input type="hidden" name="credito" value="nuevo-historial">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                            <span class="text-danger"> *Debe llenar los campos obligatorios </span>
                            </form>
                        </div>
                    </div><!-- end card-->
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