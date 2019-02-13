<?php
	include ('pdfclass/mpdf.php');//Se importa la librería de PDF
    include_once '../functions/bd_conexion.php';

//Se indica lo que se va a imprimir en formato HTML
$idCobrador = $_GET['idCobrador'];

try {
    $sql = "SELECT code, dateStart,
    (SELECT concat(firstName, ' ', lastName) FROM collector WHERE idCollector = $idCobrador AND state = 0) as cobrador,
    (select (select concat(codeRoute, ' ', routeName) from route where idRoute = _idRoute) from customer where idCustomer = _idCustomer) as route,
    (select (select name from commerce where idCommerce = _idCommerce) from customer where idCustomer = _idCustomer) as commerce,
    (select concat(firstName, ' ', lastName) from customer where idCustomer = _idCustomer) as customer,
    (select balance from balance WHERE _idCredit = idCredit ORDER BY idBalance DESC LIMIT 1) as total
    FROM credit WHERE _idCollector = $idCobrador AND cancel = 0 ORDER BY dateStart ASC;";

    $resultado = $conn->query($sql);
    $res = $conn->query($sql);
} catch (Exception $e) {
    $error = $e->getMessage();
    echo $error;
}

while ($nombre = $res->fetch_assoc()) {
    $cobrador = $nombre['cobrador'];
}

$pagina='										
<!DOCTYPE html>
	<html>
		<head>
			<title>NOMBRE DEL REPORTE</title>
			<link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		</head>
		<body class="w3-padding">
			<div class="w3-container">
				<div id="Encabezado">
					<div class="login-logo w3-center w3-light-grey w3-round-medium">
						<div class="image">
						<img src="../images/logo.png" width="150px" height="150px" class="w3-round-medium" alt="Login Image">
						</div>      
					</div>
					<div class="row">
                        <div class="col-xs-12">
                        <h2 class="page-header">
                            <i class="fa fa-globe"></i> Centauro, Créditos.
                            <small class="pull-right w3-right">Fecha: ' . date("d/m/Y") . '</small>
                        </h2>
                        </div>
                        <!-- /.col -->
                    </div>
					<div style="text-align: center;">
                        <h2>Clientes de ' . $cobrador . '</h2>
					</div>
				</div>
				<div id="contenido">
					<table class="w3-table-all">
						<thead style="background-color: black;">
							<tr>
                                <th style="background-color: #1d2128; color: white">No. Tarjeta</th>
								<th style="background-color: #1d2128; color: white">Fecha</th>
								<th style="background-color: #1d2128; color: white">Cliente</th>
								<th style="background-color: #1d2128; color: white">Comercio</th>
								<th style="background-color: #1d2128; color: white">Ruta</th>
								<th style="background-color: #1d2128; color: white">Saldo</th>
							</tr>
						</thead>
                        <tbody class="w3-white">';
while ($credits = $resultado->fetch_assoc()) {
    $dateStart = date_create($credits['dateStart']);
    $pagina .= '
                        <tr>
                            <td>' . $credits['code'] . '</td>
                            <td>' . date_format($dateStart, 'd/m/y') . '</td>
                            <td>' . $credits['customer'] . '</td>
                            <td>' . $credits['commerce'] . '</td>
                            <td>' . $credits['route'] . '</td>
                            <td>Q. ' . $credits['total'] . '</td>
                        </tr>';
} 
            $pagina .= '</tbody>
					</table>
				</div>
			</div>
		</body>
	</html>';

				

	
	$file = "NombreReporte.pdf"; //Se nombra el archivo

	$mpdf = new mPDF('utf-8', 'LETTER', 0, '', 10, 10, 10, 10, 0, 0);//se define el tamaño de pagina y los margenes
	$mpdf->WriteHTML($pagina); //se escribe la variable pagina
	
	$mpdf->Output($file, 'I'); //Se crea el documento pdf y se muestra en el navegador
?>
