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
                        <h1 class="main-title float-left">Usuarios</h1>
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
                                <h3><i class="fa fa-users"></i> Crear Usuario</h3>
                                Complete el formulario para crear un nuevo usuario.
                            </div>

                            <div class="card-body">

                                <form autocomplete="off" role="form" id="form-usuario" name="form-usuario" method="POST"
                                    action="BLL/user.php">
                                    <div class="form-group">
                                        <label for="userName">Nombre de Usuario<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="userName" name="userName"
                                            placeholder="Escriba el nombre de usuario para iniciar sesión" autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label for="firstName">Nombre<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="firstName" name="firstName"
                                            placeholder="Escriba el nombre del usuario">
                                    </div>
                                    <div class="form-group">
                                        <label for="lastName">Apellido<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="lastName" name="lastName"
                                            placeholder="Escriba el apellido del usuario">
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-xl-6">
                                            <label for="passWord">Contraseña<span class="text-danger">*</span></label>
                                            <input type="password" id="passWord" name="passWord" class="form-control"
                                                aria-describedby="passwordHelpInline"
                                                placeholder="Contraseña del usuario">
                                            <small id="contraseña" class="text-muted">
                                                Debe tener 8-20 caracteres de largo.
                                            </small>
                                        </div>
                                        <div class="form-group col-xl-6">
                                            <label for="confirm_passWord">Confirmar Contraseña<span
                                                    class="text-danger">*</span></label>
                                            <input type="password" id="confirm_passWord" name="confirm_passWord"
                                                class="form-control" aria-describedby="passwordHelpInline"
                                                placeholder="Confirme la contraseña">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">Acceso</label>
                                        <div class="col-sm-10">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="gridRadios"
                                                        id="admin" value="0" checked="">
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
                                            <div class="form-check disabled">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="gridRadios"
                                                        id="consulta" value="2">
                                                    Consulta
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label for="idCollector">
                                            Cobrador <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control select2" style="width: 100% !important;"
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
                                    <br>
                                    <input type="hidden" name="usuario" value="nuevo">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>
                                        Guardar</button>
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