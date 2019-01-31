<?php
include_once '../funciones/bd_conexion.php';

if ($_POST['tipo'] == 'pago') {
    $idCredit = $_POST['idCredit'];
    $date = strtr($_POST['singledatepicker'], '/', '-');
    $amount = $_POST['amount'];
    $totalB = $_POST['totalB'];
    $bal = 1;
    $new_totalB = $totalB - $amount;
    $fc = date('Y-m-d', strtotime($date));

    try {
        if ($idCredit == '' || $amount == '' || $date == '' || $new_totalB < 0) {
            $respuesta = array(
                'respuesta' => 'vacio',
            );
        } else {
            $stmt = $conn->prepare("INSERT INTO balance(_idCredit, date, balpay, amount, balance) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("isidd", $idCredit, $fc, $bal, $amount, $new_totalB);
            $stmt->execute();
            $id_registro = $stmt->insert_id;
            if ($id_registro > 0) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idBalance' => $id_registro,
                    'proceso' => 'nuevo',
                    'mensaje' => 'Pago ingresado con correctamente!',
                    'idCredit' => $idCredit,
                    'new_totalB' => $new_totalB,
                );
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'idBalance' => $id_registro,
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

if ($_POST['tipo'] == 'anular') {
    $idCredit = $_POST['idCredit'];
    $idBalance = $_POST['idBalance'];

    try {
        /* Switch off auto commit to allow transactions*/
        mysqli_autocommit($conn, false);
        $query_success = true;

        //Update BALANCE
        $state = 1;
        $stmt = $conn->prepare("UPDATE balance SET state = ? WHERE idBalance = ?");
        $stmt->bind_param("ii", $state, $idBalance);
        if (!mysqli_stmt_execute($stmt)) {
            $query_success = false;
        }
        mysqli_stmt_close($stmt);

        //Selecciona los pagos realizados
        try {
            $sql = "SELECT idBalance, amount, state FROM balance WHERE _idCredit = $idCredit AND state = 0 ORDER BY idBalance ASC;";
            $resultado = $conn->query($sql);
        } catch (Exception $e) {
            $query_success = false;
        }
        $bandera = 0;
        while ($balance = $resultado->fetch_assoc()) {
            //Update PAY'S
            if ($bandera == 0) {
                $nuevo_balance = $balance['amount'];
                $bandera = 1;
            } else {
                $nuevo_balance = $nuevo_balance - $balance['amount'];

                $stmt = $conn->prepare("UPDATE balance SET balance = ? WHERE idBalance = ?");
                $stmt->bind_param("di", $nuevo_balance, $balance['idBalance']);
                if (!mysqli_stmt_execute($stmt)) {
                    $query_success = false;
                }
                mysqli_stmt_close($stmt);
            }
        }

        if ($query_success) {
            mysqli_commit($conn);
            $respuesta = array(
                'respuesta' => 'exito',
                'idBalance' => $idBalance,
            );
        } else {
            mysqli_rollback($conn);
            $respuesta = array(
                'respuesta' => 'error',
                'idBalance' => $idBalance,
            );
        }
        $conn->close();
    } catch (Exception $e) {
        echo 'Error: ' . $e . getMessage();
    }
    die(json_encode($respuesta));
}