$(document).ready(function () {

    var id_referencia = 0;

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

    $('.agregar_referencia').on('click', function (e) {
        e.preventDefault();

        var nombre = $('#nombreR').val();
        var direccion = $('#direccionR').val();
        var tel = $('#tel').val();
        console.log(id_referencia);

        if ($('#nombreR').val() != '' || $('#direccionR').val() != '' || $('#tel').val() != '') {
            var nuevaFila = "<tr id='detalle'>";
            nuevaFila += "<td><input class='nombreR_class' type='hidden' value='" + nombre + "'>" + nombre + "</td>";
            nuevaFila += "<td><input class='direccionR_class' type='hidden' value='" + direccion + "'>" + direccion + "</td>";
            nuevaFila += "<td><input class='telR_class' type='hidden' value='" + tel + "'>" + tel + "</td>";
            nuevaFila += "<td><a role='button' href='#'  onclick='eliminar(" + id_referencia + ");' data-id-detalle='" + id_referencia + "'class='btn btn-danger'><i class='fa fa-times'></i></a></td>";
            nuevaFila += "</tr>";
            $("#agregados").append(nuevaFila);
            id_referencia = id_referencia + 1;
            $('#nombreR').val("");
            $('#direccionR').val("");
            $('#tel').val("");
        } else {
            swal({
                type: 'warning',
                title: 'Oops...',
                text: 'Los campos de la referencia están vacíos.',
            })
        }

    });
});