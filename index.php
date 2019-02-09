<?php 
	include_once 'functions/sesiones.php';
	include_once 'templates/header.php';
	include_once 'templates/navBar.php';
	include_once 'templates/sideBar.php';
	include_once 'functions/bd_conexion.php';
?>
<div class="content-page">

	<!-- Start content -->
	<div class="content">

		<div class="container-fluid">

			<div class="row">
				<div class="col-xl-12">
					<div class="breadcrumb-holder">
						<h1 class="main-title float-left">Dashboard</h1>
						<ol class="breadcrumb float-right">
							<li class="breadcrumb-item">Home</li>
							<li class="breadcrumb-item active">Dashboard</li>
						</ol>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<!-- end row -->
		<!-- PHP -->
			<?php 
				$sql = "SELECT SUM(total) as capital FROM credit WHERE cancel = 0";
				$resultado = $conn->query($sql);
				$capital = $resultado->fetch_assoc();
			?>
		<!-- PHP -->
			<div class="row">
				<div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
					<div class="card-box noradius noborder bg-success">
						<i class="fas fa-piggy-bank float-right text-white"></i>
						<h6 class="text-white text-uppercase m-b-20">Capital</h6>
						<h1 class="m-b-20 text-white counter"><?php echo $capital['capital']; ?></h1>
						<span class="text-white">Total Invertido </span>
					</div>
				</div>

		<!-- PHP -->
			<?php 
				$sql = "SELECT SUM((SELECT balance FROM balance WHERE _idCredit = idCredit ORDER BY idBalance DESC LIMIT 1)) as faltante FROM credit WHERE cancel = 0";
				$resultado = $conn->query($sql);
				$faltante = $resultado->fetch_assoc();
			?>
		<!-- PHP -->

				<div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
					<div class="card-box noradius noborder bg-warning">
						<i class="fas fa-coins float-right text-white"></i>
						<h6 class="text-white text-uppercase m-b-20">Dinero por recaudar</h6>
						<h1 class="m-b-20 text-white counter"><?php echo $faltante['faltante']; ?></h1>
						<span class="text-white">Dinero faltante</span>
					</div>
				</div>

		<!-- PHP -->
			<?php 
				$cobrado = $capital['capital'] - $faltante['faltante'];
			?>
		<!-- PHP -->

				<div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
					<div class="card-box noradius noborder bg-primary">
						<i class="fas fa-hand-holding-usd float-right text-white"></i>
						<h6 class="text-white text-uppercase m-b-20">Dinero recaudado</h6>
						<h1 class="m-b-20 text-white counter"><?php echo $cobrado; ?></h1>
						<span class="text-white">Dinero recuperado</span>
					</div>
				</div>

		<!-- PHP -->
			<?php 
				$sql = "SELECT COUNT(*) as total FROM credit WHERE cancel = 0";
				$resultado = $conn->query($sql);
				$creditos = $resultado->fetch_assoc();
			?>
		<!-- PHP -->
				<div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
					<div class="card-box noradius noborder bg-secondary">
						<i class="fas fa-list-ol float-right text-white"></i>
						<h6 class="text-white text-uppercase m-b-20">Créditos activos</h6>
						<h1 class="m-b-20 text-white counter"><?php echo $creditos['total']; ?></h1>
						<span class="text-white">Total de Créditos Activos</span>
					</div>
				</div>
			</div>
			<!-- end row -->
		</div>
		<!-- END container-fluid -->

	</div>
	<!-- END content -->

</div>
<!-- END content-page -->
<?php 
	include_once 'templates/footer.php';
?>