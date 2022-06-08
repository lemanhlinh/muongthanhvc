$(document).ready(function() {
    var areaChartData = {
        labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [
            {
                label               : 'Electronics',
                backgroundColor     : '#F2A900',
                borderColor         : '#F2A900',
                pointRadius         : false,
                pointColor          : '#F2A900',
                pointStrokeColor    : '#c1c7d1',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: '#F2A900',
                data                : [65, 59, 80, 81, 56, 55, 40]
            },
            {
                label               : 'Digital Goods',
                backgroundColor     : '#002864',
                borderColor         : '#002864',
                pointRadius          : false,
                pointColor          : '#3b8bba',
                pointStrokeColor    : '#002864',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: '#002864',
                data                : [28, 48, 40, 19, 86, 27, 90]
            },
        ]
    }
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0

    var barChartOptions = {
        responsive              : true,
        maintainAspectRatio     : false,
        datasetFill             : false
    }

    new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
    })
})