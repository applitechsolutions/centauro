<?php
include_once '../functions/bd_conexion.php';

if ($_POST['empresa'] == 'nueva') {

    $nombre = $_POST['nombre'];
    $nit = $_POST['nit'];

    try {
        if ($nombre == '' && $nit == '') {
            $respuesta = array(
                'respuesta' => 'vacio',
            );
        } else {
            $stmt = $conn->prepare("INSERT INTO empresa (nombre, nit) VALUES (?, ?)");
            $stmt->bind_param("ss", $nombre, $nit);
            $stmt->execute();
            $id_registro = $stmt->insert_id;
            if ($id_registro > 0) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idRoute' => $id_registro,
                    'mensaje' => 'Empresa creada correctamente!',
                    'proceso' => 'nuevo',
                );

            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'idRoute' => $id_registro,
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

if ($_POST['empresa'] == 'editar') {

    $idEmpresa = $_POST['idEmpresa'];
    $nombre = $_POST['nombre'];
    $nit = $_POST['nit'];

    try {
        if ($nombre == '' && $nit == '') {
            $respuesta = array(
                'respuesta' => 'vacio',
            );
        } else {
            $stmt = $conn->prepare("UPDATE empresa SET nombre = ?, nit = ? WHERE idEmpresa = ?");
            $stmt->bind_param("ssi", $nombre, $nit, $idEmpresa);
            $stmt->execute();
            if ($stmt->affected_rows) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idRoute' => $stmt->insert_id,
                    'mensaje' => 'Empresa Editada correctamente!',
                    'proceso' => 'editado',
                );
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'idRoute' => $id_registro,
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

if ($_POST['empresa'] == 'eliminar') {

    $idEmpresa = $_POST['id'];

    try {
        if ($idEmpresa == '') {
            $respuesta = array(
                'respuesta' => 'vacio',
            );
        } else {
            $stmt = $conn->prepare("UPDATE empresa SET estado_eliminado = 1 WHERE idEmpresa = ?");
            $stmt->bind_param("i", $idEmpresa);
            $stmt->execute();
            if ($stmt->affected_rows) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idEmpresa' => $idEmpresa,
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