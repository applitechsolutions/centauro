<?php

if (isset($_POST['ingresar'])) {
    $usuario = $_POST['username'];
    $password = $_POST['password'];

    //die(json_encode($_POST));

    try {
        include_once '../functions/bd_conexion.php';
        $stmt = $conn->prepare("SELECT idUser, firstName, lastName, userName, passWord, permissions, state FROM user WHERE userName = ?;");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->bind_result($id_log, $firstName_log, $lastName_log, $userName_log, $pass_log, $permissions_log, $state_log);
        if ($stmt->affected_rows) {
            $existe = $stmt->fetch();
            if ($existe) {
<<<<<<< HEAD
                if (password_verify($password, $pass_log)) {
=======
                if (password_verify($password, $pass_log) && !$state_log) {
>>>>>>> 161ac068e47e074bdc10af47da6a64378b9b7d44
                    session_start();
                    $_SESSION['idusuario'] = $id_log;
                    $_SESSION['usuario'] = $userName_log;
                    $_SESSION['nombre'] = $firstName_log . ' ' . $lastName_log;
                    $_SESSION['rol'] = $permissions_log;
                    $respuesta = array(
                        'respuesta' => 'exitoso',
                        'usuario' => $firstName_log,
                        'permiso' => $permissions_log,
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