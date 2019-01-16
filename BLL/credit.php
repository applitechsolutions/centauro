<?php
include_once '../functions/bd_conexion.php';

if ($_POST['credito'] == 'nuevo') {

    $idCustomer = $_POST['idCustomer'];
    $idCollector = $_POST['idCollector'];
    $code = $_POST['code'];
    $total = $_POST['total'];
    $date = strtr($_POST['singledatepicker'], '/', '-');

    $dateStart = date('Y-m-d', strtotime($date));

    try {
        if ($code == '' or $dateStart == '' or $total == '') {
            $respuesta = array(
                'respuesta' => 'vacio',
            );
        } else {
            $stmt = $conn->prepare("INSERT INTO credit (_idCustomer, _idCollector, code, dateStart, total) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("iissd", $idCustomer, $idCollector, $code, $dateStart, $total);
            $stmt->execute();
            $id_registro = $stmt->insert_id;
            if ($id_registro > 0) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idCredit' => $id_registro,
                    'mensaje' => 'Crédito creado correctamente!',
                    'proceso' => 'nuevo',
                );

            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'idCredit' => $id_registro,
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