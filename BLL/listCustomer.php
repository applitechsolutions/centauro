<?php
include_once '../functions/bd_conexion.php';
header("Content-Type: application/json; charset=UTF-8");

$result = $conn->query("SELECT idCredit, code, (select concat(firstName, ' ', lastName) from customer where idCustomer = _idCustomer) as customer,
    (select name from commerce where idCommerce = (select _idCommerce from customer where idCustomer = _idCustomer)) as commerce,
    _idCollector
    FROM credit WHERE state = 0 AND cancel = 0 ORDER BY code ASC");
$outp = array();
$outp = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($outp);