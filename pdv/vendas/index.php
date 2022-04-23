<?php
include('../includes/verificarAcesso.php');
verificarAcesso(3);
include('../includes/header.php');

$hoje = date('d/m/Y h:m', strtotime("-3 hour"));
$soma = 0;
$count = 0;
?>
<div class="container-fluid">
     <!-- Tabela dos veículos-->
     <ol class="breadcrumb mb-4" style="margin-top: 20px !important">
          <?php 
          selectEvento();
          ?>
     </ol>
     <div class="card mb-4">
          <div class="card-header">
               <img src="../img/logo.png" alt="" class="logo" style="float:left;">
               <div style="float:right; width: 60%;">
                    <h2>INGRESSOZAPP</h2>
                    <h6 style="text-align: end;">LR Software - <?php echo $hoje ?></h6>
               </div>
          </div>
          <div class="card-body">
               <?php 
                    carregarCabecalho(); 
                    carregarIngressosDia();
                    carregarIngressos();
                    carregarTotal();
                    carregarRecebimentos();
               ?>
          </div>
     </div>
</div>
               
<?php
     function addEvento(){
          global $tipoUsuario, $idUsuario, $idEvento, $nomeEvento, $vendedor;
          if($tipoUsuario == 1){
               $consulta = "SELECT * FROM Evento";
          }else if($tipoUsuario == 2){
               $consulta = "SELECT * FROM Evento WHERE `produtor` = $idUsuario";
          }else if($tipoUsuario == 3){
               $consulta = "SELECT * FROM Evento JOIN ProdutorVendedor ON ProdutorVendedor.idProdutor = Evento.produtor WHERE ProdutorVendedor.idVendedor = '$idUsuario'";
          }
          
          $eventos = selecionar($consulta);
          foreach ($eventos as $evento) {
               $id = $evento['id'];
               $nome = $evento['nome'];
               if ($id == $idEvento){
                    echo ('<option value="'.$id.'" selected>'.$nome.'</option>');
                    $nomeEvento = $nome;
               }else{
                    echo ('<option value="'.$id.'">'.$nome.'</option>');
               }
          }   
     }

     function carregarCabecalho(){
          global $usuario, $nomeEvento;
          echo'<h3>Relatório de Emissão de Ingressos</h3>';
          echo'<h6>Promoter: '. $usuario .'</h6>';
          echo'<h6>Evento: '. $nomeEvento .'</h6>';
     }

     function carregarIngressos(){
          global $tipoUsuario, $idEvento, $idUsuario, $soma, $count;

          if($tipoUsuario == 1){
               $consulta = "SELECT Ingresso.codigo, Ingresso.valor, Ingresso.validade, Ingresso.data,
               Evento.nome as evento, Vendedor.nome as vendedor, Cliente.nome as cliente, Cliente.telefone
               FROM Ingresso 
               JOIN Evento ON Evento.id = Ingresso.evento
               JOIN Vendedor ON Vendedor.id = Ingresso.vendedor
               JOIN Cliente ON Cliente.id = Ingresso.idCliente
               WHERE Vendedor.id = 1 AND Evento.id = $idEvento AND ( Ingresso.validade = 'VALIDO' OR Ingresso.validade = 'USADO' )";
               // Add lote depois
               // JOIN Lote ON Lote.id = Ingresso.lote
          }else if($tipoUsuario == 2){
               $consulta = "SELECT Ingresso.codigo, Ingresso.valor, Ingresso.validade, Ingresso.data,
               Evento.nome as evento, Vendedor.nome as vendedor, Cliente.nome as cliente, Cliente.telefone
               FROM Ingresso 
               JOIN Evento ON Evento.id = Ingresso.evento
               JOIN Vendedor ON Vendedor.id = Ingresso.vendedor
               JOIN Cliente ON Cliente.id = Ingresso.idCliente
               WHERE Vendedor.id = 2 AND Evento.id = $idEvento AND ( Ingresso.validade = 'VALIDO' OR Ingresso.validade = 'USADO' )";
          }else if($tipoUsuario == 3){
               $consulta = "SELECT Ingresso.codigo, Ingresso.valor, Ingresso.validade, Ingresso.data,
               Evento.nome as evento, Vendedor.nome as vendedor, Cliente.nome as cliente, Cliente.telefone
               FROM Ingresso 
               JOIN Evento ON Evento.id = Ingresso.evento
               JOIN Vendedor ON Vendedor.id = Ingresso.vendedor
               JOIN Cliente ON Cliente.id = Ingresso.idCliente
               WHERE Vendedor.id = $idUsuario AND Evento.id = $idEvento AND ( Ingresso.validade = 'VALIDO' OR Ingresso.validade = 'USADO' )";
          }

          echo'<br><h3>Tabela de Ingressos</h3>';
          echo'<div class="table-responsive table-hover">';
               echo'<table class="table tablesorter table-hover" id="dataTable" width="100%" cellspacing="0">';
                    echo'<thead>';
                         echo'<tr>';
                              echo'<th>Código</th>';
                              echo'<th>Cliente</th>';
                              echo'<th>Valor</th>';
                              echo'<th>Data</th>';
                              echo'<th>Validade</th>';
                              // echo'<th>Lote</th>';
                         echo'</tr>';
                    echo'</thead>';
                    echo'<tbody id="tbody">';
               
                    $ingressos = selecionar($consulta);
                    foreach ($ingressos as $ingresso) {
                         echo "<tr>";
                              echo ("<td>".$ingresso['codigo']."</td>");
                              echo ("<td>".$ingresso['cliente']."</td>");
                              echo ("<td>R$".number_format($ingresso['valor'], 2, ',', '.')."</td>");  
                              echo ("<td>".$ingresso['data']."</td>");
                              echo ("<td>".$ingresso['validade']."</td>");
                              // echo ("<td>".$ingresso['lote']."</td>"); 
                         echo "</tr>";
                         $soma += floatval($ingresso['valor']);
                         $count++;
                    }
                    echo'</tbody>';
               echo'</table>';
          echo'</div>  ';
          // echo $consulta;
     }
     
     function carregarIngressosDia(){
          global $tipoUsuario, $idEvento, $idUsuario;

          if($tipoUsuario == 1){
               $consulta = "SELECT COUNT(Ingresso.codigo) as contagem, SUM(Ingresso.valor) as valor, Ingresso.data FROM Ingresso 
               JOIN Evento ON Evento.id = Ingresso.evento
               JOIN Vendedor ON Vendedor.id = Ingresso.vendedor
               JOIN Cliente ON Cliente.id = Ingresso.idCliente
               WHERE Vendedor.id = 1 AND Evento.id = $idEvento AND ( Ingresso.validade = 'VALIDO' OR Ingresso.validade = 'USADO' )
               GROUP BY Ingresso.data";
               // Add lote depois
               // JOIN Lote ON Lote.id = Ingresso.lote
          }else if($tipoUsuario == 2){
               $consulta = "SELECT COUNT(Ingresso.codigo) as contagem, SUM(Ingresso.valor) as valor, Ingresso.data 
               FROM Ingresso 
               JOIN Evento ON Evento.id = Ingresso.evento
               JOIN Vendedor ON Vendedor.id = Ingresso.vendedor
               JOIN Cliente ON Cliente.id = Ingresso.idCliente
               WHERE Vendedor.id = 2 AND Evento.id = $idEvento AND ( Ingresso.validade = 'VALIDO' OR Ingresso.validade = 'USADO' )
               GROUP BY Ingresso.data";
          }else if($tipoUsuario == 3){
               $consulta = "SELECT COUNT(Ingresso.codigo) as contagem, SUM(Ingresso.valor) as valor, Ingresso.data 
               FROM Ingresso 
               JOIN Evento ON Evento.id = Ingresso.evento
               JOIN Vendedor ON Vendedor.id = Ingresso.vendedor
               JOIN Cliente ON Cliente.id = Ingresso.idCliente
               WHERE Vendedor.id = $idUsuario AND Evento.id = $idEvento AND ( Ingresso.validade = 'VALIDO' OR Ingresso.validade = 'USADO' )
               GROUP BY Ingresso.data";
          }

          echo'<br><h3>Ingressos por dia</h3>';
          echo'<div class="table-responsive table-hover">';
               echo'<table class="table tablesorter table-hover" id="dataTable" width="100%" cellspacing="0">';
                    echo'<thead>';
                         echo'<tr>';
                              echo'<th>Data</th>';
                              echo'<th>Quantidade</th>';
                              echo'<th>Valor</th>';
                              // echo'<th>Lote</th>';
                         echo'</tr>';
                    echo'</thead>';
                    echo'<tbody id="tbody">';
               
                    $ingressos = selecionar($consulta);
                    foreach ($ingressos as $ingresso) {
                         echo "<tr>";
                              echo ("<td>".$ingresso['data']."</td>");
                              echo ("<td>".$ingresso['contagem']."</td>");
                              echo ("<td>R$".number_format($ingresso['valor'], 2, ',', '.')."</td>");  
                              // echo ("<td>".$ingresso['lote']."</td>"); 
                         echo "</tr>";
                    }

                    echo'</tbody>';
               echo'</table>';
          echo'</div>  ';
          // echo $consulta;
     }

     function carregarTotal(){
          global  $soma, $count;
          echo ("<h5>Valor Total Vendido: R$".number_format($soma, 2, ',', '.')."<br>Quantidade: ".$count." ingressos.</h5>"); 
     }
     
     function carregarRecebimentos(){
          global  $soma, $tipoUsuario, $idUsuario, $idEvento;

          if($tipoUsuario == 1){
               $consulta = "SELECT * FROM `Recebidos` WHERE vendedor = 1          AND evento = $idEvento";
          }else if($tipoUsuario == 2){
               $consulta = "SELECT * FROM `Recebidos` WHERE vendedor = 2          AND evento = $idEvento";
          }else if($tipoUsuario == 3){
               $consulta = "SELECT * FROM `Recebidos` WHERE vendedor = $idUsuario AND evento = $idEvento";
          }

          echo ("<br><h3>Recebimentos</h3>");
          $recebidos = selecionar($consulta);
               ?>
          <table class="table tablesorter table-hover" id="dataTable" width="100%" cellspacing="0">
               <thead>
                    <tr>
                         <th>Valor</th>
                         <th>Data</th>
                    </tr>
               </thead>
               <tbody id="tbody">
               <?php
                    $somaRecebido = 0;
                    foreach ($recebidos as $recebido) {
                         echo "<tr>";
                              echo ("<td>R$".number_format($recebido['valor'], 2, ',', '.')."</td>");  
                              echo ("<td>".$recebido['data']."</td>"); 
                         echo "</tr>";
                         $somaRecebido += floatval($recebido['valor']);
                    }
               echo ("</tbody>"); 
          echo ("</table>"); 
          echo ("<h5>Valor Total Pago: R$".$somaRecebido."</h5>");
          $saldo = $soma - $somaRecebido;
          echo ("<br><h5>Saldo a Pagar: R$".number_format($saldo, 2, ',', '.')."</h5>");
     }

    include_once '../includes/footer.php';
?>