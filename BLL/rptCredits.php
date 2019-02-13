<?php
	include_once '../functions/bd_conexion.php';
    header("Content-Type: application/json; charset=UTF-8");
    
    $cobrador = $_POST['idCollectorRPT2'];
    $fechainicio = strtr($_POST['singledatepicker'], '/', '-');
    $fechafinal = strtr($_POST['singledatepicker2'], '/', '-');
    $fi = date('Y-m-d', strtotime($fechainicio));
    $ff = date('Y-m-d', strtotime($fechafinal));

    $result = $conn->query("SELECT code, dateStart,
    (select (select concat(codeRoute, ' ', routeName) from route where idRoute = _idRoute) from customer where idCustomer = _idCustomer) as route,
    (select (select name from commerce where idCommerce = _idCommerce) from customer where idCustomer = _idCustomer) as commerce,
    (select concat(firstName, ' ', lastName) from customer where idCustomer = _idCustomer) as customer,
    total, (select date from balance where _idCredit = idCredit ORDER BY idBalance DESC LIMIT 1) as fechaP
    FROM credit WHERE _idCollector = $cobrador AND cancel = 1 AND 
    (select date from balance where _idCredit = idCredit ORDER BY idBalance DESC LIMIT 1) between '$fi' AND '$ff' ORDER BY dateStart ASC;");
    $outp = array();
    $outp = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($outp);
?>