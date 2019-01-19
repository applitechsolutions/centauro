$(document).ready(function () {

    var id_pago = 0;

    $('#form-diario').on('submit', function (e) {
        e.preventDefault();
        tabla();

        swal({
            title: 'Guardando pagos...'
        });
        swal.showLoading();
        var datos = $(this).serializeArray();

        var fechapago = document.getElementsByClassName("fechaP_class");
        var tarjeta = document.getElementsByClassName("tarjetaP_class")
        var monto = document.getElementsByClassName("montoP_class");


        var json = "";
        var i;


        for (i = 0; i < fechapago.length; i++) {
            json += ',{"date":"' + fechapago[i].value + '"'
            json += ',"code":"' + tarjeta[i].value + '"'
            json += ',"amount":"' + monto[i].value + '"}'
        }
        obj = JSON.parse('{ "pago" : [' + json.substr(1) + ']}');
        datos.push({ name: 'json', value: JSON.stringify(obj) });

        console.log(datos);

        $.ajax({
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            dataType: 'json',
            success: function (data) {
                console.log(data);
                var resultado = data;
                swal.close();
                if (resultado.respuesta == 'exito') {
                    swal(
                        'Exito!',
                        '¡' + resultado.mensaje,
                        'success'
                    )
                    if (resultado.proceso == 'nuevo') {
                        setTimeout(function () {
                            location.reload();
                        }, 1500);
                    } else if (resultado.proceso == 'editado') {
                        setTimeout(function () {
                            //window.location.href = 'listTenants.php';
                        }, 1500);
                    }
                } else if (resultado.respuesta == 'vacio') {
                    swal({
                        type: 'warning',
                        title: 'Oops...',
                        text: 'Debe llenar todos los campos',
                    })
                } else if (resultado.respuesta == 'error') {
                    swal({
                        type: 'error',
                        title: 'Error',
                        text: 'No se pudo guardar en la base de datos',
                    })
                }
            }
        })
    });

    $('.agregar_diario').on('click', function (e) {
        e.preventDefault();

        var fechapago = $('#date').val();
        var tarjeta = $('#code').val();
        var monto = $('#amount').val();
        console.log(id_pago);

        $('.counter').counterUp({
            delay: 10,
            time: 1000
        });

        if ($('#fechapago').val() != '' && $('#monto').val() != '') {
            var nuevaFila = "<tr id='detalle'>";
            nuevaFila += "<td><input class='fechaP_class' type='hidden' value='" + fechapago + "'>" + fechapago + "</td>";
            nuevaFila += "<td><input class='tarjetaP_class' type='hidden' value='" + tarjeta + "'>" + tarjeta + "</td>";
            nuevaFila += "<td><input class='montoP_class' type='hidden' value='" + monto + "'>" + monto + "</td>";
            nuevaFila += "<td><a role='button' href='#' onclick='eliminar(" + id_pago + ");' data-id-detalle='" + id_pago + "'class='btn btn-danger'><i class='fa fa-times'></i></a></td>";
            nuevaFila += "</tr>";
            $("#pagos").append(nuevaFila);
            id_pago = id_pago + 1;
            $('#code').val("");
            $('#code').focus();
            $('#amount').val("");
        } else {
            swal({
                type: 'warning',
                title: 'Oops...',
                text: 'Debe agregar una cantidad de pago',
            })
        }

    });

    $('#amount').on('keypress', function (e) {
        var k = e.keyCode || e.which;
        if (k == 13) {
            var fechapago = $('#date').val();
            var tarjeta = $('#code').val();
            var monto = $('#amount').val();
            console.log(id_pago);
    
            $('.counter').counterUp({
                delay: 10,
                time: 1000
            });
    
            if ($('#fechapago').val() != '' && $('#monto').val() != '') {
                var nuevaFila = "<tr id='detalle'>";
                nuevaFila += "<td><input class='fechaP_class' type='hidden' value='" + fechapago + "'>" + fechapago + "</td>";
                nuevaFila += "<td><input class='tarjetaP_class' type='hidden' value='" + tarjeta + "'>" + tarjeta + "</td>";
                nuevaFila += "<td><input class='montoP_class' type='hidden' value='" + monto + "'>" + monto + "</td>";
                nuevaFila += "<td><a role='button' href='#' onclick='eliminar(" + id_pago + ");' data-id-detalle='" + id_pago + "'class='btn btn-danger'><i class='fa fa-times'></i></a></td>";
                nuevaFila += "</tr>";
                $("#pagos").append(nuevaFila);
                id_pago = id_pago + 1;
                $('#code').val("");
                $('#code').focus();
                $('#amount').val("");
            } else {
                swal({
                    type: 'warning',
                    title: 'Oops...',
                    text: 'Debe agregar una cantidad de pago',
                })
            }
            return false;
        } 
    });

});

function eliminar(id) {
    jQuery('[data-id="' + id + '"]').attr('hidden', false);
    jQuery('[data-id-detalle="' + id + '"]').parents('#detalle').remove();
}


function tabla() {
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