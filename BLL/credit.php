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
                $ganancia = $total * 0.15;
                $saldo = $total + $ganancia;
                $stmt = $conn->prepare("INSERT INTO balance(_idCredit, date, balpay, amount, balance) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("isidd", $id_registro, $dateStart, $bal, $saldo, $saldo);
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

if ($_POST['credito'] == 'nuevo-historial') {

    $idCustomer = $_POST['idCustomer'];
    $idCollector = $_POST['idCollector'];
    $code = $_POST['code'];
    $total = $_POST['total'];
    $date = strtr($_POST['singledatepicker'], '/', '-');
    $dateStart = date('Y-m-d', strtotime($date));

    $MyArray = json_decode($_POST['json']);

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
                $ganancia = $total * 0.15;
                $saldo = $total + $ganancia;
                $stmt = $conn->prepare("INSERT INTO balance(_idCredit, date, balpay, amount, balance) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("isidd", $id_registro, $dateStart, $bal, $saldo, $saldo);
                if (!mysqli_stmt_execute($stmt)) {
                    $query_success = false;
                }
                mysqli_stmt_close($stmt);

                $pay = 1;
                $balance = $saldo;

                foreach ($MyArray->pago as $pago) {
                    //Insert PAGOS
                    $datePay = strtr($pago->date, '/', '-');
                    $dateP = date('Y-m-d', strtotime($datePay));

                    $balance = $balance - $pago->amount;
                    $stmt = $conn->prepare("INSERT INTO balance (_idCredit, date, balpay, amount, balance) VALUES (?, ?, ?, ?, ?)");
                    $stmt->bind_param("isidd", $id_registro, $dateP, $pay, $pago->amount, $balance);
                    if (!mysqli_stmt_execute($stmt)) {
                        $query_success = false;
                    }
                    mysqli_stmt_close($stmt);
                }

                if ($balance == 0) {
                    $stmt = $conn->prepare("UPDATE credit SET cancel = 1 WHERE idCredit = ?");
                    $stmt->bind_param("i", $id_registro);
                    if (!mysqli_stmt_execute($stmt)) {
                        $query_success = false;
                    }
                    mysqli_stmt_close($stmt);
                }

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

if ($_POST['credito'] == 'nuevo-ingreso') {

    die(json_encode($_POST));
    $MyArray = json_decode($_POST['json']);

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
                $ganancia = $total * 0.15;
                $saldo = $total + $ganancia;
                $stmt = $conn->prepare("INSERT INTO balance(_idCredit, date, balpay, amount, balance) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("isidd", $id_registro, $dateStart, $bal, $saldo, $saldo);
                if (!mysqli_stmt_execute($stmt)) {
                    $query_success = false;
                }
                mysqli_stmt_close($stmt);

                $pay = 1;
                $balance = $saldo;

                foreach ($MyArray->pago as $pago) {
                    //Insert PAGOS
                    $datePay = strtr($pago->date, '/', '-');
                    $dateP = date('Y-m-d', strtotime($datePay));

                    $balance = $balance - $pago->amount;
                    $stmt = $conn->prepare("INSERT INTO balance (_idCredit, date, balpay, amount, balance) VALUES (?, ?, ?, ?, ?)");
                    $stmt->bind_param("isidd", $id_registro, $dateP, $pay, $pago->amount, $balance);
                    if (!mysqli_stmt_execute($stmt)) {
                        $query_success = false;
                    }
                    mysqli_stmt_close($stmt);
                }

                if ($balance == 0) {
                    $stmt = $conn->prepare("UPDATE credit SET cancel = 1 WHERE idCredit = ?");
                    $stmt->bind_param("i", $id_registro);
                    if (!mysqli_stmt_execute($stmt)) {
                        $query_success = false;
                    }
                    mysqli_stmt_close($stmt);
                }

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