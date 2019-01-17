$(document).ready(function () {

    var id_pago = 0;

    //mǎ lóng gǎo zá le;

    $('#form-credito').on('submit', function (e) {
        e.preventDefault();

        var datos = $(this).serializeArray();

        $.ajax({
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            dataType: 'json',
            success: function (data) {
                console.log(data);
                var resultado = data;
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
                            window.location.href = 'listCredits.php';
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

    $('.agregar_pago').on('click', function (e) {
        e.preventDefault();

        var fechapago = $('#fechapago').val();
        var monto = $('#monto').val();
        console.log(id_pago);

        if ($('#fechapago').val() != '' && $('#monto').val() != '') {
            var nuevaFila = "<tr id='detalle'>";
            nuevaFila += "<td><input class='fechaP_class' type='hidden' value='" + fechapago + "'>" + fechapago + "</td>";
            nuevaFila += "<td><input class='montoP_class' type='hidden' value='" + monto + "'>" + monto + "</td>";
            nuevaFila += "<td><a role='button' href='#'  onclick='eliminar(" + id_pago + ");' data-id-detalle='" + id_pago + "'class='btn btn-danger'><i class='fa fa-times'></i></a></td>";
            nuevaFila += "</tr>";
            $("#agregados").append(nuevaFila);
            id_pago = id_pago + 1;
            $('#fechapago').val("");
            $('#monto').val("");
        } else {
            swal({
                type: 'warning',
                title: 'Oops...',
                text: 'Los campos de la referencia están vacíos.',
            })
        }

    });
});