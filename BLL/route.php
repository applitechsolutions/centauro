<?php
include_once '../functions/bd_conexion.php';

if ($_POST['ruta'] == 'nueva') {

    $codeRoute = $_POST['codeRoute'];
    $routeName = $_POST['routeName'];
    $details = $_POST['details'];
    $idCollector = $_POST['idCollector'];

    try {
        if ($idCollector == '' or $routeName == '') {
            $respuesta = array(
                'respuesta' => 'vacio',
            );
        } else {
            $stmt = $conn->prepare("INSERT INTO route (codeRoute, routeName, details, _idCollector) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $codeRoute, $routeName, $details, $idCollector);
            $stmt->execute();
            $id_registro = $stmt->insert_id;
            if ($id_registro > 0) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idRoute' => $id_registro,
                    'mensaje' => 'Ruta creada correctamente!',
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

if ($_POST['ruta'] == 'editar') {

    $idRoute = $_POST['idRoute'];
    $codeRoute = $_POST['codeRoute'];
    $routeName = $_POST['routeName'];
    $details = $_POST['details'];
    $idCollector = $_POST['idCollector'];

    try {
        if ($idCollector == '' or $routeName == '') {
            $respuesta = array(
                'respuesta' => 'vacio',
            );
        } else {
            $stmt = $conn->prepare("UPDATE route SET codeRoute = ?, routeName = ?, details = ?, _idCollector = ? WHERE idRoute = ?");
            $stmt->bind_param("sssii", $codeRoute, $routeName, $details, $idCollector, $idRoute);
            $stmt->execute();
            if ($stmt->affected_rows) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idRoute' => $stmt->insert_id,
                    'mensaje' => 'Ruta Editada correctamente!',
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

if ($_POST['ruta'] == 'eliminar') {

    $idRoute = $_POST['id'];

    try {
        if ($idRoute == '') {
            $respuesta = array(
                'respuesta' => 'vacio',
            );
        } else {
            $stmt = $conn->prepare("UPDATE route SET state = 1 WHERE idRoute = ?");
            $stmt->bind_param("i", $idRoute);
            $stmt->execute();
            if ($stmt->affected_rows) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idRoute' => $idRoute,
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