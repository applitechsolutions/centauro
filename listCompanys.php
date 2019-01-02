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
                        <h1 class="main-title float-left">Empresas</h1>
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
                            <h3><i class="fa fa-building"></i> Listado general de Empresas</h3>
                            -> Control de empresas disponibles
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-hover display">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>NIT</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
try {
    $sql = "SELECT * FROM empresa WHERE estado_eliminado = 0 ORDER BY nombre asc;";
    $resultado = $conn->query($sql);
} catch (Exception $e) {
    $error = $e->getMessage();
    echo $error;
}

while ($company = $resultado->fetch_assoc()) {
    ?>
                                        <tr>
                                            <td>
                                                <?php echo $company['nombre']; ?>
                                            </td>
                                            <td>
                                                <?php echo $company['nit']; ?>
                                            </td>
                                            <td>
                                                <a href="#" data-id="<?php echo $company['idEmpresa']; ?>" data-tipo="company"
                                                    class="btn btn-outline-danger pull-right borrar_empresa" style="
													margin-left: 5px;"><i
                                                        class="fa fa-trash"></i>
                                                    Eliminar</a>
                                                <a class="btn btn-outline-primary pull-right" href="editCompany.php?id=<?php echo $company['idEmpresa']; ?>"><i
                                                        class="fa fa-pencil"></i> Editar</a>
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