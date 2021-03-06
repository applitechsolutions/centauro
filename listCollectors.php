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
                        <h1 class="main-title float-left">Cobradores</h1>
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
                            <h3><i class="fa fa-automobile"></i> Listado general de Cobradores</h3>
                            -> Control de cobradores disponibles
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-hover display">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Apellido</th>
                                            <th>DPI</th>
                                            <th>Dirección</th>
                                            <th>Teléfono</th>
                                            <th>Fecha de Nacimiento</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
    try {
        $sql = "SELECT * FROM collector WHERE state = 0 ORDER BY firstName ASC;";
        $resultado = $conn->query($sql);
    } catch (Exception $e) {
        $error = $e->getMessage();
        echo $error;
    }

    while ($collector = $resultado->fetch_assoc()) {
        $fecha = date_create($collector['birthDate']);
?>
                                        <tr>
                                            <td>
                                                <?php echo $collector['firstName']; ?>
                                            </td>
                                            <td>
                                                <?php echo $collector['lastName']; ?>
                                            </td>
                                            <td>
                                                <?php echo $collector['DPI']; ?>
                                            </td>
                                            <td>
                                                <?php echo $collector['address']; ?>
                                            </td>
                                            <td>
                                                <?php echo $collector['mobile']; ?>
                                            </td>
                                            <td>
                                                <?php echo date_format($fecha, 'd/m/Y'); ?>
                                            </td>
                                            <td>
                                                <a href="#" data-id="<?php echo $collector['idCollector']; ?>" data-tipo="collector"
                                                    class="btn btn-outline-danger pull-right borrar_cobrador" style="
													margin-left: 5px;"><i
                                                        class="fa fa-trash"></i>
                                                    Eliminar</a>
                                                <a class="btn btn-outline-primary pull-right" href="editCollector.php?id=<?php echo $collector['idCollector']; ?>"><i
                                                        class="fas fa-edit"></i> Editar</a>
                                            </td>
                                        </tr>
                                        <?php }?>
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