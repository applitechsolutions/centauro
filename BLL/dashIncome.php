<?php
	include_once '../functions/bd_conexion.php';
    header("Content-Type: application/json; charset=UTF-8");

    $idCollector = $_GET['idCollector'];

    $conn->query("SET lc_time_names = 'es_ES'");
    $result = $conn->query("SELECT MONTHNAME(date) as month, SUM(incomes) as incomes FROM income WHERE YEAR(date) = YEAR(CURDATE()) AND _idCollector = $idCollector GROUP BY MONTH(date) ORDER BY MONTH(date) ASC");
    $outp = array();
    $outp = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($outp);
?>