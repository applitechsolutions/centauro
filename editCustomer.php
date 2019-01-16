<?php
include_once 'functions/sesiones.php';
include_once 'templates/header.php';
include_once 'templates/navBar.php';
include_once 'templates/sideBar.php';
include_once 'functions/bd_conexion.php';

$id = $_GET['id'];
if (!filter_var($id, FILTER_VALIDATE_INT)) {
    die("Error!");
}

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
        <!-- Modal Negocio -->
            <div class="modal fade custom-modal" id="ModalCommerce" tabindex="-1" role="dialog" aria-labelledby="customModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">Nuevo Negocio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" id="form-commerce" name="form-commerce" method="post" action="BLL/commerce.php">
                            <div class="form-group">
                                <span class="text-danger text-uppercase">*</span>
                                <label for="nameCommerce">Nombre</label>
                                <input type="text" class="form-control" id="nameCommerce" name="nameCommerce" placeholder="Escriba el nombre del negocio" autofocus>
                                <input type="hidden" name="commerce" value="nuevo">
                            </div>
                    </div>
                    <div class="modal-footer">
                            <button type="button" id="comClose" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"> Guardar</i></button>
                        </form>
                    </div>
                </div>
                </div>
            </div>
        <!-- Modal Negocio -->
<?php
    $sql = "SELECT * FROM `customer` WHERE `idCustomer` = $id ";
    $resultado = $conn->query($sql);
    $customer = $resultado->fetch_assoc();
?>
            <div class="row">
                <div class="col-xl-12">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3><i class="fa fa-vcard"></i> Editar Cliente</h3>
                                Complete el formulario para modificar un cliente.
                            </div>
                            <div class="card-body">
                                <form autocomplete="off" role="form" id="form-cliente" name="form-cliente" method="POST" action="BLL/customer.php">
                                    <div class="form-group">
                                        <label for="dpiCustomer">DPI</label>
                                        <input type="text" class="form-control" id="dpiCustomer" name="dpiCustomer" placeholder="Escriba el dpi del cliente" value="<?php echo $customer['DPI']; ?>" autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label for="nameCustomer">Nombre<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nameCustomer" name="nameCustomer" placeholder="Escriba el nombre del cliente" value="<?php echo $customer['firstName']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="lastCustomer">Apellido<span class="text-danger">*</span></label>
                                        <input class="form-control" id="lastCustomer" name="lastCustomer" placeholder="Escriba el apellido del cliente" value="<?php echo $customer['lastName']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="addressCustomer">Dirección</label>
                                        <input class="form-control" id="addressCustomer" name="addressCustomer" placeholder="Escriba la dirección del cliente" value="<?php echo $customer['address']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="mob1Customer">Teléfono 1</label>
                                        <input class="form-control" id="mob1Customer" name="mob1Customer" placeholder="Escriba el teléfono del cliente" value="<?php echo $customer['mobile']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="mob2Customer">Teléfono 2</label>
                                        <input class="form-control" id="mob2Customer" name="mob2Customer" placeholder="Escriba el teléfono del cliente" value="<?php echo $customer['mobile2']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="_idRoute">Ruta<span class="text-danger">*</span></label>
                                        <select class="form-control select2" id="_idRoute" name="_idRoute">
                                            <option value="" selected>Seleccione una ruta</option>
                        <!-- PHP LISTAR RUTA ACTUAL -->
                            <?php
                                try {
                                    $ruta_actual =  $customer['_idRoute'];
                                    $sql = "SELECT * FROM route";
                                    $resultado = $conn->query($sql);
                                    while ($ruta_customer = $resultado->fetch_assoc()) {
                                        if ($ruta_customer['idRoute'] == $ruta_actual) {
                            ?>
                        <!-- PHP LISTAR RUTA ACTUAL -->
                                            <option value="<?php echo $ruta_customer['idRoute']; ?>" selected>
                                            <?php echo $ruta_customer['routeName']; ?>
                                            </option>
                                <!-- PHP ELSE -->
                                    <?php 
                                        } else {
                                    ?>
                                <!-- PHP ELSE -->
                                            <option value="<?php echo $ruta_customer['idRoute']; ?>">
                                            <?php echo $ruta_customer['routeName']; ?>
                                            </option>
                        <!-- FINAL PHP -->
                            <?php
                                        }
                                    }
                                }catch (Exception $e) {
                                    echo "Error: " . $e->getMessage();
                                }
                            ?>
                        <!-- FINAL PHP -->
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="_idCommerce">Negocio<span class="text-danger">*</span></label>
                                        <button type="button" class="btn btn-link bg-teal-active btn-xs" data-target="#ModalCommerce" data-toggle="modal"><i class="fa fa-plus"></i></button>
                                        <select class="form-control select2" id="_idCommerce" name="_idCommerce">
                                            <option value="" selected>Seleccione un negocio</option>
                        <!-- PHP LISTAR NEGOCIO ACTUAL -->
                            <?php
                                try {
                                    $negocio_actual =  $customer['_idCommerce'];
                                    $sql = "SELECT * FROM commerce";
                                    $resultado = $conn->query($sql);
                                    while ($negocio_customer = $resultado->fetch_assoc()) {
                                        if ($negocio_customer['idCommerce'] == $negocio_actual) {
                            ?>
                        <!-- PHP LISTAR NEGOCIO ACTUAL -->
                                            <option value="<?php echo $negocio_customer['idCommerce']; ?>" selected>
                                            <?php echo $negocio_customer['name']; ?>
                                            </option>
                                <!-- PHP ELSE -->
                                    <?php 
                                        } else {
                                    ?>
                                <!-- PHP ELSE -->
                                            <option value="<?php echo $negocio_customer['idCommerce']; ?>">
                                            <?php echo $negocio_customer['name']; ?>
                                            </option>
                        <!-- FINAL PHP -->
                            <?php
                                        }
                                    }
                                }catch (Exception $e) {
                                    echo "Error: " . $e->getMessage();
                                }
                            ?>
                        <!-- FINAL PHP -->
                                        </select>
                                    </div>
                                    <br>
                                    <input type="hidden" name="idCustomer" value="<?php echo $id; ?>">
                                    <input type="hidden" name="cliente" value="editar">
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