<?php
	include_once '../functions/bd_conexion.php';
    header("Content-Type: application/json; charset=UTF-8");
    
    $cobrador = $_POST['idCollectorRPT3'];
    $fechainicio = strtr($_POST['singledatepicker'], '/', '-');
    $fi = date('Y-m-d', strtotime($fechainicio));
    $result = $conn->query("SELECT DATE_FORMAT(C.dateStart, '%d/%m/%Y') as dateStart, C.code, (select concat(firstName, ' ', lastName) from customer where idCustomer = C._idCustomer) as customer,
    (select name from commerce where idCommerce = (select _idCommerce from customer where idCustomer = C._idCustomer)) as commerce,
    C.total, B.amount FROM credit C INNER JOIN balance B ON C.idCredit = B._idCredit WHERE C._idCollector = $cobrador AND B.balpay = 1 AND B.date = '$fi' AND state = 0;");
    $outp = array();
    $outp = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($outp);
?>