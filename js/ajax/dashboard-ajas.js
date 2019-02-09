$(document).ready(function () {
    $('#dashCollector').on('change', function(e) {
        var ctx2 = document.getElementById("comboBarLineChart").getContext('2d');
        var comboBarLineChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                        type: 'line',
                        label: 'Dataset 1',
                        borderColor: '#484c4f',
                        borderWidth: 3,
                        fill: false,
                        data: [12, 19, 3, 5, 2, 3, 13, 17, 11, 8, 11, 9],
                    }, {
                        type: 'bar',
                        label: 'Dataset 2',
                        backgroundColor: '#FF6B8A',
                        data: [10, 11, 7, 5, 9, 13, 10, 16, 7, 8, 12, 5],
                        borderColor: 'white',
                        borderWidth: 0
                    }, {
                        type: 'bar',
                        label: 'Dataset 3',
                        backgroundColor: '#059BFF',
                        data: [10, 11, 7, 5, 9, 13, 10, 16, 7, 8, 12, 5],
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