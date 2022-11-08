<?php
include('../../includes/verificarAcesso.php');
verificarAcesso(1);
include('../../includes/header.php');
?>
<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            Relatório de Pagamentos
            <div class="btn btnAdd" onclick="fnExcelReport('dataTable')" style="margin-left: 2px;"><i class="far fa-file-excel"></i> Exportar Excel</div>
        </div>
        <div class="card-body" style="background-color: #eee;">
        <?php
                echo '<div class="row">';
                    echo '<div class="col-md-12">';     
                        echo '<h3 style="margin-top: 20px;">Solicitação de Retirada</h3>';
                        addTabelaRetiradas();
                    echo '</div>';
                echo '</div>';
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
                                echo '<h5>Numero de Eventos: <span id="qIngressos">R$</span></h5>';
                            echo '</div>';
                            echo '<div class="col-md-6" style="margin-top: 10px; text-align:center;">';
                                echo '<h5>Total Vendido Online: <span id="total">R$</span></h5>';
                            echo '</div>';
                        echo '</div>';
                        addTabelaVendas();
                    echo '</div>';
                echo '</div>';
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
                            $consulta = "SELECT * FROM Retiradas WHERE Retiradas.status = 1 ORDER BY id DESC";
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
                                    echo ('<td><a href="executar.php?id='.$retirada['id'].'">Executar</a></td>');
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
                        echo('<th>Evento</th>');
                        echo('<th>Quantidade</th>');
                        echo('<th>Valor Vendido</th>');
                        // echo('<th>Lote</th>');
                        // echo('<th>Telefone</th>');
                        // echo('<th>Vendedor</th>');
                        // echo('<th>Data</th>');
                        // echo('<th>Validade</th>');
                        echo('<th></th>');
                        echo('</tr>');
                    echo('</thead>');
                    echo('<tbody id="tbody">');
                        
                            $consulta = "SELECT Evento.id, Evento.nome, SUM(Ingresso.valor) as valorVendido, COUNT(Ingresso.codigo) as qVendida FROM Ingresso JOIN Vendedor ON Ingresso.vendedor = Vendedor.id JOIN Cliente ON Ingresso.idCliente = Cliente.id JOIN Lote ON Ingresso.lote = Lote.id JOIN Evento ON Evento.id = Lote.evento WHERE ((Ingresso.validade != 'CANCELADO' AND Ingresso.vendedor = '1') OR (Ingresso.validade != 'CANCELADO' AND Ingresso.vendedor != '1' AND Ingresso.origem = '2')) AND Evento.validade = 'VALIDO' GROUP BY Evento.id;";
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
            echo ("<td>".$obj['nome']."</td>");
            echo ("<td>".$obj['qVendida']."</td>");
            echo ("<td>R$".UsToBr($obj['valorVendido'])."</td>"); 
            // echo ("<td>".$obj['lote']."</td>");
            // echo ("<td>".$obj['telefone']."</td>"); 
            // echo ("<td>".$origem." - ".$obj['vendedor']."</td>"); 
            // echo ("<td>".$obj['data']."</td>"); 
            // $validade = $obj['validade'];
            // echo ("<td>".$validade."</td>");    
            echo "</tr>";
        }
    }
    ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="../../js/graph.js"></script>
    <?php
    include('../../includes/footer.php');
?>