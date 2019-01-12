<?php
include_once '../functions/bd_conexion.php';

if ($_POST['cobrador'] == 'nuevo') {

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $dpi = $_POST['dpi'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $bday = strtr($_POST['singledatepicker'], '/', '-');

    $fecha_formateada = date('Y-m-d', strtotime($bday));

    try {
        if ($nombre == '' && $apellido == '' && $dpi == '') {
            $respuesta = array(
                'respuesta' => 'vacio',
            );
        } else {
            $stmt = $conn->prepare("INSERT INTO collector (firstName, lastName, address, mobile, DPI, birthDate) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $nombre, $apellido, $direccion, $telefono, $dpi, $fecha_formateada);
            $stmt->execute();
            $id_registro = $stmt->insert_id;
            if ($id_registro > 0) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idRoute' => $id_registro,
                    'mensaje' => 'Cobrador creado correctamente!',
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

if ($_POST['cobrador'] == 'editar') {

    $idCobrador = $_POST['idCobrador'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $dpi = $_POST['dpi'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $bday = strtr($_POST['singledatepicker'], '/', '-');

    $fecha_formateada = date('Y-m-d', strtotime($bday));

    try {
        if ($nombre == '' && $apellido == '' && $dpi == '') {
            $respuesta = array(
                'respuesta' => 'vacio',
            );
        } else {
            $stmt = $conn->prepare("UPDATE collector SET firstName = ?, lastName = ?, address = ?, mobile = ?, DPI = ?, birthDate = ? WHERE idCollector = ?");
            $stmt->bind_param("ssssssi", $nombre, $apellido, $direccion, $telefono, $dpi, $fecha_formateada, $idCobrador);
            $stmt->execute();
            if ($stmt->affected_rows) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idRoute' => $stmt->insert_id,
                    'mensaje' => 'Cobrador editado correctamente!',
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

if ($_POST['cobrador'] == 'eliminar') {

    $idCobrador = $_POST['id'];

    try {
        if ($idCobrador == '') {
            $respuesta = array(
                'respuesta' => 'vacio',
            );
        } else {
            $stmt = $conn->prepare("UPDATE collector SET state = 1 WHERE idCollector = ?");
            $stmt->bind_param("i", $idCobrador);
            $stmt->execute();
            if ($stmt->affected_rows) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idCobrador' => $idCobrador,
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

?>