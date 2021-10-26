  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>


  
  <?php
  include('../includes/bancoDados.php');
  $consulta = "SELECT Produtor.estado, COUNT(Evento.id) as eventos
  FROM Produtor
  JOIN Evento ON Evento.produtor = Produtor.id
  WHERE (Evento.validade = 'VALIDO' OR Evento.validade = 'INVALIDO') 
  GROUP BY Produtor.estado";
  $dados = selecionar($consulta);
  $arrayEstados = [];
  $arrayHead = ['Estado','Eventos'];
  array_push($arrayEstados, $arrayHead);
  foreach ($dados as $estado) {
    $arrayEstado = ["BR-".$estado['estado'], intval($estado['eventos'])];
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