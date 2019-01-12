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
						<h1 class="main-title float-left">Cobradores</h1>
						<ol class="breadcrumb float-right">
						</ol>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<!-- end row -->
			<div class="row">
				<div class="col-xl-12">
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-8 col-xl-8">						
						<div class="card mb-3">
							<div class="card-header">
								<h3><i class="fa fa-automobile"></i> Nuevo Cobrador</h3>
								Complete el formulario para ingresar un nuevo cobrador.
							</div>
							<div class="card-body">
								<form autocomplete="on" role="form" id="form-cobrador" name="form-cobrador" method="POST" action="BLL/collector.php">
								  <div class="form-group">
									<label for="nombre">Nombre<span class="text-danger">*</span></label>
									<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del cobrador" autofocus>
								  </div>
								  <div class="form-group">
									<label for="nit">Apellido<span class="text-danger">*</span></label>
									<input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido del cobrador">
                                  </div>
								  <div class="form-group">
									<label for="nit">DPI<span class="text-danger">*</span></label>
									<input type="text" class="form-control" id="dpi" name="dpi" placeholder="DPI del cobrador">
                                  </div>
                                  <div class="form-group">
									<label for="nit">Dirección</label>
									<input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección del cobrador">
                                  </div>
                                  <div class="form-group">
									<label for="nit">Teléfono</label>
									<input type="text" class="form-control" id="telefono" name="telefono" placeholder="Teléfono del cobrador">
                                  </div>
                                  <div class="form-group">
									<label for="nit">Fecha de Nacimiento</label>
									<input type="text" class="form-control" name="singledatepicker"/>
								  </div>
								  <input type="hidden" name="cobrador" value="nuevo">
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