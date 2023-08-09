<?php
include('../../includes/verificarAcesso.php');
verificarAcesso(2);
include('../../includes/header.php');
$dataInicial = $_GET['dataInicial'];
$dataFinal = $_GET['dataFinal'];
if($dataFinal == ""){
    $dataFinal = date('Y-m-d', time() + (24*60*60));
}
if($dataInicial == ""){
    $dataInicial = date('Y-m-d', time() - (30*24*60*60));
}
$nomeSecretaria = $_SESSION["nomeSecretaria"];
$idSecretaria = $_SESSION["idSecretaria"];
?>
<div class="container-fluid">

    <ol class="breadcrumb mb-4" style="margin-top: 20px !important">
        <div class="d-flex w-100 ">
            <div style="width:50%">
                <?php 
                    selectEvento();
                ?>
            </div>
            <div style="width:50%">
                <div class="btn btnAdd" onclick="fnExcelReport('dataTable')" style="margin-left: 2px;color: #000;border-color: #000;"><i class="fa fa-file-excel"></i> Exportar Excel</div>
            </div>
        </div>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <?php 
            if($idEvento == ""){
                $nomeEvento = "Todos os Eventos";
            }
            echo ('<p style="font-size: x-large;">Relatório de Venda de Ingressos Pelo Site - '. $nomeEvento.'</p>');
            ?>
        </div>
        <div class="card-body" style="background-color: #eee;">
        <?php
            if($idEvento ==""){
                echo '<h2 class="text-center">Selecione o Evento</h2>';
            }else{
                echo '<div class="row">';
                    echo '<div class="col-md-12">';     
                        echo '<h3 style="margin-top: 20px;">RETIRADAS ANTERIORES</h3>';
                        addTabelaRetiradas();
                    echo '</div>';
                echo '</div>';

                // ADICIONAR TAXAS
                // echo '<div class="row">';
                //     echo '<div class="col-md-12">';     
                //         echo '<h3 style="margin-top: 20px;">COBRANÇA DE TAXAS</h3>';
                //         addTabelaTaxas();
                //     echo '</div>';
                // echo '</div>';

                echo '<div class="row">';
                    echo '<div class="col-md-12">';     
                        echo '<h3 style="margin-top: 20px;">DETALHAMENTO DE VENDAS ONLINE</h3>';
                        echo '<div class="row">';
                            echo '<div class="col-md-8" style="float:left; margin-top: 5px;">';
                                echo '<input class="form-control" type="text" placeholder="Buscar..." style="margin-bottom: 5px" id="buscar" onkeyup="buscar()"/>';
                            echo '</div>';
                            echo '<div class="col-md-4" style="margin-top: 10px; text-align:center;"><a class="btn btnAdd" href="addRetirada.php" style="margin-left: 2px;color: #000;border-color: #000;"><i class="fas fa-wallet"></i> Solicitar Retirada</a></div>';
                        echo '</div>';
                        echo '<div class="row">';
                            echo '<div class="col-md-6" style="margin-top: 10px; text-align:center;">';
                                echo '<h5>Numero de Ingressos: <span id="qIngressos">R$</span></h5>';
                            echo '</div>';
                            echo '<div class="col-md-6" style="margin-top: 10px; text-align:center;">';
                                echo '<h5>Total Faturado: <span id="total">R$</span></h5>';
                            echo '</div>';
                        echo '</div>';
                        addTabelaVendas();
                    echo '</div>';
                echo '</div>';
            }
        ?>

        </div>
    </div>
</div>


