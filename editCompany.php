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
                        <h1 class="main-title float-left">Empresas</h1>
                        <ol class="breadcrumb float-right">
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- end row -->
            <?php
$sql = "SELECT * FROM `empresa` WHERE `idEmpresa` = $id ";
$resultado = $conn->query($sql);
$company = $resultado->fetch_assoc();
?>
            <div class="row">
                <div class="col-xl-12">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3><i class="fa fa-bank"></i> Editar Empresa</h3>
                                Complete el formulario para editar la empresa saleccionada.
                            </div>

                            <div class="card-body">

                                <form autocomplete="off" role="form" id="form-empresa" name="form-empresa" method="POST"
                                    action="BLL/company.php">
                                    <div class="form-group">
                                        <label for="nombre">Nombre<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre de la empresa"
                                            autofocus value="<?php echo $company['nombre']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="nit">Nit<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nit" name="nit" placeholder="Nit de la empresa"
                                            value="<?php echo $company['nit']; ?>">
                                    </div>
                                    <input type="hidden" name="empresa" value="editar">
                                    <input type="hidden" name="idEmpresa" value="<?php echo $id; ?>">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                                    <span class="text-danger"> *Debe llenar los campos obligatorios </span>
                                </form>

                            </div>
                        </div> <!-- end card-->
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