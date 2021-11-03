<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<?php
include('../../includes/verificarAcesso.php');
include('../../includes/header.php');
getProdutores();
getEventos();
getIngressos();
?>

<div style='background-image: url("./img/fundoLogin.jpg"); background-size: cover;height: 100%;'>
    <div style="width: 96%; margin-left: 2%;">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h4 class="text-center font-weight-light my-4">Dashboard IngressoZapp</h4>
                    </div>
                    <div class="card-body">
                        <div class="menuSelecaoGuias">
                            <div class="row">
                                <div class="col-lg-4" style="margin-right: solid 1px #000;">
                                    <div class="card shadow border-0 rounded-lg">
                                         Total
                                        <div class="valor"><?php echo $totalProdutores?> Produtores </div>
                                    </div>
                                    <div class="card shadow border-0 rounded-lg">
                                         Ativos
                                        <div class="valor"><?php echo $ativosProdutores?> Produtores</div>
                                    </div>
                                    <div class="card shadow border-0 rounded-lg">
                                         Inativos
                                        <div class="valor"><?php echo $inativosProdutores?> Produtores</div>
                                    </div>
                                    <div class="shadow border-0 rounded-lg chart" id="chart_div1"></div>
                                </div>
                                <div class="col-lg-4" style="margin-right: solid 1px #000;">
                                    <div class="card shadow border-0 rounded-lg">
                                         Total
                                        <div class="valor"><?php echo $totalEventos?> Eventos</div>
                                    </div>
                                    <div class="card shadow border-0 rounded-lg">
                                         Em andamento
                                        <div class="valor"><?php echo $emAndamentoEventos?> Eventos</div>
                                    </div>
                                    <div class="card shadow border-0 rounded-lg">
                                         Finalizados
                                        <div class="valor"><?php echo $finalizadosEventos?> Eventos</div>
                                    </div>
                                    <div class="shadow border-0 rounded-lg chart" id="chart_div2"></div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="card shadow border-0 rounded-lg">
                                         Total
                                        <div class="valor">R$<?php echo $totalIngressos?>,00 em Ingressos</div>
                                    </div>
                                    <div class="card shadow border-0 rounded-lg">
                                         Ativos
                                        <div class="valor">R$<?php echo $ativosIngressos?>,00 em Ingressos</div>
                                    </div>
                                    <div class="card shadow border-0 rounded-lg">
                                         Usados
                                        <div class="valor">R$<?php echo $usadosIngressos?>,00 em Ingressos</div>
                                    </div>
                                    <div class="shadow border-0 rounded-lg chart" id="chart_div3"></div>
                                </div>
                            </div>
                        </div>                                          
                    </div>
                    <?php
                        data1();
                        data2();
                        data3();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

  


<script>
  google.load('visualization', '1', {
      'packages': ['geochart', 'table']
  });
  google.setOnLoadCallback(drawRegionsMap);
  
  function drawRegionsMap() {
      var dados1 = JSON.parse(document.getElementById('data1').innerHTML);
      var dados2 = JSON.parse(document.getElementById('data2').innerHTML);
      var dados3 = JSON.parse(document.getElementById('data3').innerHTML);
      console.log(dados1);
      var data1 = google.visualization.arrayToDataTable(dados1);
      var data2 = google.visualization.arrayToDataTable(dados2);
      var data3 = google.visualization.arrayToDataTable(dados3);
  

      var largura = window.screen.width;
      if(largura < 700){
        larg = 330;
        heig = 300;
      }else{
        larg = 500;
        heig = 347;
      }
      var options = {
          region: 'BR',
          resolution: 'provinces',
          width: larg,
          height: heig,
          colorAxis: {
              colors: ['#f45a2a', '#257cff']
          }
      };
  
      var chart1 = new google.visualization.GeoChart(
      document.getElementById('chart_div1'));
      chart1.draw(data1, options);

      var chart2 = new google.visualization.GeoChart(
      document.getElementById('chart_div2'));
      chart2.draw(data2, options);

      var chart3 = new google.visualization.GeoChart(
      document.getElementById('chart_div3'));
      chart3.draw(data3, options);
  
  
  };
</script>
<style>
  body{
    margin: 0;
  }
  .card{
    padding-left: 5px;
    margin-bottom:20px;
  }
  .valor{
    font-size: xx-large;
    text-align: end;
    margin-right: 10px;
  }
  .chart{
    margin-bottom: 20px;
  }
