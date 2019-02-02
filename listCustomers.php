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
                        <h1 class="main-title float-left">Clientes</h1>
                        <ol class="breadcrumb float-right">
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        <!-- MODAL BALANCE -->
            <div class="modal fade bd-example-modal-lg" id="record" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="fa fa-balance-scale"></i> Record Crediticio</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="col-xl-5 pull-left">
                                <div class="card-box noradius noborder bg-success">
                                    <i class="fas fa-percentage float-right text-white"></i>
                                    <h6 class="text-white text-uppercase m-b-20">Record actual:</h6>
                                    <h3 class="m-b-20 text-white counter recordPer">0</h3>
                                    <span class="text-white">En porcentaje</span>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3> Créditos Activos <i class="fa fa-history pull-left"></i></h3>
                                Listado de créditos activos con un mínimo de pagos.
                            </div>
                            <!-- /.box-header -->
                            <div class="card-body table-responsive">
                                <table id="detallesB" class="table table-bordered table-hover display">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Tipo</th>
                                            <th>Monto</th>
                                            <th>Saldo</th>
                                            <th>Acciones</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <!-- /.box-body -->
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3> Cancelados <i class="fa fa-ban pull-left"></i></h3>
                                Listado del record de créditos cancelados.
                            </div>
                            <!-- /.box-header -->
                            <div class="card-body table-responsive">
                                <table id="anuladosB" class="table table-bordered table-hover display">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Tipo</th>
                                            <th>Monto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- MODAL BALANCE -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3><i class="fa fa-vcard"></i> Listado general de clientes</h3>
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
                                                <div class="btn-group mr-3" role="group" aria-label="Basic example">
                                                    <a href="#" data-id="<?php echo $customer['idCustomer']; ?>" data-tipo="customer"
                                                        class="btn btn-danger pull-right borrar_cliente" style="
                                                        margin-left: 5px;"><i
                                                            class="fa fa-trash"></i>
                                                        Eliminar</a>
                                                    <a class="btn btn-primary pull-right" href="editCustomer.php?id=<?php echo $customer['idCustomer']; ?>"><i
                                                            class="fas fa-edit"></i> Editar</a>
                                                    <a class="btn btn-secondary record" href="#" data-tipo="listBalance" data-id="<?php echo $customer['idCustomer']; ?>"><i class="far fa-handshake"></i> Record</a>
                                                </div>
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