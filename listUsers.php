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
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3><i class="fa fa-users"></i> Listado general de Usuarios</h3>
                            -> Actualmente Activos
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-hover display">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Usuario</th>
                                            <th>Acceso</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
try {
    $sql = "SELECT idUser, firstName, lastName, permissions, userName  FROM user WHERE idUser !=" . $_SESSION['idusuario'] . " AND state = 0;";
    $resultado = $conn->query($sql);
} catch (Exception $e) {
    $error = $e->getMessage();
    echo $error;
}

while ($user = $resultado->fetch_assoc()) {
    ?>
                                        <tr>
                                            <td>
                                                <?php echo $user['firstName'] . " " . $user['lastName']; ?>
                                            </td>
                                            <td>
                                                <?php echo $user['userName']; ?>
                                            </td>
                                            <?php if ($user['permissions'] == '0') {
        ?>
                                            <td>Administrador</td>
                                            <?php
} else if ($user['permissions'] == '1') {
        ?>
                                            <td>Operativo</td>
                                            <?php
} else if ($user['permissions'] == '2') {
        ?>
                                            <td>Consulta</td>
                                            <?php
}?>
                                            <td>
                                                <a href="#" data-id="<?php echo $user['idUser']; ?>" data-tipo="user"
                                                    class="btn btn-outline-danger pull-right borrar_usuario" style="
													margin-left: 5px;"><i
                                                        class="fa fa-trash"></i>
                                                    Eliminar</a>
                                                <a class="btn btn-outline-primary pull-right" href="editUser.php?id=<?php echo $user['idUser']; ?>"><i
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