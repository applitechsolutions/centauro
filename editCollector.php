<?php
    include_once 'functions/sesiones.php';
    include_once 'templates/header.php';
    include_once 'templates/navBar.php';
    include_once 'templates/sideBar.php';
    include_once 'functions/bd_conexion.php';
    $id = $_GET['id'];
    if (!filter_var($id, FILTER_VALIDATE_INT)) {
        die("Error!");
    }
?>

<div class="content-page">
	<!-- Start content -->
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-12">
					<div class="breadcrumb-holder">
						<h1 class="main-title float-left">Cobradores</h1>
						<ol class="breadcrumb float-right">
						</ol>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<!-- end row -->
<?php
    $sql = "SELECT * FROM `collector` WHERE `idCollector` = $id ";
    $resultado = $conn->query($sql);
    $collector = $resultado->fetch_assoc();
?>
			<div class="row">
				<div class="col-xl-12">
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-8 col-xl-8">						
						<div class="card mb-3">
							<div class="card-header">
								<h3><i class="fa fa-automobile"></i> Editar Cobrador</h3>
								Modifique los campos para editar al cobrador.
							</div>
							<div class="card-body">
								<form autocomplete="on" role="form" id="form-cobrador" name="form-cobrador" method="POST" action="BLL/collector.php">
								  <div class="form-group">
									<label for="nombre">Nombre<span class="text-danger">*</span></label>
									<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del cobrador" value="<?php echo $collector['firstName'] ?>" autofocus>
								  </div>
								  <div class="form-group">
									<label for="nit">Apellido<span class="text-danger">*</span></label>
									<input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido del cobrador" value="<?php echo $collector['lastName'] ?>">
                                  </div>
								  <div class="form-group">
									<label for="nit">DPI<span class="text-danger">*</span></label>
									<input type="text" class="form-control" id="dpi" name="dpi" placeholder="DPI del cobrador" value="<?php echo $collector['DPI'] ?>">
                                  </div>
                                  <div class="form-group">
									<label for="nit">Dirección</label>
									<input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección del cobrador" value="<?php echo $collector['address'] ?>">
                                  </div>
                                  <div class="form-group">
									<label for="nit">Teléfono</label>
									<input type="text" class="form-control" id="telefono" name="telefono" placeholder="Teléfono del cobrador" value="<?php echo $collector['mobile'] ?>">
                                  </div>
                                  <div class="form-group">
									<label for="nit">Fecha de Nacimiento</label>
                                    <?php  $bday = date_create($collector['birthDate']); ?>
									<input type="text" class="form-control" name="singledatepicker" value="<?php echo date_format($bday, 'd/m/Y'); ?>"/>
								  </div>
								  <input type="hidden" name="cobrador" value="editar">
                                  <input type="hidden" name="idCobrador" value="<?php echo $id; ?>">
								  <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
								  <span class="text-danger"> *Debe llenar los campos obligatorios </span>
								</form>
							</div>							
						</div><!-- end card-->					
                    </div>
				</div>
			</div>
		</div>
		<!-- END container-fluid -->
	</div>
	<!-- END content -->
</div>
<!-- END content-page -->

<?php
	include_once 'templates/footer.php';
?>