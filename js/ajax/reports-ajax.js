$(document).ready(function () {

    $('#form-rpt1').on('submit', function (e) {
        e.preventDefault();
        limpiarReportes();

        var tabla = '<div class="table-responsive">'+
                '<table id="example2" class="table table-bordered table-hover display">'+
                    '<thead>'+
                        '<tr>'+
                            '<th>No. de tarjeta</th>'+
                            '<th>Fecha de Inicio</th>'+
                            '<th>Cliente</th>'+
                            '<th>Comercio</th>'+
                            '<th>Ruta</th>'+
                            '<th>Saldo</th>'+
                        '</tr>'+
                    '</thead>'+
                    '<tbody class="contenido"></tbody>'+
                '</table>'+
            '</div>'+
            '<div class="row">'+
            '<button type="button" onclick="printReport1()" class="btn bg-teal-active btn-md"><i class="fas fa-print"></i>'+
            ' Imprimir</button>';

        $("#listadoReporte1").append(tabla);
        var datos = $(this).serializeArray();

        swal({
            title: 'Generando el reporte...'
        });
        swal.showLoading();

        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: datos,
            dataType: "json",
            success: function (data) {
                console.log(data);
                $.each(data, function (key, registro) { 
                    var contenido = "<tr>";
                    contenido += "<td>" + registro.code + "</td>";
                    contenido += "<td>" + convertDate(registro.dateStart) + "</td>";
                    contenido += "<td>" + registro.customer + "</td>";
                    contenido += "<td>" + registro.commerce + "</td>";
                    contenido += "<td>" + registro.route + "</td>";
                    contenido += "<td>Q. " + registro.total + "</td>";
                    contenido += "</tr>";
                    $(".contenido").append(contenido);
                });
                Example2();
                swal.close();
            }, 
            error: function (data) {
                swal({
                    type: 'error',
                    title: 'Error',
                    text: 'Algo ha salido mal, intentalo más tarde',
                })
            }
        });
    });

    $('#form-rpt2').on('submit', function (e) {
        e.preventDefault();
        limpiarReportes();

        var tabla = '<div class="table-responsive">'+
                '<table id="example2" class="table table-bordered table-hover display">'+
                    '<thead>'+
                        '<tr>'+
                            '<th>No. de tarjeta</th>'+
                            '<th>Fecha de Inicio</th>'+
                            '<th>Cliente</th>'+
                            '<th>Comercio</th>'+
                            '<th>Ruta</th>'+
                            '<th>Total</th>'+
                            '<th>Fecha de Cancelación</th>'+
                        '</tr>'+
                    '</thead>'+
                    '<tbody class="contenido2"></tbody>'+
                '</table>'+
            '</div>'+
            '<div class="row">'+
            '<button type="button" onclick="printReport2()" class="btn bg-teal-active btn-md"><i class="fas fa-print"></i>'+
            ' Imprimir</button>';

        $("#listadoReporte2").append(tabla);
        var datos = $(this).serializeArray();

        swal({
            title: 'Generando el reporte...'
        });
        swal.showLoading();

        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: datos,
            dataType: "json",
            success: function (data) {
                console.log(data);
                $.each(data, function (key, registro) { 
                    var contenido = "<tr>";
                    contenido += "<td>" + registro.code + "</td>";
                    contenido += "<td>" + convertDate(registro.dateStart) + "</td>";
                    contenido += "<td>" + registro.customer + "</td>";
                    contenido += "<td>" + registro.commerce + "</td>";
                    contenido += "<td>" + registro.route + "</td>";
                    contenido += "<td>Q. " + registro.total + "</td>";
                    contenido += "<td>" + convertDate(registro.fechaP) + "</td>";
                    contenido += "</tr>";
                    $(".contenido2").append(contenido);
                });
                Example2();
                swal.close();
            }, 
            error: function (data) {
                swal({
                    type: 'error',
                    title: 'Error',
                    text: 'Algo ha salido mal, intentalo más tarde',
                })
            }
        });
    });
});

function limpiarReportes() {
    $("#listadoReporte1").html("");
    $("#listadoReporte2").html("");
}

function Example2() {
    $('#example2').DataTable({
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
}

function printReport1() {
    var idCollector = $("[name='idCollector']").val();
    changeReport('CustByCol.php?idCobrador='+idCollector);
    $('#ModalReporte').modal('show');
}

function printReport2() {
    var idCollector = $("[name='idCollectorRPT2']").val();
    var fechaInicio = $("[name='singledatepicker']").val();
    var fechaFinal = $("[name='singledatepicker2']").val();
    console.log(fechaInicio);
    changeReport('Credits.php?idCobrador='+idCollector+'&fecha1='+fechaInicio+'&fecha2='+fechaFinal);
    $('#ModalReporte').modal('show');
}