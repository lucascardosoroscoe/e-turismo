<?php
include('../includes/verificarAcesso.php');
verificarAcesso(1);
include('../includes/header.php');
$dataInicial = $_GET['dataInicial'];
$dataFinal = $_GET['dataFinal'];
if($dataFinal == ""){
    $dataFinal = date('Y-m-d', time() + (24*60*60));
}
if($dataInicial == ""){
    $dataInicial = date('Y-m-d', time() - (30*24*60*60));
}
?>
<div class="container-fluid">
    <ol class="breadcrumb mb-4" style="margin-top: 20px !important">
        <?php 
        selectEvento();
        ?>
        <form action="index.php" method="get">
            <input type="date" name="dataInicial" id="dataInicial" value="<?php echo $dataInicial;?>">
            <input type="date" name="dataFinal" id="dataFinal" value="<?php echo $dataFinal;?>">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
        </form>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <?php 
            if($idEvento == ""){
                $nomeEvento = "Todos os Eventos";
            }
            echo ('<p style="font-size: x-large;">Vendas Pelo Site</p>');
            ?>
        </div>
        <div class="card-body" style="background-color: #eee;">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-8" style="float:left; margin-top: 5px;">
                        <input class="form-control" type="text" placeholder="Buscar..." style="margin-bottom: 5px" id="buscar" onkeyup="buscar()"/>
                    </div>'
                    <div class="btn btnAdd" onclick="fnExcelReport('dataTable')" style="margin-left: 2px;color: #000;border-color: #000;"><i class="far fa-file-excel"></i> Exportar Excel</div>
                    
                    <?php 
                        addTabelaOnline();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .espaco{
        width: 10px;
    }
