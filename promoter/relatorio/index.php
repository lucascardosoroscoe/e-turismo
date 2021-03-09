<?php
include_once '../includes/header.php';

/*session created*/
include 'consulta.php';



     session_start();
     $promoter  =  $_SESSION["promoter"];
     $evento  = $_SESSION['evento'];

     



     $consulta = "SELECT * FROM `Ingresso` WHERE `evento` = '$evento' AND `vendedor` = '$promoter' AND (`validade` = 'VALIDO' OR `validade` = 'INVALIDO')";
     $dados = selecionar($consulta);

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
          <select id="evento" onchange="selecionarEvento()">
          <option value="">Selecione o Evento</option>
          <?php addEvento($evento, $promoter); ?>
          </select>
          <h3>Relatório de Emissão de Ingressos</h3>
          <h6>Promoter: <?php echo $promoter; ?></h6> 
          <h6>Evento: <?php echo $evento; ?></h6> 
          <h3>Tabela de Ingressos</h3>
          <table id="tabela">
               <thead>
                    <tr>
                         <td>Código</td>
                         <td>Cliente</td>
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
                    echo ("<td>".$obj['cliente']."</td>");
                    echo ("<td>R$".number_format($obj['valor'], 2, ',', '.')."</td>");  
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
          echo ("<h5>Valor Total Vendido: R$".$soma."<br>Quantidade: ".$count." ingressos.</h5>"); 

          echo ("<h3>Recebimentos</h3>");
          $consulta = "SELECT * FROM `Recebidos` WHERE `vendedor` = '$promoter' AND `evento` = '$evento'";
          $dados = selecionar($consulta);
            ?>
          <table id="tabela">
               <thead>
                    <tr>
                         <td>Valor</td>
                         <td>Data</td>
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
                    echo ("<td>R$".number_format($obj['valor'], 2, ',', '.')."</td>");  
                    echo ("<td>".$obj['data']."</td>"); 
                    echo "</tr>";
                    $somaRecebido += floatval($obj['valor']);
               }
               echo ("</tbody>"); 
               echo ("</table>"); 
               echo ("<h5>Valor Total Pago: R$".number_format($somaRecebido, 2, ',', '.')."</h5>");
               $saldo = $soma - $somaRecebido;
               echo ("<br><h5>Saldo a Pagar: R$".number_format($saldo, 2, ',', '.')."</h5>");
        
          echo ('<br><button onclick="window.print()" class="btn">Imprimir</button>');
          echo ('<br><br><a href="https://ingressozapp.com/produtor/" class="btn">Voltar</a>');
     

          

     echo ('</div>');
echo ('</div>');


?>
<script type="text/javascript" src="visualizar.js"></script>
<link rel="stylesheet" type="text/css" href="print.css" media="print" />
<?php


    include_once '../includes/footer.php';
?>