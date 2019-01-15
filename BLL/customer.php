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

?>