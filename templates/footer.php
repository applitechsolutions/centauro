<footer class="footer">
    <span class="text-right">
        Copyright <a target="_blank" href="#">Centauro Créditos</a>
    </span>
    <span class="float-right">
        Powered by <a target="_blank" href="#"><b>APPLITECH SOFTWARE SOLUTIONS</b></a>
    </span>
</footer>

</div>
<!-- END main -->

<script src="js/sweetalert2.min.js">
</script>
<script src="js/modernizr.min.js">
</script>
<script src="js/jquery.min.js">
</script>
<script src="js/moment.min.js">
</script>

<script src="js/popper.min.js">
</script>
<script src="js/bootstrap.min.js">
</script>

<script src="js/detect.js">
</script>
<script src="js/fastclick.js">
</script>
<script src="js/jquery.blockUI.js">
</script>
<script src="js/jquery.nicescroll.js">
</script>

<!-- App js -->
<script src="js/pikeadmin.js">
</script>

<!-- BEGIN Java Script for this page -->
<script src="plugins\chart.js\chart.min.js">
</script>
<script src="plugins\datatables\jquery.dataTables.min.js">
</script>
<script src="plugins\datatables\dataTables.bootstrap4.min.js">
</script>

<!-- Counter-Up-->
<script src="plugins/waypoints/lib/jquery.waypoints.min.js">
</script>
<script src="plugins/counterup/jquery.counterup.min.js">
</script>
<script src="plugins/datetimepicker/js/moment.min.js"></script>
<script src="plugins/datetimepicker/js/daterangepicker.js"></script>
<script src="plugins/select2/js/select2.min.js"></script>

<!-- AJAX DE LOS MODULOS -->
<script src="js/ajax/collector-ajax.js"></script>
<script src="js/ajax/customer-ajax.js"></script>
<script src="js/ajax/user-ajax.js"></script>
<script src="js/ajax/route-ajax.js"></script>
<script src="js/ajax/credit-ajax.js"></script>
<script src="js/ajax/income-ajax.js"></script>

<script>
$(document).ready(function() {
    // elementos de la lista
    $('.select2').select2();
    // data-tables
    $('#example1').DataTable({
        'paging': true,
        'lengthChange': true,
        "aLengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        'searching': true,
        'ordering': true,
        'info': true,
        'autoWidth': true,
        'language': {
            paginate: {
                next: 'Siguiente',
                previous: 'Anterior',
                first: 'Primero',
                last: 'Último'
            },
            info: 'Mostrando _START_-_END_ de _TOTAL_ registros',
            empyTable: 'No hay registros',
            infoEmpty: '0 registros',
            lengthChange: 'Mostrar ',
            infoFiltered: "(Filtrado de _MAX_ total de registros)",
            lengthMenu: "Mostrar _MENU_ registros",
            loadingRecords: "Cargando...",
            processing: "Procesando...",
            search: "Buscar:",
            zeroRecords: "Sin resultados encontrados"
        }
    });

    // counter-up
    $('.counter').counterUp({
        delay: 10,
        time: 600
    });
});
$(function() {
    $('input[name="singledatepicker"], input[name="singledatepicker2"]').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: {
            format: 'DD/MM/YYYY'
        }
    });
});
</script>
<!-- END Java Script for this page -->

</body>

</html>