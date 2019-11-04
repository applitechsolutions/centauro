$(document).ready(function() {

    $('#form-cliente').on('submit', function(e) {
        e.preventDefault();

        var datos = $(this).serializeArray();

        $.ajax({
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            dataType: 'json',
            success: function(data) {
                console.log(data);
                var resultado = data;
                if (resultado.respuesta == 'exito') {
                    swal(
                        'Exito!',
                        '¡' + resultado.mensaje,
                        'success'
                    )
                    if (resultado.proceso == 'nuevo') {
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else if (resultado.proceso == 'editado') {
                        setTimeout(function() {
                            window.location.href = 'listCustomers.php';
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
            },
            error: function(data) {
                swal({
                    position: 'top-end',
                    type: 'error',
                    title: 'Algo salió mal, intenta de nuevo',
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        })

    });

    $('#form-commerce').on('submit', function(e) {

        e.preventDefault();

        var datos = $(this).serializeArray();

        $.ajax({
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            dataType: 'json',
            success: function(data) {
                console.log(data);
                var resultado = data;
                if (resultado.respuesta == 'exito') {
                    swal({
                        position: 'top-end',
                        type: 'success',
                        title: '¡' + resultado.mensaje,
                        showConfirmButton: false,
                        timer: 1000
                    })
                    document.getElementById("form-commerce").reset();
                    $("#comClose").click();
                    getCommerce();
                } else if (resultado.respuesta == 'vacio') {
                    swal({
                        position: 'top-end',
                        type: 'warning',
                        title: 'Debes llenar los campos obligatorios :/',
                        showConfirmButton: false,
                        timer: 1500
                    })
                } else if (resultado.respuesta == 'error') {
                    swal({
                        position: 'top-end',
                        type: 'error',
                        title: 'No se pudo guardar en la base de datos',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            },
            error: function(data) {
                swal({
                    position: 'top-end',
                    type: 'error',
                    title: 'Algo salió mal, intenta de nuevo',
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        })

    });

    $('.borrar_cliente').on('click', function(e) {
        e.preventDefault();

        var id = $(this).attr('data-id');
        var tipo = $(this).attr('data-tipo');

        swal({
            title: '¿Estás Seguro?',
            text: "Un registro eliminado no puede recuperarse",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, Eliminar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            $.ajax({
                type: 'POST',
                data: {
                    'id': id,
                    'cliente': 'eliminar'
                },
                url: 'BLL/' + tipo + '.php',
                success(data) {
                    console.log(data);
                    var resultado = JSON.parse(data);
                    if (resultado.respuesta == 'exito') {
                        swal(
                            'Eliminado!',
                            'El cliente ha sido borrado con exito.',
                            'success'
                        )
                        jQuery('[data-id="' + resultado.idCliente + '"]').parents('tr').remove();
                    } else {
                        swal({
                            type: 'error',
                            title: 'Error!',
                            text: 'No se pudo eliminar al cliente.'
                        })
                    }
                },
                error: function(data) {
                    swal({
                        position: 'top-end',
                        type: 'error',
                        title: 'Algo salió mal, intenta de nuevo',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            });
        });
    });

    $('.record').on('click', function(e) {
        e.preventDefault();
        $("#detallesR").find('tbody').html("");
        $("#pagadosR").find('tbody').html("");
        var id = $(this).attr('data-id');
        var tipo = $(this).attr('data-tipo');
        var cliente = $(this).attr('cliente');
        var comercio = $(this).attr('comercio');
        var cobrador = $(this).attr('cobrador');
        var ruta = $(this).attr('ruta');

        swal({
            title: 'Cargando balance de saldos...'
        });
        swal.showLoading();
        $.ajax({
            type: 'POST',
            data: {
                'idCustomer': id
            },
            url: 'BLL/' + tipo + '.php',
            success(data) {
                console.log(data);
                var totalRecord = 0;
                var totalBuenos = 0;
                var porcentaje = 0;
                $.each(data, function(key, registro) {
                    totalRecord = parseInt(totalRecord) + 1;
                    if (registro.cancel == 1) {
                        let date = new Date(registro.dateStart.replace(/-/g, '\/'));

                        let options = {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        };
                        var nuevaFila = "<tr>";
                        nuevaFila += "<td>" + registro.code + "</td>";
                        nuevaFila += "<td>" + date.toLocaleDateString('es-MX', options); + "</td>";
                        nuevaFila += "<td><h6>Q." + registro.total + "</h6></td>";
                        if (registro.record == 1) {
                            var diferencia = parseInt(registro.diff) - 30;
                            nuevaFila += "<td><div class='alert alert-danger' role='alert'><strong>¡RIESGO! Cliente Malo</strong> se retrasó " + diferencia + " días en cancelar</div></td>";
                        } else {
                            totalBuenos = parseInt(totalBuenos) + 1;
                            nuevaFila += "<td><div class='alert alert-success' role='alert'><strong>¡SEGURO! Cliente Bueno</strong pago en " + registro.diff + "></div></td>";
                        }
                        nuevaFila += "</tr>";
                        $("#pagadosR").append(nuevaFila);
                    } else {
                        let date = new Date(registro.dateStart.replace(/-/g, '\/'));

                        let options = {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        };
                        var nuevaFila = "<tr>";
                        nuevaFila += "<td>" + registro.code + "</td>";
                        nuevaFila += "<td>" + date.toLocaleDateString('es-MX', options); + "</td>";
                        nuevaFila += "<td><h6>Q." + registro.total + "</h6></td>";
                        if (registro.diff > 30) {
                            var d = new Date();
                            var fecha1 = moment(registro.datepay);
                            var fecha2 = moment(d);

                            var differencia = fecha2.diff(fecha1, 'days');
                            let date = new Date(registro.datepay.replace(/-/g, '\/'));

                            let options = {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            };
                            nuevaFila += "<td><div class='alert alert-danger' role='alert'><strong>¡RIESGO! Cliente atrasado </strong>" + differencia + " días atrasado desde el último pago (" + date.toLocaleDateString('es-MX', options) + ")</div></td>";
                        } else if (registro.diff > 0 && registro.diff <= 30) {
                            var difference = 30 - parseInt(registro.diff);
                            totalBuenos = parseInt(totalBuenos) + 1;
                            nuevaFila += "<td><div class='alert alert-primary' role='alert'><strong>¡PAGANDO! Cliente activo </strong> aún tiene " + difference + " para cancelar el crédito</div></td>";
                        } else if (registro.diff == 0) {
                            var d = new Date();
                            var fecha1 = moment(registro.datepay);
                            var fecha2 = moment(d);

                            var differencia = fecha2.diff(fecha1, 'days');

                            if (differencia <= 30) {
                                var difference = 30 - parseInt(differencia);
                                totalBuenos = parseInt(totalBuenos) + 1;
                                nuevaFila += "<td><div class='alert alert-primary' role='alert'><strong>¡PAGANDO! Cliente activo </strong> aún tiene " + difference + " días para cancelar el crédito</div></td>";
                            } else {
                                var difference = parseInt(differencia) - 30;
                                nuevaFila += "<td><div class='alert alert-danger' role='alert'><strong>¡RIESGO! Cliente atrasado </strong>" + difference + " días atrasado desde que venció el plazo</div></td>";
                            }
                        }

                        nuevaFila += "</tr>";
                        $("#detallesR").append(nuevaFila);
                    }
                });
                porcentaje = (parseFloat(totalBuenos) * 100) / parseFloat(totalRecord);
                if (porcentaje < 50) {
                    $('.percent').addClass('bg-warning').removeClass('bg-success');
                } else {
                    $('.percent').addClass('bg-success').removeClass('bg-warning');
                }
                swal.close();
                $('.recordPer').text(porcentaje.toFixed());
                $('.card-comercio').text(comercio);
                $('.card-title').text(cliente);
                $('.card-text').text(ruta);
                $('.card-cobrador').text('Cobrador: ' + cobrador);
                $('#record').modal('show');
            },
            error: function(data) {
                swal({
                    type: 'error',
                    title: 'Error',
                    text: 'No se puede cargar el balance de saldos',
                })
            }
        });
    });

});

function getCommerce() {
    $("#_idCommerce").html("");
    $("#_idCommerce").append('<option value="">Seleccione un negocio</option>');
    $.ajax({
        type: "GET",
        url: 'BLL/listCommerce.php',
        dataType: "json",
        success: function(data) {
            console.log(data);
            $.each(data, function(key, registro) {
                $("#_idCommerce").append('<option value=' + registro.idCommerce + ' selected>' + registro.name + '</option>');
            });
        },
        error: function(data) {
            alert('error');
        }
    });
}