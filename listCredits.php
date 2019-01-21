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
                <div class="col-xl-12">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3><i class="fa fa-vcard"></i> Listado general de créditos</h3>
                            -> Control de clientes disponibles
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-hover display">
                                    <thead>
                                        <tr>
                                            <th>DPI</th>
                                            <th>Nombre</th>
                                            <th>Apellido</th>
                                            <th>Dirección</th>
                                            <th>Teléfono</th>
                                            <th>Teléfono 2</th>
                                            <th>Cobrador</th>
                                            <th>Ruta</th>
                                            <th>Negocio</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                        <!-- PHP LiSTADO -->
                            <?php
                                try {
                                    $sql = ("SELECT C.*, (select concat(codeRoute,' ', routeName) FROM route WHERE idRoute = C._idRoute) as routeName, (select name FROM commerce WHERE idCommerce = C._idCommerce) as comercio,
                                        (SELECT concat(firstName,' ',lastName) from collector where idCollector = (select _idCollector from route where idRoute = C._idRoute)) as nombre
                                        FROM customer C WHERE state = 0;");

                                    $resultado = $conn->query($sql);
                                } catch (Exception $e) {
                                    $error = $e->getMessage();
                                    echo $error;
                                }

                                while ($customer = $resultado->fetch_assoc()) {
                            ?>
                        <!-- PHP LiSTADO -->
                                        <tr>
                                            <td>
                                                <?php echo $customer['DPI']; ?>
                                            </td>
                                            <td>
                                                <?php echo $customer['firstName']; ?>
                                            </td>
                                            <td>
                                                <?php echo $customer['lastName']; ?>
                                            </td>
                                            <td>
                                                <?php echo $customer['address']; ?>
                                            </td>
                                            <td>
                                                <?php echo $customer['mobile']; ?>
                                            </td>
                                            <td>
                                                <?php echo $customer['mobile2']; ?>
                                            </td>
                                            <td>
                                                <?php echo $customer['nombre']; ?>
                                            </td>
                                            <td>
                                                <?php echo $customer['routeName']; ?>
                                            </td>
                                            <td>
                                                <?php echo $customer['comercio']; ?>
                                            </td>
                                            <td>
                                                <a href="#" data-id="<?php echo $customer['idCustomer']; ?>" data-tipo="customer"
                                                    class="btn btn-outline-danger pull-right borrar_cliente" style="
													margin-left: 5px;"><i
                                                        class="fa fa-trash"></i>
                                                    Eliminar</a>
                                                <a class="btn btn-outline-primary pull-right" href="editCustomer.php?id=<?php echo $customer['idCustomer']; ?>"><i
                                                        class="fa fa-pencil"></i> Editar</a>
                                            </td>
                                        </tr>
                        <!-- FIN PHP LISTADO -->
                            <?php 
                                }
                            ?>
                        <!-- FIN PHP LISTADO -->
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