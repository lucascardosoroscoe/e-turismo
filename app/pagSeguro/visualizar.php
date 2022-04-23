<?php
include('../includes/verificarAcesso.php');
verificarAcesso(1);
include('../includes/header.php');
$id = $_GET['id'];
$consulta = "SELECT PedidoPagSeguro.id, PedidoPagSeguro.itemDescription, PedidoPagSeguro.itemAmount, PedidoPagSeguro.itemQuantity, PedidoPagSeguro.senderName, PedidoPagSeguro.senderAreaCode, PedidoPagSeguro.senderPhone, PedidoPagSeguro.senderEmail, PedidoPagSeguro.extraAmount, PedidoPagSeguro.createAt, PedidoPagSeguro.status, PedidoPagSeguro.idLote,
Lote.nome as lote, Evento.nome as evento, Evento.id as idEvento                  
FROM PedidoPagSeguro
JOIN Lote ON Lote.id = PedidoPagSeguro.idLote 
JOIN Evento ON Evento.id = Lote.evento
WHERE PedidoPagSeguro.id = '$id'
ORDER BY PedidoPagSeguro.createAt DESC";
$dados = selecionar($consulta);
$itemDescription = urldecode($dados[0]['itemDescription']);
$senderName = urldecode($dados[0]['senderName']);
$idLote = $dados[0]['idLote'];
$idEvento = $dados[0]['idEvento'];
$telefone = $dados[0]['senderAreaCode'] .  $dados[0]['senderPhone'];
?>
<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-header">
            <?php 
            echo ('<p style="font-size: x-large;">Acompanhar Pedido - '. $itemDescription.' -> '. $senderName.'</p>');
            ?>
        </div>
        <div class="card-body" style="background-color: #eee;">
            <div class="row">
                <div class="col-md-12">
                    <h3 style="margin-top: 20px;">Detalhes do Pedido</h3>
                    <?php addTabelaOnline($dados); ?>
                </div>
                <div class="col-md-12">
                    <h3 style="margin-top: 20px;">Ingressos Emitidos com Sucesso</h3>
                    <div class="row">
                        <div class="col-md-8" style="float:left; margin-top: 5px;">
                            <input class="form-control" type="text" placeholder="Buscar..." style="margin-bottom: 5px" id="buscar" onkeyup="buscar()"/>
                        </div>
                        <div class="col-md-4" style="margin-top: 10px; text-align:center;">
                            <?php
                                echo "<a href='emitir.php?idLote=".$idLote."&idEvento=".$idEvento."&nome=".$senderName."&telefone=".$telefone."&idPagSeguro=".$id."' class='btn btnAdd' style='margin-left: 2px;color: #000;border-color: #000;'><i class='fas fa-user-plus'></i> Emitir Ingresso</a>";
                            ?>
                            <div class="btn btnAdd" onclick="fnExcelReport('dataTable')" style="margin-left: 2px;color: #000;border-color: #000;"><i class="far fa-file-excel"></i> Exportar Excel</div>
                        </div>
                    </div>
                    <?php 
                        addTabelaVendas();
                    ?>
                </div>
            </div>

        </div>
    </div>
</div>


<?php

    function addTabelaOnline($dados){
        echo('<div>');
            echo('<table class="table  tablesorter table-hover" width="100%" cellspacing="0">');
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
                    echo('</tr>');
                echo('</thead>');
                echo('<tbody id="tbody">');
                    addDadosVenda($dados);
                echo('</tbody>');
            echo('</table>');
        echo('</div>');
    }
    function addDadosVenda($dados){
        $obj = $dados[0];
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
        }else if($obj['status'] == '2'){
            echo ("<td>Em Análise</td>");
        }else if($obj['status'] == '3' || $obj['status'] == '4'){
            echo ("<td>Pagamento Concluído</td>");
        }else if($obj['status'] == '5'){
            echo ("<td>Em disputa</td>");
        }else if($obj['status'] == '6'){
            echo ("<td>Devolvida</td>");
        }else if($obj['status'] == '7'){
            echo ("<td>Cancelada</td>");
        }
        echo "</tr>";
    }
    function addTabelaVendas(){
        global $idLote, $senderName;
        echo('<div class="table-responsive">');
            echo('<table id="dataTable" class="table  tablesorter table-hover" width="100%" cellspacing="0">');
                echo('<thead>');
                    echo('<tr>');
                    echo('<th>Código</th>');
                    echo('<th>Cliente</th>');
                    echo('<th>Valor</th>');
                    echo('<th>Lote</th>');
                    echo('<th>Telefone</th>');
                    echo('<th>Vendedor</th>');
                    echo('<th>Data</th>');
                    echo('<th>Validade</th>');
                    echo('<th></th>');
                    echo('</tr>');
                echo('</thead>');
                echo('<tbody id="tbody">');
                    $consulta = "SELECT Ingresso.codigo, Ingresso.origem, Ingresso.data, Vendedor.nome as vendedor, Cliente.nome as cliente, Cliente.telefone as telefone, Ingresso.valor, Ingresso.validade, Lote.nome as lote
                    FROM Ingresso JOIN Vendedor ON Ingresso.vendedor = Vendedor.id 
                    JOIN Cliente ON Ingresso.idCliente = Cliente.id
                    JOIN Lote ON Ingresso.lote =  Lote.id
                    WHERE Cliente.nome = '$senderName' AND Ingresso.lote = '$idLote'";
                    addtabela($consulta);
                echo('</tbody>');
            echo('</table>');
        echo('</div>');
    }

    function addtabela($consulta){
        $dados = selecionar($consulta);
        foreach ($dados as $obj) {
            echo "<tr>";
            echo ("<td>".$obj['codigo']."</td>");
            if($obj['origem'] == 1){
                $origem = "Promoter";
            }else if($obj['origem'] == 2){
                $origem = "Venda pelo Site";
            }
            echo ("<td>".$obj['cliente']."</td>");
            echo ("<td>R$".UsToBr($obj['valor'])."</td>"); 
            echo ("<td>".$obj['lote']."</td>");
            echo ("<td>".$obj['telefone']."</td>"); 
            echo ("<td>".$origem." - ".$obj['vendedor']."</td>"); 
            echo ("<td>".$obj['data']."</td>"); 
            $validade = $obj['validade'];
            echo ("<td>".$validade."</td>");
            if($validade == "VALIDO"){
                echo ("<td style='display: flex;'><a href='editar.php?id=".$obj['codigo']."' class='iconeTabela'><i class='fas fa-user-edit'></i></a>");  
                echo ("<a href='cancelar.php?id=".$obj['codigo']."' class='iconeTabela red'><i class='fas fa-user-times'></i></a>");  
                echo ("<a href='../enviar.php?codigo=".$obj['codigo']."' target='_blank' class='iconeTabela'><i class='far fa-copy'></i></a></td>");  
            }else{
                echo ("<td><a href='reativar.php?id=".$obj['codigo']."' style='margin-left: 15px;'>Reativar</a></td>");
            }
            echo "</tr>";
        }
    }
    ?>
    <?php
    include('../includes/footer.php');
?>