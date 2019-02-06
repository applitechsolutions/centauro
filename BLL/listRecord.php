<?php
include_once '../functions/bd_conexion.php';
header("Content-Type: application/json; charset=UTF-8");

$idCustomer = $_POST['idCustomer'];

$result = $conn->query("SELECT C.code, C.dateStart, C.total, C.cancel, C.record,
    (select count(*) from balance where _idCredit = C.idCredit and balpay = 1 and state = 0) as totalP,
    (select count(*) from balance where _idCredit = C.idCredit and balpay = 1 and state = 0 and amount > 0) as pays
    FROM credit C WHERE _idCustomer = $idCustomer ORDER BY C.dateStart ASC");
$outp = array();
$outp = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($outp);