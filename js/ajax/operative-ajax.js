$(document).ready(function() {

    $('#fechaBalanceOp').blur(function() {
        $('#amountPayOp').focus();
    });

    $('#form-pay-op').on('submit', function(e) {
        e.preventDefault();

        var saldoR = $("#totalB").val();
        var pago = $("#amountPayOp").val();


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
                    document.getElementById("form-pay-op").reset();
                    $('#balanceOp').modal('toggle');
                    swal.close();
                    swal({
                        position: 'top-end',
                        type: 'success',
                        title: '¡' + resultado.mensaje,
                        showConfirmButton: false,
                        timer: 1000
                    });
                    if (resultado.cancelada == 1) {
                        setTimeout(function() {
                            window.location.href = 'listCreditsOp.php';
                        }, 1500);
                    }
                } else if (resultado.respuesta == 'vacio') {
                    swal({
                        type: 'warning',
                        title: 'Oops...',
                        text: 'No se han podido procesar los datos',
                    });
                } else if (resultado.respuesta == 'error') {
                    swal({
                        type: 'error',
                        title: 'Error',
                        text: 'No se pudo guardar en la base de datos',
                    });
                }
            }
        });
    });


    $('.detalle_balance').on('click', function(e) {
        e.preventDefault();
        $("#detallesBOp").find('tbody').html("");
        $("#anuladosBOp").find('tbody').html("");
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
                        $("#anuladosBOp").append(nuevaFila);
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
                        $("#detallesBOp").append(nuevaFila);
                    }
                });
                $(".totalBal").text(totalBal.toFixed(2));
                $("#totalBOp").val(totalBal.toFixed(2));
                $("#idCreditoOp").val(id);
                swal.close();
                $('#balanceOp').modal('show');
            },
            error: function(data) {
                swal({
                    type: 'error',
                    title: 'Error',
                    text: 'No se puede cargar el balance de saldos',
                });
            }
        });
    });

    $('#form-IncomesOp').on('submit', function(e) {
        e.preventDefault();
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
            success: function(data) {
                console.log(data);
                var total = 0;
                $.each(data, function(key, registro) {
                    total = parseFloat(total) + parseFloat(registro.amount);
                });
                $('.totalIncomes').text(total.toFixed(2));
                $('#operative').DataTable({
                    "bDestroy": true,
                    data: data,
                    columns: [{
                            data: 'code'
                        },
                        {
                            data: 'dateStart'
                        },
                        {
                            data: 'customer'
                        },
                        {
                            data: 'total'
                        },
                        {
                            data: 'amount'
                        }
                    ],
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
                swal.close();
            },
            error: function(data) {
                swal({
                    type: 'error',
                    title: 'Error',
                    text: 'Algo ha salido mal, intentalo más tarde',
                })
            }
        });
    });
});