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
                        <h1 class="main-title float-left">Dashboard</h1>
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item">Home</li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- end row -->
            <!-- PHP -->
            <?php
$sql = "SELECT SUM(total) as capital FROM credit WHERE cancel = 0";
$resultado = $conn->query($sql);
$capital = $resultado->fetch_assoc();
?>
            <!-- PHP -->
            <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                    <div class="card-box noradius noborder bg-success">
                        <i class="fas fa-piggy-bank float-right text-white"></i>
                        <h6 class="text-white text-uppercase m-b-20">Capital</h6>
                        <h3 class="m-b-20 text-white counter"><?php echo number_format($capital['capital'], 2, '.', ','); ?></h3>
                        <span class="text-white">Total Invertido </span>
                    </div>
                </div>

                <!-- PHP -->
                <?php
$sql = "SELECT SUM((SELECT balance FROM balance WHERE _idCredit = idCredit ORDER BY idBalance DESC LIMIT 1)) as faltante, SUM((SELECT balance FROM balance WHERE _idCredit = idCredit ORDER BY idBalance ASC LIMIT 1)) as recaudado FROM credit WHERE cancel = 0";
$resultado = $conn->query($sql);
$faltante = $resultado->fetch_assoc();
?>
                <!-- PHP -->

                <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                    <div class="card-box noradius noborder bg-warning">
                        <i class="fas fa-coins float-right text-white"></i>
                        <h6 class="text-white text-uppercase m-b-20">Por Recaudar</h6>
                        <h3 class="m-b-20 text-white counter"><?php echo number_format($faltante['faltante'], 2, '.', ','); ?></h3>
                        <span class="text-white">Dinero faltante</span>
                    </div>
                </div>

                <!-- PHP -->
                <?php
$cobrado = $faltante['recaudado'] - $faltante['faltante'];
?>
                <!-- PHP -->

                <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                    <div class="card-box noradius noborder bg-primary">
                        <i class="fas fa-hand-holding-usd float-right text-white"></i>
                        <h6 class="text-white text-uppercase m-b-20">Recaudado</h6>
                        <h3 class="m-b-20 text-white counter"><?php echo number_format($cobrado, 2, '.', ','); ?></h3>
                        <span class="text-white">Dinero recuperado</span>
                    </div>
                </div>

                <!-- PHP -->
                <?php
$sql = "SELECT COUNT(*) as total FROM credit WHERE cancel = 0";
$resultado = $conn->query($sql);
$creditos = $resultado->fetch_assoc();
?>
                <!-- PHP -->
                <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                    <div class="card-box noradius noborder bg-secondary">
                        <i class="fas fa-list-ol float-right text-white"></i>
                        <h6 class="text-white text-uppercase m-b-20">Créditos activos</h6>
                        <h3 class="m-b-20 text-white counter"><?php echo $creditos['total']; ?></h3>
                        <span class="text-white">Total de Créditos Activos</span>
                    </div>
                </div>
            </div>
            <!-- end row -->
            <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                <label for="idCollector">
                    Cobrador
                </label>
                <select class="form-control select2" id="dashCollector" name="idCollector">
                    <option value="" selected>Seleccione un cobrador</option>
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
            <br>
            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10">
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fa fa-table"></i> Movimientos mensuales por cobrador
                        </div>

                        <div class="card-body">
                            <canvas id="comboBarLineChart"></canvas>
                        </div>
                        <div class="card-footer small text-muted">Dinero en Quetzales / meses - <?php echo date("Y"); ?>
                        </div>
                    </div><!-- end card-->
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- END container-fluid -->

    </div>
    <!-- END content -->

</div>
<!-- END content-page -->
<?php
include_once 'templates/footer.php';
?>

<script>
// comboBarLineChart
</script>