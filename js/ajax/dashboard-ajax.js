$(document).ready(function () {
    $('#dashCollector').on('change', function(e) {
        var idCollector = $('#dashCollector').val();
        console.log(idCollector);

        $.getJSON("BLL/dashIncome.php?idCollector=" + idCollector, function (data) {
            var months = [];
            var count = [];
            var i = 0;
            for (i = 0; i < data.length; i++) {
                months[i] = [String(data[i].month)];
                count[i] = [String(data[i].incomes)];
            }

            $.getJSON("BLL/dashBase.php?idCollector=" + idCollector, function (data) {
                var count2 = [];
                var i = 0;
                for (i = 0; i < data.length; i++) {
                    count2[i] = [String(data[i].base)];
                }


                $.getJSON("BLL/dashCredits.php?idCollector=" + idCollector, function (data) {
                    var count3 = [];
                    var i = 0;
                    for (i = 0; i < data.length; i++) {
                        count3[i] = [String(data[i].credits)];
                    }

                    $.getJSON("BLL/dashExes.php?idCollector=" + idCollector, function (data) {
                        var count4 = [];
                        var i = 0;
                        for (i = 0; i < data.length; i++) {
                            count4[i] = [String(data[i].exes)];
                        }

                        $.getJSON("BLL/dashCash.php?idCollector=" + idCollector, function (data) {
                            var count5 = [];
                            var i = 0;
                            for (i = 0; i < data.length; i++) {
                                count5[i] = [String(data[i].cash)];
                            }
                            var ctx2 = document.getElementById("comboBarLineChart").getContext('2d');
                            var comboBarLineChart = new Chart(ctx2, {
                                type: 'bar',
                                data: {
                                    labels: months,
                                    datasets: [{
                                            type: 'line',
                                            label: 'Efectivo',
                                            borderColor: '#614642',
                                            borderWidth: 3,
                                            fill: false,
                                            data: count5,
                                        }, {
                                            type: 'bar',
                                            label: 'Ingresos',
                                            backgroundColor: '#3F7353',
                                            data: count,
                                            borderColor: 'white',
                                            borderWidth: 0
                                        }, {
                                            type: 'bar',
                                            label: 'Créditos',
                                            backgroundColor: '#3C5975',
                                            data: count3,
                                            borderColor: 'white',
                                            borderWidth: 0
                                        }, {
                                            type: 'bar',
                                            label: 'Base',
                                            backgroundColor: '#EFE507',
                                            data: count2,
                                            borderColor: 'white',
                                            borderWidth: 0
                                        }, {
                                            type: 'bar',
                                            label: 'Gastos',
                                            backgroundColor: '#D4454A',
                                            data: count4,
                                            borderColor: 'white',
                                            borderWidth: 0
                                        }], 
                                        borderWidth: 1
                                },
                                options: {
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero:true
                                            }
                                        }]
                                    }
                                }
                            });
                        });
                    });
                });
            });
        });
    });
});