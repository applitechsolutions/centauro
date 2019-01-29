<?php
include_once '../functions/bd_conexion.php';
header("Content-Type: application/json; charset=UTF-8");

$idCobrador = $_POST['id'];

$result = $conn->query("SELECT SUM(total) as totalCreditos FROM credit WHERE state = 0 AND cancel = 0 AND _idCollector = $idCobrador AND dateStart = CURDATE() ORDER BY code ASC");
$outp = array();
$outp = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($outp);