<?php

if (isset($_POST['ingresar'])) {
    $usuario = $_POST['username'];
    $password = $_POST['password'];

    //die(json_encode($_POST));

    try {
        include_once '../functions/bd_conexion.php';
        $stmt = $conn->prepare("SELECT idUsuario, nombre, apellido, usuario, contraseña, acceso, estado FROM usuario WHERE usuario = ?;");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->bind_result($id_log, $nombre_log, $apellido_log, $usuario_log, $pass_log, $permiso_log, $estado_log);
        if ($stmt->affected_rows) {
            $existe = $stmt->fetch();
            if ($existe) {
                if ($password == $pass_log && !$estado_log) {
                    session_start();
                    $_SESSION['idusuario'] = $id_log;
                    $_SESSION['usuario'] = $usuario_log;
                    $_SESSION['nombre'] = $nombre_log . ' ' . $apellido_log;
                    $_SESSION['rol'] = $permiso_log;
                    $respuesta = array(
                        'respuesta' => 'exitoso',
                        'usuario' => $nombre_log,
                        'permiso' => $permiso_log,
                    );
                } else {
                    $respuesta = array(
                        'respuesta' => 'error',
                    );
                }
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                );
            }
        } /*else {
        $respuesta = array(
        'respuesta' => 'error_select'
        );
        }*/
        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        echo 'Error: ' . $e . getMessage();
    }

    die(json_encode($respuesta));
}