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
                    '<tbody class="contenido2"></tbody>'+
                '</table>'+
            '</div>';

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
                    contenido += "<td>" + registro.total + "</td>";
                    contenido += "</tr>";
                    $(".contenido2").append(contenido);
                    console.log($(".contenido2").append(contenido));
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
}

function convertDate(dateString) {
    var p = dateString.split(/\D/g)
    return [p[2], p[1], p[0]].join("-")
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