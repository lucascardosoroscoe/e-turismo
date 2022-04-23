// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// Bar Chart Example
var ctx = document.getElementById("myBarChart");
var grupos = JSON.parse(document.getElementById("grupos").innerText);
console.log(grupos);
var labels = [];
var data = [];
for (let i = 0; i < grupos.length; i++) {
  labels.push(grupos[i].name);
  data.push(grupos[i].quantidade);
}
console.log(labels);

var myLineChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: labels,
    datasets: [{
      label: "Quantidade",
      backgroundColor: "rgba(2,117,216,1)",
      borderColor: "rgba(2,117,216,1)",
      data: data,
    }],
  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'month'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 6
        }
      }],
      yAxes: [{
        gridLines: {
          display: false
        },
        ticks: {
          beginAtZero: true
        }
      }],
    },
    legend: {
      display: false
    }
  }
});
