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
                                                        class="fas fa-address-card"></i> Clientes por vendedor</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#tab_2" data-toggle="tab">Active2</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade" id="tab_1" role="tabpanel">
                                            <form autocomplete="off" role="form" id="form-rpt1" name="form-rpt1"
                                                method="POST" action="BLL/rptCustByCol.php">
                                                <br>
                                                <br>
                                                <div class="form-group">
                                                    <label for="idCollector">
                                                        Cobrador <span class="text-danger">*</span>
                                                    </label>
                                                    <select class="form-control select2" style="width: 15% !important;"
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
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>
                                                    Guardar</button>
                                                <div id="listadoReporte1" class="modal-body">
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