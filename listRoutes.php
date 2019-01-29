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
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3><i class="fa fa-road"></i> Listado general de Rutas</h3>
                            -> Rutas que están actualmente activas
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-hover display">
                                    <thead>
                                        <tr>
                                            <th>Código</th>
                                            <th>Nombre</th>
                                            <th>Detalles</th>
                                            <th>Cobrador</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
try {
    $sql = "SELECT R.*, (select concat(firstName,' ',lastName) from collector where idCollector = R._idCollector) as cobrador FROM route R WHERE R.state = 0 ORDER BY R.codeRoute asc;";
    $resultado = $conn->query($sql);
} catch (Exception $e) {
    $error = $e->getMessage();
    echo $error;
}

while ($route = $resultado->fetch_assoc()) {
    ?>
                                        <tr>
                                            <td>
                                                <?php echo $route['codeRoute']; ?>
                                            </td>
                                            <td>
                                                <?php echo $route['routeName']; ?>
                                            </td>
                                            <td>
                                                <?php echo $route['details']; ?>
                                            </td>
                                            <td>
                                                <?php echo $route['cobrador']; ?>
                                            </td>
                                            <td>
                                                <a href="#" data-id="<?php echo $route['idRoute']; ?>" data-tipo="route"
                                                    class="btn btn-outline-danger pull-right borrar_ruta" style="
													margin-left: 5px;"><i
                                                        class="fa fa-trash"></i>
                                                    Eliminar</a>
                                                <a class="btn btn-outline-primary pull-right" href="editRoute.php?id=<?php echo $route['idRoute']; ?>"><i
                                                        class="fas fa-edit"></i> Editar</a>
                                            </td>
                                        </tr>
                                        <?php }
?>
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