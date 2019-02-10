<?php
include_once '../functions/bd_conexion.php';
header("Content-Type: application/json; charset=UTF-8");

$idCobrador = $_POST['id'];
$date = strtr($_POST['fecha'], '/', '-');
$fc = date('Y-m-d', strtotime($date));

$result = $conn->query("SELECT SUM(total) as totalCreditos FROM credit WHERE cancel = 0 AND _idCollector = $idCobrador AND dateStart = '$fc' ORDER BY code ASC");
$outp = array();
$outp = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($outp);