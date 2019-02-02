<?php
include_once '../functions/bd_conexion.php';
header("Content-Type: application/json; charset=UTF-8");

$result = $conn->query("SELECT idCustomer, concat(firstName, ' ', lastName) as customer,
(select name from commerce where idCommerce = _idCommerce) as commerce,
(select _idCollector from route where idRoute = _idRoute) as idCollector
 FROM customer WHERE state = 0 ORDER BY firstName ASC");
$outp = array();
$outp = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($outp);