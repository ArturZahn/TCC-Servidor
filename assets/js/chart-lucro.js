window.addEventListener('load', criarChartGanhos);

function criarChartGanhos() {
  var ctx = document.getElementById("chartLucro");
  var data = {
    labels: lucro_dadoslabel,
    datasets: [{
      data: lucro_dados,
      backgroundColor: "#187817"
    }]
  }

  var myChart = new Chart(ctx, {
    type: 'bar',
    data: data,
    options: {
      "hover": {
        "animationDuration": 0
      },
      "animation": {
        "duration": 1,
        "onComplete": function() {
          var chartInstance = this.chart,
            ctx = chartInstance.ctx;

          ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
          ctx.fillStyle = Chart.defaults.global.defaultFontColor;
          // console.log(ctx.fillStyle);

          ctx.textAlign = 'center';
          ctx.textBaseline = 'bottom';

          this.data.datasets.forEach(function(dataset, i) {
            var meta = chartInstance.controller.getDatasetMeta(i);
            meta.data.forEach(function(bar, index) {
              // var data = dataset.data[index];
              var data = lucro_dadosformatado[index];
              ctx.fillText(data, bar._model.x, bar._model.y - 5);
            });
          });
        }
      },
      legend: {
        "display": false
      },
      tooltips: {
        // "enabled": false
        "enabled": true
      },
      scales: {
        yAxes: [{
          display: true,
          gridLines: {
            display: true
          },
          ticks: {
            max: Math.ceil(Math.max(...data.datasets[0].data) * 1.05),
            display: true,
            beginAtZero: true
          }
        }],
        xAxes: [{
          gridLines: {
            display: false
          },
          ticks: {
            beginAtZero: true
          }
        }]
      }
    }
  });
}