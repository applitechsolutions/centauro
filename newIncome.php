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
                            <form autocomplete="off" role="form" id="form-diario" name="form-diario" method="POST"
                                action="BLL/credit.php">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="date">Fecha<span class="text-danger">*</span></label>
                                            <input type="text" id="date" class="form-control"
                                                name="singledatepicker2" />
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="code">
                                                Cobrador <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2" id="collector" name="collector"
                                                onchange="listCustomer();">
                                                <option value="">Seleccione un cobrador</option>
                                                <?php
try {
    $sql = "SELECT idCollector, concat(firstName, ' ', lastName) as collector FROM collector WHERE state = 0";
    $resultado = $conn->query($sql);
    while ($collector = $resultado->fetch_assoc()) {?>
                                                <option value="<?php echo $collector['idCollector']; ?>">
                                                    <?php echo $collector['collector']; ?>
                                                </option>
                                                <?php
}
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
                                            </select>
                                        </div>
                                    </div>.
                                </div>
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label for="code">
                                                No. de tarjeta <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2" id="code" name="code" autofocus>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="amoint">Monto Q.<span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="amount" name="amount"
                                                min="1.00" step="0.01" placeholder="Monto del pago">
                                        </div>
                                    </div>
                                </div>
                                <a role="button" href="#" class="btn btn-success btn-sm agregar_diario"><span
                                        class="btn-label"><i class="fa fa-check"></i></span>Agregar</a>
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
                                        <h2 class="m-b-20 text-white counter ingresos">0.00</h2>
                                        <span class="text-white">En Quetzales</span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="card-box noradius noborder bg-secondary">
                                        <i class="fa fa-line-chart float-right text-white"></i>
                                        <h6 class="text-white text-uppercase m-b-20">Pagos</h6>
                                        <h2 class="m-b-20 text-white counter pagos">0</h2>
                                        <span class="text-white">Ingresados</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card-box noradius noborder bg-dark">
                                        <i class="fas fa-money-bill-wave float-right text-white"></i>
                                        <h6 class="text-white text-uppercase m-b-20">Efectivo</h6>
                                        <h2 class="m-b-20 text-white counter efectivo">0.00</h2>
                                        <span class="text-white">Total entregado</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card-box noradius noborder bg-primary">
                                        <i class="fas fa-credit-card float-right text-white"></i>
                                        <h6 class="text-white text-uppercase m-b-20">Créditos</h6>
                                        <h2 class="m-b-20 text-white counter creditos">0.00</h2>
                                        <span class="text-white">Ingresados hoy</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="base">Base<span class="text-danger">*</span></label>
                                        <input type="text" id="base" class="form-control" name="base" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exes">Gastos<span class="text-danger">*</span></label>
                                        <input type="text" id="exes" class="form-control" name="exes" />
                                    </div>
                                </div>
                            </div>
                            <div class="alert alert-info" role="alert">
                                ¡Precione el botón confirmar para guardar los pagos ingresados correctamente!
                            </div>
                            <input type="hidden" name="credito" value="nuevo-ingreso">
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