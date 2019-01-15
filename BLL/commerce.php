<?php
include_once '../functions/bd_conexion.php';

if ($_POST['commerce'] == 'nuevo') {

    $nombre = $_POST['nameCommerce'];
    
    try{
        if ($nombre == '') {
            $respuesta = array(
                'respuesta' => 'vacio'
            );
        }else {
            $stmt = $conn->prepare("INSERT INTO commerce (name) VALUES (?)");
            $stmt->bind_param("s", $nombre);
            $stmt->execute();
            $id_registro = $stmt->insert_id;
            if ($id_registro > 0) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'idNegocio' => $id_registro,
                    'mensaje' => 'Negocio creado correctamente!'
                );                
            }else {
                $respuesta = array(
                    'respuesta' => 'error',
                    'idNegocio' => $id_registro
                );
            }
            $stmt->close();
            $conn->close();
        }
        
    }catch(Exception $e){
        echo 'Error: '. $e.getMessage();
    }
    die(json_encode($respuesta));
}

?>