</style>
<?php 
    function addTabelaOnline(){
        global $idEvento, $idUsuario, $dataInicial, $dataFinal, $consulta;
        echo('<div class="table-responsive">');
            echo('<table id="dataTable" class="table  tablesorter table-hover" width="100%" cellspacing="0">');
                echo('<thead>');
                    echo('<tr>');
                    echo('<th style="display:none;">id</th>');
                    echo('<th>Descrição</th>');
                    echo('<th>Cliente</th>');
                    echo('<th>Telefone</th>');
                    echo('<th>Quant.</th>');
                    echo('<th>Valor Und.</th>');
                    echo('<th>Valor Ing.</th>');
                    echo('<th>Taxa</th>');
                    echo('<th>Valor Total</th>');
                    echo('<th>Data</th>');
                    echo('<th>Status</th>');
                    echo('<th></th>');
                    echo('</tr>');
                echo('</thead>');
                echo('<tbody id="tbody">');
                    if($idEvento == ""){
                        $consulta = "SELECT PedidoPagSeguro.id, PedidoPagSeguro.itemDescription, PedidoPagSeguro.itemAmount, PedidoPagSeguro.itemQuantity, PedidoPagSeguro.senderName, PedidoPagSeguro.senderAreaCode, PedidoPagSeguro.senderPhone, PedidoPagSeguro.senderEmail, PedidoPagSeguro.extraAmount, PedidoPagSeguro.createAt, PedidoPagSeguro.status,
                        Lote.nome as lote, Evento.nome as evento                        
                        FROM PedidoPagSeguro
                        JOIN Lote ON Lote.id = PedidoPagSeguro.idLote 
                        JOIN Evento ON Evento.id = Lote.evento
                        WHERE `createAt` >= '$dataInicial' AND `createAt` <= '$dataFinal' AND PedidoPagSeguro.status != '10'
                        ORDER BY PedidoPagSeguro.createAt DESC";
                    }else{
                        $consulta = "SELECT PedidoPagSeguro.id, PedidoPagSeguro.itemDescription, PedidoPagSeguro.itemAmount, PedidoPagSeguro.itemQuantity, PedidoPagSeguro.senderName, PedidoPagSeguro.senderAreaCode, PedidoPagSeguro.senderPhone, PedidoPagSeguro.senderEmail, PedidoPagSeguro.extraAmount, PedidoPagSeguro.createAt, PedidoPagSeguro.status,
                        Lote.nome as lote, Evento.nome as evento                        
                        FROM PedidoPagSeguro
                        JOIN Lote ON Lote.id = PedidoPagSeguro.idLote 
                        JOIN Evento ON Evento.id = Lote.evento
                        WHERE `createAt` >= '$dataInicial' AND `createAt` <= '$dataFinal' AND PedidoPagSeguro.status != '10' AND Evento.id = '$idEvento'
                        ORDER BY PedidoPagSeguro.createAt DESC";
                    }
                    addtabela($consulta);
                echo('</tbody>');
            echo('</table>');
        echo('</div>');
    }
    
    function addtabela($consulta){
        $dados = selecionar($consulta);
        foreach ($dados as $obj) {
            echo "<tr>";
            echo ("<td style='display:none;'>".$obj['id']."</td>");
            $evento = $obj['evento'];
            echo ("<td>".$obj['itemQuantity']." ingressos - ".$evento." (".$obj['lote'].")</td>"); 
            $nome = urldecode($obj['senderName']);
            echo ("<td>".$nome." (".$obj['senderEmail'].")</td>"); 
            $telefone = $obj['senderAreaCode'] . $obj['senderPhone'];
            $link = "https://api.whatsapp.com/send?phone=55".$telefone."&text=";
            echo ("<td><a href='".$link."' target='_blank'>".$telefone."</a></td>"); 
            $valorIgressos = floatval($obj['itemAmount']) * intval($obj['itemQuantity']);
            echo ("<td>".$obj['itemQuantity']." x</td>"); 
            echo ("<td>R$".UsToBr($obj['itemAmount'])."</td>"); 
            echo ("<td>R$".UsToBr($valorIgressos)."</td>"); 
            echo ("<td>R$".UsToBr($obj['extraAmount'])."</td>"); 
            $valorTotal = $valorIgressos + floatval($obj['extraAmount']);
            echo ("<td>R$".UsToBr($valorTotal)."</td>"); 
            echo ("<td>".formatarData($obj['createAt'])."</td>"); 
            if($obj['status'] == '1'){
                echo ("<td>Aguardando Pagamento</td>");
                $msg = "Olá ".$nome." você tentou comprar ingressos para o evento ".$evento." mas não finalizou sua compra. Aconteceu algo? Gostaria de dar continuidade aqui mesmo pelo whats?";
                echo ("<td style='display: inline-flex; text-align:center;'><a href='".$link.$msg."' style='color: green !important;' target='_blank'><i class='fab fa-whatsapp'></i></a><span class='espaco'></span><a href='visualizar.php?id=".$obj['id']."' style='color: blue !important;'><i class='fas fa-eye'></i></a><span class='espaco'></span><a href='excluir.php?id=".$obj['id']."' target='_blank' style='color: red !important;'><i class='fas fa-trash-alt'></i></a></td>");  
            }else if($obj['status'] == '2'){
                echo ("<td>Em Análise</td>");
                $msg = "Olá ".$nome." você está comprando ingressos para o evento ".$evento.", mas seu pagamento ainda está em análise. Por favor aguarde que o ingresso seja liberado.";
                echo ("<td style='display: inline-flex; text-align:center;'><a href='".$link.$msg."' style='color: green !important;' target='_blank'><i class='fab fa-whatsapp'></i></a></td>");
            }else if($obj['status'] == '3' || $obj['status'] == '4'){
                echo ("<td>Pagamento Concluído</td>");
                $msg = "Olá ".$nome." você comprou um ingresso com sucesso para o evento ".$evento." usando o IngressoZapp, estamos a disposição para te auxiliar caso tenha alguma dúvida";
                echo ("<td style='display: inline-flex; text-align:center;'><a href='".$link.$msg."' style='color: green !important;' target='_blank'><i class='fab fa-whatsapp'></i></a><span class='espaco'></span><a href='visualizar.php?id=".$obj['id']."' style='color: blue !important;'><i class='fas fa-eye'></i></a></td>");
            }else if($obj['status'] == '5'){
                echo ("<td>Em disputa</td>");
                $msg = "Olá ".$nome." você comprou um ingresso com sucesso para o evento ".$evento." usando o IngressoZapp, porém, você entrou em disputa perante nosso meio de pagamento, gostaríamos de entender um pouco mais do porque dessa solicitação. Para podermos dar continuidade ao procedimento.";
                echo ("<td style='display: inline-flex; text-align:center;'><a href='".$link.$msg."' style='color: green !important;' target='_blank'><i class='fab fa-whatsapp'></i></a></td>");
            }else if($obj['status'] == '6'){
                echo ("<td>Devolvida</td>");
                $msg = "Olá ".$nome." você comprou um ingresso com sucesso para o evento ".$evento." usando o IngressoZapp, porém, você solicitou o cancelamento, seu cancelamento foi feito com sucesso. Por favor avalie nosso atendimento.";
                echo ("<td style='display: inline-flex; text-align:center;'><a href='".$link.$msg."' style='color: green !important;' target='_blank'><i class='fab fa-whatsapp'></i></a></td>");
            }else if($obj['status'] == '7'){
                echo ("<td>Cancelada</td>");
                $msg = "Olá ".$nome." você tentou comprar ingressos para o evento ".$evento." mas teve seu pagamento cancelado pela operadora de cartão. Nesse caso, recomendamos dar continuidade aqui mesmo pelo whats, fazendo a compra do ingresso via PIX. Podemos prosseguir com a compra";
                echo ("<td style='display: inline-flex; text-align:center;'><a href='".$link.$msg."' style='color: green !important;' target='_blank'><i class='fab fa-whatsapp'></i></a><span class='espaco'></span><a href='excluir.php?id=".$obj['id']."' target='_blank' style='color: red !important;'><i class='fas fa-trash-alt'></i></a></td>");
            }
            echo "</tr>";
        }
    }
    include('../includes/footer.php');
?>