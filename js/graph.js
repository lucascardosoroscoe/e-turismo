// Load the Visualization API and the corechart package.
google.charts.load('current', {'packages':['corechart']});



// Set a callback to run when the Google Visualization API is loaded.
google.charts.setOnLoadCallback(
  function() {
    var graphs = JSON.parse(document.getElementById('graphsList').innerHTML);
    graphs.forEach(graph => {
      drawChart(graph);
    });
  }
);

//Desenha o Gráfico
function drawChart(graph) {
  console.log(graph.columns);
  // Create the data table.
  var data = new google.visualization.DataTable();
  graph.columns.forEach(column => {
    data.addColumn(column[0], column[1]);
  });
  data.addRows(graph.rows);
  console.log(data);
  // Instantiate and draw our chart, passing in some options.
  if(graph.chartType == "PieChart"){
  var chart = new google.visualization.PieChart(document.getElementById(graph.chartDiv));
  }else if(graph.chartType == "BarChart"){
    var chart = new google.visualization.BarChart(document.getElementById(graph.chartDiv));
  }else if(graph.chartType == "AreaChart"){
    var chart = new google.visualization.AreaChart(document.getElementById(graph.chartDiv));
  }else if(graph.chartType == "ColumnChart"){
    var chart = new google.visualization.ColumnChart(document.getElementById(graph.chartDiv));
    console.log(chart);
  }else if(graph.chartType == "ComboChart"){
    var chart = new google.visualization.ComboChart(document.getElementById(graph.chartDiv));
  }else if(graph.chartType == "LineChart"){
    var chart = new google.visualization.LineChart(document.getElementById(graph.chartDiv));
  }
  chart.draw(data, graph.options);

}

//Material Bar Charts