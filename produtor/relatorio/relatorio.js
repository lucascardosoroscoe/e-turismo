

google.charts.load('current', {'packages':['corechart', 'bar']});
google.charts.setOnLoadCallback(graficoNumeroVendas);
google.charts.setOnLoadCallback(graficoFaturamento);
google.charts.setOnLoadCallback(graficoPromoters);
google.charts.setOnLoadCallback(graficoLotes);


//google.charts.setOnLoadCallback(graficoTres);

function graficoNumeroVendas(){
    var dados = document.getElementById('dados').innerHTML;
    console.log(dados);
    var data = new google.visualization.arrayToDataTable(JSON.parse(dados));

    var classicOptions = {
        series: {
          0: {targetAxisIndex: 0},
          1: {targetAxisIndex: 1}
        },
        title: 'Venda Unitária de Ingressos',
        vAxes: {
          // Adds titles to each axis.
          0: {title: 'Ingressos/Dia'},
          1: {title: 'Total Ingressos'}
        }
    };

    var chart = new google.visualization.ColumnChart(document.getElementById('chart_div1'));
    chart.draw(data, classicOptions);
};

function graficoFaturamento() {
    var dados = document.getElementById('dados2').innerHTML;
    console.log(dados);
    var data = new google.visualization.arrayToDataTable(JSON.parse(dados));

    var classicOptions = {
        series: {
          0: {targetAxisIndex: 0},
          1: {targetAxisIndex: 1}
        },
        title: 'Faturamento com Ingressos',
        vAxes: {
          // Adds titles to each axis.
          0: {title: 'Faturamento/Dia'},
          1: {title: 'Faturamento Total'}
        }
    };

    var chart = new google.visualization.AreaChart(document.getElementById('chart_div2'));
    chart.draw(data, classicOptions);
};

function graficoPromoters(){
        var dados2 = document.getElementById('dados3').innerHTML;
        console.log(dados2);
        var data2 = google.visualization.arrayToDataTable(JSON.parse(dados2));

        var options = {
            title: 'Vendas/Promoter'
        };

        var chart2 = new google.visualization.PieChart(document.getElementById('chart_div3'));

        chart2.draw(data2, options);
}

function graficoLotes(){
    var dados = document.getElementById('dados4').innerHTML;
    console.log(dados);
    var data = google.visualization.arrayToDataTable(JSON.parse(dados));

    var options = {
        title: 'Vendas/Lote'
    };

    var chart = new google.visualization.PieChart(document.getElementById('chart_div4'));

    chart.draw(data, options);
}