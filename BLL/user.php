<?php
include_once '../functions/bd_conexion.php';

if ($_POST['usuario'] == 'nuevo') {

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $userName = $_POST['userName'];
    $passWord = $_POST['passWord'];
    $confirm_passWord = $_POST['confirm_passWord'];
    $permissions = $_POST['gridRadios'];
    $pass_hashed = password_hash($passWord, PASSWORD_BCRYPT);

    $idCollector = $_POST['idCollector'];

    try {
        if ($firstName == '' or $lastName == '' or $userName == '' or $passWord == '' or $confirm_passWord == '') {
            $respuesta = array(
                'respuesta' => 'vacio',
            );
        } else if ($passWord != $confirm_passWord) {
            $respuesta = array(
                'respuesta' => 'no_igual',
            );
        } else {
            $stmt = $conn->prepare("INSERT INTO user (firstName, lastName, userName, passWord, permissions, _idCollector) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssii", $firstName, $lastName, $userName, $pass_hashed, $permissions, $idCollector);
            $stmt->execute();
            $id_registro = $stmt->insert_id;
            if ($id_registro > 0) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idUsuario' => $id_registro,
                    'mensaje' => 'Usuario creado correctamente!',
                    'proceso' => 'nuevo',
                );
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'idUsuario' => $id_registro,
                );
            }
            $stmt->close();
            $conn->close();
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e . getMessage();
    }
    die(json_encode($respuesta));
}

if ($_POST['usuario'] == 'editar') {

    $idUser = $_POST['idUser'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $permissions = $_POST['gridRadios'];

    $idCollector = $_POST['idCollector'];

    try {
        if ($firstName == '' or $lastName == '') {
            $respuesta = array(
                'respuesta' => 'vacio',
            );
        } else {
            $stmt = $conn->prepare("UPDATE user SET firstName = ?, lastName = ?, permissions = ?, _idCollector = ? WHERE idUser = ?");
            $stmt->bind_param("ssiii", $firstName, $lastName, $permissions, $idCollector, $idUser);
            $stmt->execute();
            if ($stmt->affected_rows) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idUsuario' => $stmt->insert_id,
                    'mensaje' => 'Usuario Editado correctamente!',
                    'proceso' => 'editado',
                );
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'idUsuario' => $id_registro,
                );
            }
            $stmt->close();
            $conn->close();
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e . getMessage();
    }
    die(json_encode($respuesta));
}

if ($_POST['usuario'] == 'eliminar') {

    $idUser = $_POST['id'];

    try {
        if ($idUser == '') {
            $respuesta = array(
                'respuesta' => 'vacio',
            );
        } else {
            $stmt = $conn->prepare("UPDATE user SET state = 1 WHERE idUser = ?");
            $stmt->bind_param("i", $idUser);
            $stmt->execute();
            if ($stmt->affected_rows) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idUsuario' => $idUser,
                );
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                );
            }
            $stmt->close();
            $conn->close();
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e . getMessage();
    }
    die(json_encode($respuesta));
}