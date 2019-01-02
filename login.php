<?php
  if ($_GET) {
    session_start();
    $cerrar_sesion = $_GET['cerrar_sesion'];
  } else {
    $cerrar_sesion = false;
  }
 
  if ($cerrar_sesion) {
    session_destroy();
  }
  include_once 'functions/bd_conexion.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<title>Control de Arrendamientos</title>
	<!-- Favicon -->
	<link rel="shortcut icon" href="images/favicon.ico">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/my-login.css">
	<link rel="stylesheet" type="text/css" href="css/sweetalert2.min.css">
</head>
<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">
					<div class="brand">
						<img src="images/logo.png">
					</div>
					<div class="card fat">
						<div class="card-body">
							<h4 class="card-title">Control de Arrendamientos<h5>Inicio de Sesión: </h5></h4>
							<form id="form-login" name="form-login" action="BLL/logueo.php" method="POST">
							 
								<div class="form-group">
									<label for="email">Usuario: </label>

									<input id="username" type="text" class="form-control" name="username" value="" required autofocus>
								</div>

								<div class="form-group">
									<label for="password">Contraseña</label>
									<input id="password" type="password" class="form-control" name="password" required data-eye>
								</div>

								<div class="form-group">
									<label>
										<input type="checkbox" name="remember"> Recuérdame 
									</label>
								</div>

								<div class="form-group no-margin">
								<input type="hidden" name="ingresar" value="1">
									<button type="submit" class="btn btn-primary btn-block">
										Iniciar
									</button>
								</div>
							</form>
						</div>
					</div>
					<div class="footer">
						Copyright &copy; APPLITECH SOFTWARE SOLUTIONS 2018
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="js/jquery.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="js/my-login.js"></script>
	<script src="js/sweetalert2.min.js"></script>
	<script src="js/ajax/login.js"></script>
</body>
</html>