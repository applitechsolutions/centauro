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
                        <h1 class="main-title float-left">Ingreso Diario:
                            <?php echo date('d/m/Y'); ?>
                        </h1>
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
                            <h3><i class="fa fa-money"></i> Ingreso de pagos</h3>
                            Complete el formulario para ingresar los pagos ralizados el dia de hoy.
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="date">Fecha<span class="text-danger">*</span></label>
                                        <input type="text" id="date" class="form-control" name="singledatepicker2" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <div class="form-group">
                                        <label for="code">
                                            No. de tarjeta <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control select2" id="code" name="code" autofocus>
                                            <?php
try {
    $sql = "SELECT idCredit, code, (select concat(firstName, ' ', lastName) from customer where idCustomer = _idCustomer) as customer FROM credit WHERE state = 0 AND cancel = 0 ORDER BY code ASC";
    $resultado = $conn->query($sql);
    while ($credit = $resultado->fetch_assoc()) {?>
                                            <option value="<?php echo $credit['idCredit']; ?>">
                                                <?php echo $credit['code'] . " " . $credit['customer']; ?>
                                            </option>
                                            <?php
}
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="amoint">Monto Q.<span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="amount" name="amount" min="1.00"
                                            step="0.01" placeholder="Monto del pago">
                                    </div>
                                </div>
                            </div>
                            <a role="button" href="#" class="btn btn-success btn-sm agregar_diario"><span class="btn-label"><i
                                        class="fa fa-check"></i></span>Agregar</a>
                            <table id="example2" class="table table-responsive-xl table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">No. de tarjeta</th>
                                        <th scope="col">Monto Q.</th>
                                        <th scope="col">Quitar</th>
                                    </tr>
                                </thead>
                                <tbody id="pagos">

                                </tbody>
                            </table>
                        </div>
                    </div><!-- end card-->
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3><i class="fa fa-balance-scale"></i> Totales</h3>
                            Aquí puede consultar el total de ingresos y cantidad de pagos.
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="card-box noradius noborder bg-success">
                                        <i class="fa fa-money float-right text-white"></i>
                                        <h6 class="text-white text-uppercase m-b-20">Ingresos</h6>
                                        <h1 class="m-b-20 text-white counter ingresos">0.00</h1>
                                        <span class="text-white">En Quetzales</span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="card-box noradius noborder bg-dark">
                                        <i class="fa fa-line-chart float-right text-white"></i>
                                        <h6 class="text-white text-uppercase m-b-20">Pagos</h6>
                                        <h1 class="m-b-20 text-white counter pagos">0</h1>
                                        <span class="text-white">Ingresados</span>
                                    </div>
                                </div>
                            </div>
                            <div class="alert alert-info" role="alert">
                                ¡Precione el botón confirmar para guardar los pagos ingresados correctamente!
                            </div>
                            <input type="hidden" name="credito" value="nuevo-historial">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Confirmar</button>
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