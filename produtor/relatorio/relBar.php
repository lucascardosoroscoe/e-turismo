<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<?php
include_once '../includes/header.php';
session_start();
/*session created*/
$produtor  =  $_SESSION["usuario"];
$validade =  $_SESSION["validade"];

include 'consulta.php';
include 'dadosGraficos.php';

$hoje = date('d/m/Y h:m', strtotime("-3 hour"));
?>

<div class="row">
    <div class="col s12 m6 push-m3 ">
          <div style="display: flex;">
               <img src="../includes/logo.png" alt="" class="logo">
               <div class="empresa">
               <h4>INGRESSOZAPP</h4>
               <h6 style="text-align: end;">LR Software - <?php echo $hoje ?></h6>
               </div>
               
          </div>
        <h3>Relatório de Vendas no Bar</h3>
        <h6>Produtor: <?php echo $produtor; ?></h6> 
        <h6>Evento: <?php echo $evento; ?></h6> 

        <?php carregarDadosNumeroIngressos($dados); ?>
        <?php carregarDadosFaturamento($dados); ?>
        <?php carregarDadosVendasPromoters($dados); ?>
        <?php carregarDadosVendasLotes($dados); ?>
          <br>
          <div id="chart_div1" style="width: 100%; height: 400px;"></div>
          <div id="chart_div2" style="width: 100%; height: 400px;"></div>
          <div id="chart_div3" style="width: 100%; height: 400px;"></div>
          <div id="chart_div4" style="width: 100%; height: 400px;"></div>
          </div>
          <h3>Tabela de Vendas</h3>
          <table id="tabela">
               <thead>
                    <tr>
                         <td>Código</td>
                         <td>Vendedor</td>
                         <td>Valor</td>
                         <td>Lote</td>
                    </tr>
               </thead>
               <tbody>
               <?php
               
               
               $size = sizeof($dados);

               for ($i = 0; $i < $size; $i++){
                    $obj = $dados[$i];
                    //echo json_encode($primeiro);
                    //echo "<br>";
                    //imprime o conteúdo do objeto 
                    echo "<tr>";
                    echo ("<td>".$obj['codigo']."</td>");
                    echo ("<td>".$obj['vendedor']."</td>");
                    echo ("<td>".$obj['valor']."</td>");  
                    echo ("<td>".$obj['lote']."</td>"); 
                    echo "</tr>";
                    $soma += floatval($obj['valor']);
                    $count++;
               }
               ?>
            
               </tbody>
          </table>
          <?php
          
          $soma = number_format($soma, 2, ',', '.'); 
          echo ("<h5>Valor Total: R$".$soma."<br>Quantidade: ".$count." ingressos.</h5>"); 
        
          echo ('<br><button onclick="window.print()" class="btn">Imprimir</button>');
          echo ('<br><br><a href="https://ingressozapp.com/produtor/relatorio/" class="btn">Voltar</a>');
     

          

     echo ('</div>');
echo ('</div>');


?>
<script type="text/javascript">

var table = document.getElementById("tabela"),rIndex,cIndex;

// table rows
for(var i = 1; i < table.rows.length; i++)
{
    // row cells
    for(var j = 0; j < table.rows[i].cells.length - 1 ; j++)
    {
        table.rows[i].cells[j].onclick = function()
        {
            rIndex = this.parentElement.rowIndex;
            pegarValor(rIndex);
        }
    }
}
function pegarValor(rIndex){
     var codigo = table.rows[rIndex].cells[0].innerHTML;
     window.location.href = "https://ingressozapp.com/produtor/detalhar/ingresso.php?codigo=" + codigo;
}

</script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="relBar.js"></script>
<link rel="stylesheet" type="text/css" href="print.css" media="print" />
<?php

    include_once '../includes/footer.php';
?>