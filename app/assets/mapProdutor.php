  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>


  
  <?php
  include('../includes/bancoDados.php');
  $consulta = "SELECT `estado`, COUNT(`estado`) as number FROM `Produtor` WHERE `validade` = 'VALIDO' GROUP BY `estado` ORDER BY `estado`";
  $dados = selecionar($consulta);
  $arrayEstados = [];
  $arrayHead = ['State','Produtores'];
  array_push($arrayEstados, $arrayHead);
  foreach ($dados as $estado) {
    $arrayEstado = ["BR-".$estado['estado'], intval($estado['number'])];
    array_push($arrayEstados, $arrayEstado);
  }
  echo "<div id='data' style='display:none;'>".json_encode($arrayEstados)."</div>";
  ?>
  <div id="chart_div"></div>


<script>
  google.load('visualization', '1', {
      'packages': ['geochart', 'table']
  });
  google.setOnLoadCallback(drawRegionsMap);
  
  function drawRegionsMap() {
      var dados = JSON.parse(document.getElementById('data').innerHTML);
      console.log(dados);
      var data = google.visualization.arrayToDataTable(dados);
  
      var view = new google.visualization.DataView(data)
      view.setColumns([0, 1])
  
      var options = {
          region: 'BR',
          resolution: 'provinces',
          width: 556,
          height: 347,
          colorAxis: {
              colors: ['#f45a2a', '#257cff']
          }
      };
  
      var chart = new google.visualization.GeoChart(
      document.getElementById('chart_div'));
      chart.draw(data, options);
  
  
  };
</script>