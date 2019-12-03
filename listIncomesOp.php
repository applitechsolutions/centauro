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

        <!-- Modal REPORTE -->
            <div class="modal fade custom-modal" id="ModalReporte" tabindex="-1" role="dialog" aria-labelledby="customModal" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">Reporte</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <div id="divreporte" class="w3-rest">
                            <iframe src="" style="width: 100%; height: 700px; min-width: 300px;"></iframe>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        <!-- Modal REPORTE -->

            <div class="row">
                <div class="col-xl-12">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3><i class="fas fa-file-alt"></i> Reportes</h3>
                                Aquí puede generar los reportes necesarios.
                            </div>

                            <div class="card-body">
                                <div class="card text-center">
                                    <h4 class="box-title" style="margin-top: 10px;">Listado de ingresos en una fecha determinada</h4>
                                    <form autocomplete="off" role="form" id="form-IncomesOp" name="form-IncomesOp"
                                        method="POST" action="BLL/IncomesforOp.php">
                                        <br>
                                        <div class="row">
                                            <div class="form-group col-xl-2" style="margin-left: 30px;">
                                                <label for="date">Fecha Inicial<span class="text-danger">*</span></label>
                                                <input type="text" id="date" class="form-control"
                                                    name="singledatepicker" />
                                            </div>
                                            <div class="form-group col-xl-2">
                                            <br>
                                            <input type="hidden" name="collector" value=<?php echo $_SESSION['cobrador']; ?>>
                                            <button type="submit" class="btn btn-primary pull-left" style="margin-top: 8px;"><i class="fab fa-rev"></i>
                                                Generar Listado</button>
                                            </div>
                                            <div class="form-group col-xl-3">
                                                <div class="card-box noradius noborder bg-info">
                                                    <i class="fas fa-money-bill-alt float-right text-white"></i>
                                                    <h6 class="text-white text-uppercase m-b-20">Total Ingresos:</h6>
                                                    <h3 class="m-b-20 text-white counter totalIncomes">0.00</h3>
                                                    <span class="text-white">En Quetzales</span>
                                                </div>
                                            </div>
                                            <div class="card-body table-responsive">
                                                <table id="operative" class="table table-bordered table-hover display">
                                                    <thead>
                                                        <tr>
                                                            <th>No. Tarjeta</th>
                                                            <th>Fecha Inicio</th>
                                                            <th>Cliente</th>
                                                            <th>Total (Q.)</th>
                                                            <th>Pago (Q.)</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </form>
                                </div>
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