<?php
    
    function addTabelaRetiradas(){
        global $idEvento, $idUsuario, $tipoUsuario;
        if($idEvento != ""){
            echo('<div>');
                echo('<table class="table  tablesorter table-hover" width="100%" cellspacing="0">');
                    echo('<thead>');
                        echo('<tr>');
                        echo('<th style="display:none;">id</th>');
                        echo('<th>Data</th>');
                        echo('<th>Valor</th>');
                        echo('<th>PIX</th>');
                        echo('<th>Status</th>');
                        echo('<th>Comprovantes</th>');
                        echo('</tr>');
                    echo('</thead>');
                    echo('<tbody>');
                            $consulta = "SELECT * FROM Retiradas WHERE Retiradas.idEvento = '$idEvento'";
                            $dados = selecionar($consulta);
                            foreach ($dados as $retirada) {
                                echo "<tr>";
                                echo ("<td style='display:none;'>".$retirada['id']."</td>");
                                echo ("<td>GMT+0: ".$retirada['createdAt']."</td>");
                                $valor = $retirada['valor'];
                                echo ("<td>R$".number_format($valor, 2, ',', '.')."</td>");
                                echo ("<td>".$retirada['tipoPIX'].": ".$retirada['chavePIX']." (".$retirada['nome'].")</td>");
                                $status = $retirada['status'];
                                if($status == '1'){
                                    echo ('<td>Aguardando Repasse</td>');
                                    echo ('<td>Apenas após conclusão do pagamento. Dúvidas? <a href="https://api.whatsapp.com/send?phone=5567999854042&text=Ol%C3%A1%2C%20gostaria%20de%20tirar%20uma%20d%C3%BAvida%20sobre%20minha%20retirada%20de%20dinheiro%20das%20vendas%20online%20nana%20plataforma%3A%20*DIGITE%20SUA%20D%C3%9AVIDA%20ABAIXO*">Clique Aqui</a></td>');
                                }
                                echo "</tr>";
                            }
                    echo('</tbody>');
                echo('</table>');
            echo('</div>');
        }
    }

    function addTabelaVendas(){
        global $idEvento, $idUsuario, $tipoUsuario;
        if($idEvento != ""){
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
                        echo('<th>Cupom</th>');
                        echo('<th>Data</th>');
                        echo('<th>Validade</th>');
                        echo('<th></th>');
                        echo('</tr>');
                    echo('</thead>');
                    echo('<tbody id="tbody">');
                        
                            $consulta = "SELECT Ingresso.codigo, Ingresso.origem, Ingresso.data, Ingresso.cupom, Vendedor.nome as vendedor, Cliente.nome as cliente, Cliente.telefone as telefone, Ingresso.valor, Ingresso.validade, Lote.nome as lote
                            FROM Ingresso JOIN Vendedor ON Ingresso.vendedor = Vendedor.id 
                            JOIN Cliente ON Ingresso.idCliente = Cliente.id
                            JOIN Lote ON Ingresso.lote =  Lote.id
                            WHERE Ingresso.evento = '$idEvento' AND Ingresso.validade != 'CANCELADO' AND Ingresso.vendedor = '1' ORDER BY Cliente.nome";
                            addtabela($consulta);
                            $consulta = "SELECT Ingresso.codigo, Ingresso.origem, Ingresso.data, Ingresso.cupom, Vendedor.nome as vendedor, Cliente.nome as cliente, Cliente.telefone as telefone, Ingresso.valor, Ingresso.validade, Lote.nome as lote
                            FROM Ingresso JOIN Vendedor ON Ingresso.vendedor = Vendedor.id 
                            JOIN Cliente ON Ingresso.idCliente = Cliente.id
                            JOIN Lote ON Ingresso.lote =  Lote.id
                            WHERE Ingresso.evento = '$idEvento' AND Ingresso.validade != 'CANCELADO' AND Ingresso.vendedor != '1' AND Ingresso.origem = '2' ORDER BY Cliente.nome";
                            addtabela($consulta);
                        
                        
                    echo('</tbody>');
                echo('</table>');
            echo('</div>');
        }
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
            echo ("<td>".$obj['cupom']."</td>"); 
            echo ("<td>".$obj['data']."</td>"); 
            $validade = $obj['validade'];
            echo ("<td>".$validade."</td>");    
            echo "</tr>";
        }
    }
    ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="../../js/graph.js"></script>
    <?php
    include('../../includes/footer.php');
?>