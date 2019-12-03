$(document).ready(function() {

    var id_pago = 0;

    $('#fechapago').blur(function() {
        $('#monto').focus();
    });

    $('#fechaBalance').blur(function() {
        $('#amountPay').focus();
    });

    $('#form-credito').on('submit', function(e) {
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
            },
            error: function(data) {
                swal({
                    type: 'error',
                    title: 'Error',
                    text: 'No se puede cargar el balance de saldos',
                })
            }
        })

    });

    $('.borrar_credito').on('click', function(e) {

        e.preventDefault();

        var id = $(this).attr('data-id');
        var tipo = $(this).attr('data-tipo');
        var table = $('#example1').DataTable();
        var $row = $(this);

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
                    'credito': 'eliminar'
                },
                url: 'BLL/' + tipo + '.php',
                success(data) {
                    console.log(data);
                    var resultado = JSON.parse(data);
                    if (resultado.respuesta == 'exito') {
                        swal(
                            'Eliminado!',
                            'El crédito ha sido borrado con exito.',
                            'success'
                        );
                        table.row($row.parents('tr')).remove().draw();
                    } else {
                        swal({
                            type: 'error',
                            title: 'Error!',
                            text: 'No se pudo eliminar el crédito.'
                        });
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

    $('#form-pay').on('submit', function(e) {
        e.preventDefault();

        var saldoR = $("#totalB").val();
        var pago = $("#amountPay").val();


        var datos = $(this).serializeArray();
        console.log(datos);
        swal({
            title: 'Ingresando pago...'
        });
        swal.showLoading();
        $.ajax({
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            datatype: 'json',
            success: function(data) {
                console.log(data);
                var resultado = JSON.parse(data);
                if (resultado.respuesta == 'exito') {
                    document.getElementById("form-pay").reset();
                    $('#balance').modal('toggle');
                    swal.close();
                    swal({
                        position: 'top-end',
                        type: 'success',
                        title: '¡' + resultado.mensaje,
                        showConfirmButton: false,
                        timer: 1000
                    })
                    if (resultado.cancelada == 1) {
                        setTimeout(function() {
                            window.location.href = 'listCredits.php';
                        }, 1500);
                    }
                } else if (resultado.respuesta == 'vacio') {
                    swal({
                        type: 'warning',
                        title: 'Oops...',
                        text: 'No se han podido procesar los datos',
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

    $('.agregar_pago').on('click', function(e) {

        e.preventDefault();

        var fechapago = $('#fechapago').val();
        var monto = $('#monto').val();

        $('.counter').counterUp({
            delay: 10,
            time: 1000
        });

        if ($('#fechapago').val() != '' && $('#monto').val() != '') {
            var nuevaFila = "<tr id='detalle'>";
            nuevaFila += "<td><input class='fechaP_class' type='hidden' value='" + fechapago + "'>" + fechapago + "</td>";
            nuevaFila += "<td><input class='montoP_class' type='hidden' value='" + monto + "'>" + monto + "</td>";
            nuevaFila += "<td><a role='button' href='#'  onclick='eliminar(" + id_pago + ");' data-id-detalle='" + id_pago + "'class='btn btn-danger'><i class='fa fa-times'></i></a></td>";
            nuevaFila += "</tr>";
            $("#agregados").append(nuevaFila);
            id_pago = id_pago + 1;
            $('#fechapago').val("");
            $('#fechapago').focus();
            $('#monto').val("");
        } else {
            swal({
                type: 'warning',
                title: 'Oops...',
                text: 'Los campos de la referencia están vacíos.',
            })
        }

    });

    $('#monto').on('keypress', function(e) {
        var k = e.keyCode || e.which;
        if (k == 13) {
            var fechapago = $('#fechapago').val();
            var monto = $('#monto').val();

            if ($('#fechapago').val() != '' && $('#monto').val() != '') {
                var nuevaFila = "<tr id='detalle'>";
                nuevaFila += "<td><input class='fechaP_class' type='hidden' value='" + fechapago + "'>" + fechapago + "</td>";
                nuevaFila += "<td><input class='montoP_class' type='hidden' value='" + monto + "'>" + monto + "</td>";
                nuevaFila += "<td><a role='button' href='#' onclick='eliminar(" + id_pago + ");' data-id-detalle='" + id_pago + "'class='btn btn-danger'><i class='fa fa-times'></i></a></td>";
                nuevaFila += "</tr>";
                $("#agregados").append(nuevaFila);
                id_pago = id_pago + 1;
                $('#fechapago').val("");
                $('#fechapago').focus();
                $('#monto').val("");
            } else {
                swal({
                    type: 'warning',
                    title: 'Oops...',
                    text: 'Los campos de la referencia están vacíos.',
                })
            }
            return false;
        }
    });

    $('#form-historial').on('submit', function(e) {
        e.preventDefault();
        $.fn.dataTable.moment('DD/MM/YYYY');
        $('#example2').DataTable({
            "bDestroy": true,
            'paging': false
        });

        swal({
            title: 'Guardando crédito...'
        });
        swal.showLoading();
        var datos = $(this).serializeArray();

        var fechapago = document.getElementsByClassName("fechaP_class");
        var monto = document.getElementsByClassName("montoP_class");

        var json = "";
        var i;


        for (i = 0; i < fechapago.length; i++) {
            json += ',{"date":"' + fechapago[i].value + '"'
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
            success: function(data) {
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
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else if (resultado.proceso == 'editado') {
                        setTimeout(function() {
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

    $('.detalle_balance').on('click', function(e) {
        e.preventDefault();
        $("#detallesB").find('tbody').html("");
        $("#anuladosB").find('tbody').html("");
        var id = $(this).attr('data-id');
        var tipo = $(this).attr('data-tipo');

        swal({
            title: 'Cargando balance de saldos...'
        });
        swal.showLoading();
        $.ajax({
            type: 'POST',
            data: {
                'idCredito': id
            },
            url: 'BLL/' + tipo + '.php',
            success(data) {
                console.log(data);
                var totalBal = 0;
                var bandera = 0;
                $.each(data, function(key, registro) {
                    if (registro.state == 1) {
                        var nuevaFila = "<tr>";
                        let date = new Date(registro.date.replace(/-/g, '\/'));

                        let options = {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        };

                        nuevaFila += "<td>" + date.toLocaleDateString('es-MX', options); + "</td>";
                        if (registro.balpay == 1) {
                            nuevaFila += "<td><div class='alert alert-primary' role='alert'>Pago</div></td>";
                        } else {
                            nuevaFila += "<td><div class='alert alert-danger' role='alert'>Saldo</div></td>";
                        }
                        nuevaFila += "<td><h6>Q." + registro.amount + "</h6></td>";
                        nuevaFila += "</tr>";
                        $("#anuladosB").append(nuevaFila);
                    } else {
                        var nuevaFila = "<tr>";
                        if (bandera == 0) {
                            totalBal = parseFloat(registro.balance);
                            bandera = 1;
                        }
                        let date = new Date(registro.date.replace(/-/g, '\/'));

                        let options = {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        };

                        nuevaFila += "<td>" + date.toLocaleDateString('es-MX', options); + "</td>";
                        if (registro.balpay == 1) {
                            nuevaFila += "<td><div class='alert alert-primary' role='alert'>Pago</div></td>";
                        } else {
                            nuevaFila += "<td><div class='alert alert-danger' role='alert'>Saldo</div></td>";
                        }
                        nuevaFila += "<td><h6>Q." + registro.amount + "</h6></td>";
                        nuevaFila += "<td><h6>Q." + registro.balance + "</h6></td>";

                        if (registro.balpay == 1) {
                            nuevaFila += "<td><a role='button' href='#' class='btn btn-danger' onclick='anularPago(" + id + "," + registro.idBalance + ")'><i class='fa fa-times'></i></a></td>";
                        } else {
                            nuevaFila += "<td></td>";
                        }


                        nuevaFila += "</tr>";
                        $("#detallesB").append(nuevaFila);
                    }
                });
                $(".totalBal").text(totalBal.toFixed(2));
                $("#totalB").val(totalBal.toFixed(2));
                $("#idCredito").val(id);
                swal.close();
                $('#balance').modal('show');
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

    $('.detalle_balanceC').on('click', function(e) {
        e.preventDefault();
        $("#detallesBC").find('tbody').html("");
        $("#anuladosBC").find('tbody').html("");
        var id = $(this).attr('data-id');
        var tipo = $(this).attr('data-tipo');

        swal({
            title: 'Cargando balance de saldos...'
        });
        swal.showLoading();
        $.ajax({
            type: 'POST',
            data: {
                'idCredito': id
            },
            url: 'BLL/' + tipo + '.php',
            success(data) {
                console.log(data);
                var bandera = 0;
                $.each(data, function(key, registro) {
                    if (registro.state == 1) {
                        var nuevaFila = "<tr>";
                        let date = new Date(registro.date.replace(/-/g, '\/'));

                        let options = {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        };

                        nuevaFila += "<td>" + date.toLocaleDateString('es-MX', options); + "</td>";
                        if (registro.balpay == 1) {
                            nuevaFila += "<td><div class='alert alert-primary' role='alert'>Pago</div></td>";
                        } else {
                            nuevaFila += "<td><div class='alert alert-danger' role='alert'>Saldo</div></td>";
                        }
                        nuevaFila += "<td><h6>Q." + registro.amount + "</h6></td>";
                        nuevaFila += "</tr>";
                        $("#anuladosBC").append(nuevaFila);
                    } else {
                        var nuevaFila = "<tr>";
                        if (bandera == 0) {
                            totalBal = parseFloat(registro.balance);
                            bandera = 1;
                        }
                        let date = new Date(registro.date.replace(/-/g, '\/'));

                        let options = {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        };

                        nuevaFila += "<td>" + date.toLocaleDateString('es-MX', options); + "</td>";
                        if (registro.balpay == 1) {
                            nuevaFila += "<td><div class='alert alert-primary' role='alert'>Pago</div></td>";
                        } else {
                            nuevaFila += "<td><div class='alert alert-danger' role='alert'>Saldo</div></td>";
                        }
                        nuevaFila += "<td><h6>Q." + registro.amount + "</h6></td>";
                        nuevaFila += "<td><h6>Q." + registro.balance + "</h6></td>";
                        nuevaFila += "</tr>";
                        $("#detallesBC").append(nuevaFila);
                    }
                });
                swal.close();
                $('#balanceC').modal('show');
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

function listCustomer2() {
    var idCollector = $('#idCollector').val();

    $("#idCustomer").html("");
    $("#idCustomer").append('<option value="">Seleccione un cliente</option>');
    $.ajax({
        type: "GET",
        url: 'BLL/listCustomer2.php',
        dataType: "json",
        success: function(data) {
            console.log(data);
            $.each(data, function(key, registro) {
                if (registro.idCollector == idCollector) {
                    $("#idCustomer").append('<option value=' + registro.idCustomer + '>' + registro.customer + ' (' + registro.commerce + ')' + '</option>');
                }
            });
        },
        error: function(data) {
            alert('error');
        }
    });
}

function anularPago(idCredit, idBalance) {

    swal({
        title: '¿Estás Seguro?',
        text: "Anular el pago hará que cambie el balance de saldos",
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
                'idBalance': idBalance,
                'idCredit': idCredit,
                'tipo': 'anular'
            },
            url: 'BLL/balance.php',
            success(data) {
                console.log(data);
                var resultado = JSON.parse(data);
                if (resultado.respuesta == 'exito') {
                    $("#detallesB").find('tbody').html("");
                    $("#anuladosB").find('tbody').html("");
                    $.ajax({
                        type: 'POST',
                        data: {
                            'idCredito': idCredit
                        },
                        url: 'BLL/listBalance.php',
                        success(data) {
                            console.log(data);
                            var totalBal = 0;
                            var bandera = 0;
                            $.each(data, function(key, registro) {
                                if (registro.state == 1) {
                                    var nuevaFila = "<tr>";
                                    nuevaFila += "<td>" + convertDate(registro.date); + "</td>";
                                    if (registro.balpay == 1) {
                                        nuevaFila += "<td><div class='alert alert-primary' role='alert'>Pago</div></td>";
                                    } else {
                                        nuevaFila += "<td><div class='alert alert-danger' role='alert'>Saldo</div></td>";
                                    }
                                    nuevaFila += "<td><h6>Q." + registro.amount + "</h6></td>";
                                    nuevaFila += "</tr>";
                                    $("#anuladosB").append(nuevaFila);
                                } else {
                                    var nuevaFila = "<tr>";
                                    if (bandera == 0) {
                                        totalBal = parseFloat(registro.balance);
                                        bandera = 1;
                                    }
                                    let date = new Date(registro.date);

                                    let options = {
                                        year: 'numeric',
                                        month: 'long',
                                        day: 'numeric'
                                    };

                                    nuevaFila += "<td>" + date.toLocaleDateString('es-MX', options); + "</td>";
                                    if (registro.balpay == 1) {
                                        nuevaFila += "<td><div class='alert alert-primary' role='alert'>Pago</div></td>";
                                    } else {
                                        nuevaFila += "<td><div class='alert alert-danger' role='alert'>Saldo</div></td>";
                                    }
                                    nuevaFila += "<td><h6>Q." + registro.amount + "</h6></td>";
                                    nuevaFila += "<td><h6>Q." + registro.balance + "</h6></td>";
                                    nuevaFila += "<td><a role='button' href='#' class='btn btn-danger' onclick='anularPago(" + idCredit + "," + registro.idBalance + ")'><i class='fa fa-times'></i></a></td>";

                                    nuevaFila += "</tr>";
                                    $("#detallesB").append(nuevaFila);
                                }
                            });
                            $(".totalBal").text(totalBal.toFixed(2));
                            $("#totalB").val(totalBal.toFixed(2));
                            $("#idCredito").val(idCredit);
                        },
                        error: function(data) {
                            swal({
                                type: 'error',
                                title: 'Error',
                                text: 'No se puede agregar al carrito',
                            })
                        }
                    });
                } else {
                    swal({
                        type: 'error',
                        title: 'Error!',
                        text: 'No se pudo anular el pago.'
                    })
                }
            }
        });
    });
}

function eliminar(id) {
    jQuery('[data-id="' + id + '"]').attr('hidden', false);
    jQuery('[data-id-detalle="' + id + '"]').parents('#detalle').remove();
}