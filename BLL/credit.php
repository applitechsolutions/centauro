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
            mysqli_autocommit($conn, false);
            $query_success = true;

            $stmt = $conn->prepare("INSERT INTO credit (_idCustomer, _idCollector, code, dateStart, total) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("iissd", $idCustomer, $idCollector, $code, $dateStart, $total);
            if (!mysqli_stmt_execute($stmt)) {
                $query_success = false;
            }
            $id_registro = $stmt->insert_id;
            mysqli_stmt_close($stmt);

            if ($id_registro > 0) {
                $bal = 0;
                //Insert BALANCE
                $stmt = $conn->prepare("INSERT INTO balance(_idCredit, date, balpay, amount, balance) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("isidd", $id_registro, $dateStart, $bal, $total, $total);
                if (!mysqli_stmt_execute($stmt)) {
                    $query_success = false;
                }
                mysqli_stmt_close($stmt);

                if ($query_success) {
                    mysqli_commit($conn);
                    $respuesta = array(
                        'respuesta' => 'exito',
                        'idCredit' => $id_registro,
                        'mensaje' => 'Crédito creado correctamente!',
                        'proceso' => 'nuevo',
                    );
                } else {
                    mysqli_rollback($conn);
                    $respuesta = array(
                        'respuesta' => 'error',
                        'idCredit' => $id_registro,
                    );
                }
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'idCredit' => $id_registro,
                );
            }
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