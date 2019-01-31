<?php
	include_once '../functions/bd_conexion.php';
    header("Content-Type: application/json; charset=UTF-8");
    
    $idCredito = $_POST['idCredito'];

    $result = $conn->query("SELECT * FROM balance WHERE _idCredit = $idCredito ORDER BY idBalance DESC");
    $outp = array();
    $outp = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($outp);
?>