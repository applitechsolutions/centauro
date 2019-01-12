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
                        <h1 class="main-title float-left">Rutas</h1>
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
                                <h3><i class="fa fa-road"></i> Crear Ruta</h3>
                                Complete el formulario para crear una nueva ruta.
                            </div>

                            <div class="card-body">

                                <form autocomplete="off" role="form" id="form-ruta" name="form-ruta" method="POST"
                                    action="BLL/route.php">
                                    <div class="form-group">
                                        <label for="codeRoute">Código</label>
                                        <input type="text" class="form-control" id="codeRoute" name="codeRoute"
                                            placeholder="Escriba el código de la ruta" autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label for="routeName">Nombre</label>
                                        <input type="text" class="form-control" id="routeName" name="routeName"
                                            placeholder="Escriba el nombre de la ruta">
                                    </div>
                                    <div class="form-group">
                                        <label for="details">Detalles:</label>
                                        <textarea class="form-control" name="details" id="details" cols="100" rows="4" placeholder="Escriba los detalles de la ruta"></textarea>
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
                                                <?php echo $collector['firstName']. " ".$collector['lastName']; ?>
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
                                    <input type="hidden" name="ruta" value="nueva">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
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