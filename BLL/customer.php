<?php
    include_once '../functions/bd_conexion.php';

    if ($_POST['cliente'] == 'nuevo') {

        $dpi = $_POST['dpiCustomer'];
        $nombre = $_POST['nameCustomer'];
        $apellido = $_POST['lastCustomer'];
        $direccion = $_POST['addressCustomer'];
        $tel1 = $_POST['mob1Customer'];
        $tel2 = $_POST['mob2Customer'];
        $ruta = $_POST['_idRoute'];
        $comercio = $_POST['_idCommerce'];

        try {
            if ($nombre == '' || $apellido == '' || $ruta == '' || $comercio == '') {
                $respuesta = array(
                    'respuesta' => 'vacio',
                );
            } else {
                $stmt = $conn->prepare("INSERT INTO customer (_idCommerce, _idRoute, DPI, firstName, lastName, address, mobile, mobile2) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("iissssss", $comercio, $ruta, $dpi, $nombre, $apellido, $direccion, $tel1, $tel2);
                $stmt->execute();
                $id_registro = $stmt->insert_id;
                if ($id_registro > 0) {
                    $respuesta = array(
                        'respuesta' => 'exito',
                        'idCliente' => $id_registro,
                        'mensaje' => 'Cliente creado correctamente!',
                        'proceso' => 'nuevo',
                    );

                } else {
                    $respuesta = array(
                        'respuesta' => 'error',
                        'idCliente' => $id_registro,
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

    if ($_POST['cliente'] == 'editar') {

        $idCliente = $_POST['idCustomer'];
        $dpi = $_POST['dpiCustomer'];
        $nombre = $_POST['nameCustomer'];
        $apellido = $_POST['lastCustomer'];
        $direccion = $_POST['addressCustomer'];
        $tel1 = $_POST['mob1Customer'];
        $tel2 = $_POST['mob2Customer'];
        $ruta = $_POST['_idRoute'];
        $comercio = $_POST['_idCommerce'];

        try {
            if ($nombre == '' || $apellido == '' || $ruta == '' || $comercio == '') {
                $respuesta = array(
                    'respuesta' => 'vacio',
                );
            } else {
                $stmt = $conn->prepare("UPDATE customer SET _idCommerce = ?, _idRoute = ?, DPI = ?, firstName = ?, lastName = ?, address = ?, mobile = ?, mobile2 = ? WHERE idCustomer = ?");
                $stmt->bind_param("iissssssi", $comercio, $ruta, $dpi, $nombre, $apellido, $direccion, $tel1, $tel2, $idCliente);
                $stmt->execute();
                if ($stmt->affected_rows) {
                    $respuesta = array(
                        'respuesta' => 'exito',
                        'idCliente' => $stmt->insert_id,
                        'mensaje' => 'Cliente editado correctamente!',
                        'proceso' => 'editado',
                    );
                } else {
                    $respuesta = array(
                        'respuesta' => 'error',
                        'idCliente' => $id_registro,
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

    if ($_POST['cliente'] == 'eliminar') {

        $idCliente = $_POST['id'];

        try {
            if ($idCliente == '') {
                $respuesta = array(
                    'respuesta' => 'vacio',
                );
            } else {
                $stmt = $conn->prepare("UPDATE customer SET state = 1 WHERE idCustomer = ?");
                $stmt->bind_param("i", $idCliente);
                $stmt->execute();
                if ($stmt->affected_rows) {
                    $respuesta = array(
                        'respuesta' => 'exito',
                        'idCliente' => $idCliente,
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