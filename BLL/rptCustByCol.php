<?php
	include_once '../functions/bd_conexion.php';
    header("Content-Type: application/json; charset=UTF-8");
    
    $cobrador = $_POST['idCollector'];

    $result = $conn->query("SELECT code, dateStart,
    (select (select concat(codeRoute, ' ', routeName) from route where idRoute = _idRoute) from customer where idCustomer = _idCustomer) as route,
    (select (select name from commerce where idCommerce = _idCommerce) from customer where idCustomer = _idCustomer) as commerce,
    (select concat(firstName, ' ', lastName) from customer where idCustomer = _idCustomer) as customer,
    total
    FROM credit WHERE _idCollector = $cobrador AND cancel = 0 ORDER BY dateStart ASC;");
    $outp = array();
    $outp = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($outp);
?>