</style>

<?php
function getProdutores(){
    global $ativosProdutores, $inativosProdutores, $totalProdutores;
    $consulta = "SELECT COUNT(`id`) as number FROM `Produtor` WHERE `validade` = 'VALIDO'";
    $dados = selecionar($consulta);
    $ativosProdutores = $dados[0]['number'];
    $consulta = "SELECT COUNT(`id`) as number FROM `Produtor` WHERE `validade` != 'VALIDO'";
    $dados = selecionar($consulta);
    $inativosProdutores = $dados[0]['number'];
    $totalProdutores = $inativosProdutores + $ativosProdutores;
}
function getEventos(){
    global $emAndamentoEventos, $finalizadosEventos, $totalEventos;
    $consulta = "SELECT COUNT(`id`) as number FROM `Evento` WHERE `validade` = 'VALIDO'";
    $dados = selecionar($consulta);
    $emAndamentoEventos = $dados[0]['number'];
    $consulta = "SELECT COUNT(`id`) as number FROM `Evento` WHERE `validade` = 'INVALIDO'";
    $dados = selecionar($consulta);
    $finalizadosEventos = $dados[0]['number'];
    $totalEventos = $finalizadosEventos + $emAndamentoEventos;
}
function getIngressos(){
    global $ativosIngressos, $usadosIngressos, $totalIngressos;
    $consulta = "SELECT SUM(`valor`) as valor FROM `Ingresso` WHERE `validade` = 'VALIDO'";
    $dados = selecionar($consulta);
    $ativosIngressos = $dados[0]['valor'];
    $consulta = "SELECT SUM(`valor`) as valor FROM `Ingresso` WHERE `validade` != 'VALIDO'";
    $dados = selecionar($consulta);
    $usadosIngressos = $dados[0]['valor'];
    $totalIngressos = $usadosIngressos + $ativosIngressos;
}
function data1(){
    $consulta = "SELECT `estado`, COUNT(`estado`) as number FROM `Produtor` WHERE `validade` = 'VALIDO' GROUP BY `estado` ORDER BY `estado`";
    $dados = selecionar($consulta);
    $arrayEstados = [];
    $arrayHead = ['State','Produtores'];
    array_push($arrayEstados, $arrayHead);
    foreach ($dados as $estado) {
      $arrayEstado = ["BR-".$estado['estado'], intval($estado['number'])];
      array_push($arrayEstados, $arrayEstado);
    }
    echo "<div id='data1' style='display:none;'>".json_encode($arrayEstados)."</div>";
}
function data2(){
    $consulta = "SELECT Produtor.estado, COUNT(Evento.id) as eventos
    FROM Produtor
    JOIN Evento ON Evento.produtor = Produtor.id
    WHERE (Evento.validade = 'VALIDO') 
    GROUP BY Produtor.estado";
    $dados = selecionar($consulta);
    $arrayEstados = [];
    $arrayHead = ['Estado','Eventos'];
    array_push($arrayEstados, $arrayHead);
    foreach ($dados as $estado) {
      $arrayEstado = ["BR-".$estado['estado'], intval($estado['eventos'])];
      array_push($arrayEstados, $arrayEstado);
    }
    echo "<div id='data2' style='display:none;'>".json_encode($arrayEstados)."</div>";
}
function data3(){
    $consulta = "SELECT Produtor.estado, COUNT(Ingresso.codigo) as ingressos, SUM(Ingresso.valor) as valor
    FROM Produtor
    JOIN Evento ON Evento.produtor = Produtor.id
    JOIN Ingresso ON Ingresso.evento = Evento.id
    WHERE (Ingresso.validade = 'VALIDO' OR Ingresso.validade = 'USADO') 
    GROUP BY Produtor.estado";
    $dados = selecionar($consulta);
    $arrayEstados = [];
    $arrayHead = ['Estado','Valor Vendido'];
    array_push($arrayEstados, $arrayHead);
    foreach ($dados as $estado) {
      $arrayEstado = ["BR-".$estado['estado'], intval($estado['valor'])];
      array_push($arrayEstados, $arrayEstado);
    }
    echo "<div id='data3' style='display:none;'>".json_encode($arrayEstados)."</div>";
}
include('../../includes/footer.php');
?>