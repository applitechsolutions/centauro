$(document).ready(function () {

    var id_pago = 0;

    $('#form-diario').on('submit', function (e) {
        e.preventDefault();
        $('#example2').DataTable({
            'paging': false
        });

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
            }, 
            error: function (data) {
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

    $('#code').on('select2:close', function() {
        $('#amount').focus();
    });

    $('.agregar_diario').on('click', function (e) {
        e.preventDefault();

        var fechapago = $('#date').val();
        var codigo = $('#code').val();
        var tarjeta = $('#code option:selected').text();
        var monto = $('#amount').val();
        var ingresos = parseFloat($('.ingresos').text());
        var pagos = parseInt($('.pagos').text());
        console.log(ingresos);
        ingresos = ingresos + parseFloat(monto);
        pagos = pagos + 1;
        

        if ($('#date').val() != '' && $('#tarjeta') && $('#amount').val() != '') {
            var nuevaFila = "<tr id='detalle'>";
            nuevaFila += "<td><input class='fechaP_class' type='hidden' value='" + fechapago + "'>" + fechapago + "</td>";
            nuevaFila += "<td><input class='tarjetaP_class' type='hidden' value='" + codigo + "'>" + tarjeta + "</td>";
            nuevaFila += "<td><input class='montoP_class' type='hidden' value='" + monto + "'>" + monto + "</td>";
            nuevaFila += "<td><a role='button' href='#' onclick='eliminar(" + id_pago + ", "+ monto +");' data-id-detalle='" + id_pago + "'class='btn btn-danger'><i class='fa fa-times'></i></a></td>";
            nuevaFila += "</tr>";
            $("#pagos").append(nuevaFila);
            id_pago = id_pago + 1;
            $('#code').focus();
            $('#amount').val("");
            console.log(ingresos);
            $('.ingresos').text(ingresos.toFixed(2));
            $('#ingresos').val(ingresos.toFixed(2));
            $('.pagos').text(pagos);
            balance();
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
            var codigo = $('#code').val();
            var tarjeta = $('#code option:selected').text();
            var monto = $('#amount').val();
            var ingresos = parseFloat($('.ingresos').text());
            var pagos = parseInt($('.pagos').text());
            console.log(ingresos);
            ingresos = ingresos + parseFloat(monto);
            pagos = pagos + 1;
            
    
            if ($('#date').val() != '' && $('#tarjeta') && $('#amount').val() != '') {
                var nuevaFila = "<tr id='detalle'>";
                nuevaFila += "<td><input class='fechaP_class' type='hidden' value='" + fechapago + "'>" + fechapago + "</td>";
                nuevaFila += "<td><input class='tarjetaP_class' type='hidden' value='" + codigo + "'>" + tarjeta + "</td>";
                nuevaFila += "<td><input class='montoP_class' type='hidden' value='" + monto + "'>" + monto + "</td>";
                nuevaFila += "<td><a role='button' href='#' onclick='eliminar(" + id_pago + ", "+ monto +");' data-id-detalle='" + id_pago + "'class='btn btn-danger'><i class='fa fa-times'></i></a></td>";
                nuevaFila += "</tr>";
                $("#pagos").append(nuevaFila);
                id_pago = id_pago + 1;
                $('#code').focus();
                $('#amount').val("");
                console.log(ingresos);
                $('.ingresos').text(ingresos.toFixed(2));
                $('#ingresos').val(ingresos.toFixed(2));
                $('.pagos').text(pagos);
                balance();
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

function listCustomer() {
    var idCollector = $('#collector').val();
    var fecha = $('#dateIncome').val();
    console.log(fecha);

    $("#code").html("");
    $("#code").append('<option value="">Seleccione una tarjeta</option>');
    $.ajax({
        type: "GET",
        url: 'BLL/listCustomer.php',
        dataType: "json",
        success: function (data) {
            console.log(data);
            $.each(data, function (key, registro) {
                if (registro._idCollector == idCollector) {                    
                $("#code").append('<option value=' + registro.idCredit + '>' + registro.code + ' '+ registro.customer+ ' (' + registro.commerce + ')' + '</option>');
                }
            });
        },
        error: function (data) {
            alert('error');
        }
    });

    $.ajax({
        type: 'POST',
        data: {
            'id': idCollector,
            'fecha': fecha
        },
        url: 'BLL/totalCredits.php',
        success: function (data) {
            console.log(data);
            $.each(data, function (key, registro) {
                if (registro.totalCreditos == null) {
                    $('.creditos').text("0.00");
                    $('#creditos').val(0);               
                } else {
                    var totalCred = parseFloat(registro.totalCreditos);
                    $('.creditos').text(totalCred.toFixed(2));
                    $('#creditos').val(totalCred.toFixed(2));
                    balance();     
                }
            });
        },
        error: function (data) {
            alert('error');
        }
    });
}

function eliminar(id, monto) {
    var ingresos = parseFloat($('.ingresos').text());
    var pagos = parseInt($('.pagos').text());
    ingresos = ingresos - parseFloat(monto);
    pagos = pagos - 1;
    $('.ingresos').text(ingresos.toFixed(2));
    $('.pagos').text(pagos);
    balance();
    jQuery('[data-id="' + id + '"]').attr('hidden', false);
    jQuery('[data-id-detalle="' + id + '"]').parents('#detalle').remove();
}

function balance() {
    var ingresos = parseFloat($('.ingresos').text());
    var creditos = parseFloat($('.creditos').text());
    var base = parseFloat($("#base").val());
    var gastos = parseFloat($("#exes").val());


    if (isNaN(base)) {
        base = 0;
    }

    if (isNaN(gastos)) {
        gastos = 0;
    }

    console.log(base);
    var balance = parseFloat(ingresos) + parseFloat(base) - parseFloat(creditos) - parseFloat(gastos);
    

    $(".efectivo").text(balance.toFixed(2));
    $('.counter').counterUp({
        delay: 15,
        time: 500
    });
     
}


