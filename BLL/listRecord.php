<?php
include_once '../functions/bd_conexion.php';
header("Content-Type: application/json; charset=UTF-8");

$idCustomer = $_POST['idCustomer'];

$result = $conn->query("SELECT C.code, C.dateStart, C.total, C.cancel, C.record,
    datediff((select date from balance where state = 0 ORDER BY idBalance DESC LIMIT 1), C.dateStart) as diff
    FROM credit C WHERE _idCustomer = $idCustomer ORDER BY C.dateStart ASC");
$outp = array();
$outp = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($outp);