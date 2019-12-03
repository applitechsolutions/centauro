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
                        <h1 class="main-title float-left">Usuarios</h1>
                        <ol class="breadcrumb float-right">
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- end row -->
            <?php
$sql = "SELECT firstName, lastName, permissions, userName, _idCollector FROM `user` WHERE `idUser` = $id ";
$resultado = $conn->query($sql);
$user = $resultado->fetch_assoc();
?>

            <div class="row">
                <div class="col-xl-12">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3><i class="fa fa-users"></i> Editar Usuario</h3>
                                Complete el formulario para editar el usuario seleccionado.
                            </div>

                            <div class="card-body">
                                <form autocomplete="off" role="form" id="form-usuario" name="form-usuario" method="post"
                                    action="BLL/user.php">
                                    <div class="form-group">
                                        <label for="firstName">Nombre<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="firstName" name="firstName"
                                            placeholder="Escriba el nombre del usuario"
                                            value="<?php echo $user['firstName']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="lastName">Apellido<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="lastName" name="lastName"
                                            placeholder="Escriba el apellido del usuario"
                                            value="<?php echo $user['lastName']; ?>">
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">Acceso</label>
                                        <div class="col-sm-10">
                                            <?php if ($user['permissions'] == '0') {?>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="gridRadios"
                                                        id="admin" value="0" checked>
                                                    Administrador
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="gridRadios"
                                                        id="operativo" value="1">
                                                    Operativo
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="gridRadios"
                                                        id="consulta" value="2">
                                                    Consulta
                                                </label>
                                            </div>
                                            <?php } elseif ($user['permissions'] == '1') {?>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="gridRadios"
                                                        id="admin" value="0">
                                                    Administrador
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="gridRadios"
                                                        id="operativo" value="1" checked>
                                                    Operativo
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="gridRadios"
                                                        id="consulta" value="2">
                                                    Consulta
                                                </label>
                                            </div>
                                            <?php } elseif ($user['permissions'] == '2') {?>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="gridRadios"
                                                        id="admin" value="0">
                                                    Administrador
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="gridRadios"
                                                        id="operativo" value="1">
                                                    Operativo
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="gridRadios"
                                                        id="consulta" value="2" checked>
                                                    Consulta
                                                </label>
                                            </div>
                                            <?php }?>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label for="idCollector">
                                            Cobrador <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control select2" id="idCollector" name="idCollector">
                                            <?php
try {
    $cobrador_actual = $user['_idCollector'];
    $sql = "SELECT * FROM collector";
    $resultado = $conn->query($sql);
    while ($collector_user = $resultado->fetch_assoc()) {
        if ($collector_user['idCollector'] == $cobrador_actual) {?>
                                            <option value="<?php echo $collector_user['idCollector']; ?>" selected>
                                                <?php echo $collector_user['firstName'] . ' ' . $collector_user['lastName']; ?>
                                            </option>
                                            <?php
} else {?>
                                            <option value="<?php echo $collector_user['idCollector']; ?>">
                                                <?php echo $collector_user['firstName'] . ' ' . $collector_user['lastName']; ?>
                                            </option>
                                            <?php
}
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
                                        </select>
                                    </div>
                                    <br>
                                    <div class="form-group-row">
                                        <input type="hidden" name="usuario" value="editar">
                                        <input type="hidden" name="idUser" value="<?php echo $id; ?>">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>
                                            Guardar</button>
                                        <span class="text-danger"> *Debe llenar los campos obligatorios </span>
                                    </div>
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
?>-