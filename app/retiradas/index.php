<?php
include('../includes/verificarAcesso.php');
verificarAcesso(1);
include('../includes/header.php');


?>
<div class="container-fluid">
    <!-- Tabela dos veículos-->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            RETIRADAS
            <div class="btn btnAdd" onclick="fnExcelReport('dataTable')" style="margin-left: 2px;"><i class="far fa-file-excel"></i> Exportar Excel</div>
            <a href='adicionar.php'><div class="btn btnAdd"><i class='fas fa-user-plus'></i> Adicionar</div></a>
        </div>
        <div class="card-body">
            <?php msgAutomatica(); ?>
            <div class="row">
                <div class="col-md-8" style="float:left; margin-top: 5px;">
                    <input class="form-control" type="text" placeholder="Buscar..." style="margin-bottom: 5px" id="buscar" onkeyup="buscar()"/>
                </div>
            </div>
            <?php
                addTabelaRetiradas();
            ?>
        </div>
    </div>
</div>
<?php
function addTabelaRetiradas(){
        global $idEvento, $idUsuario, $tipoUsuario;
        if($idEvento != ""){
            echo('<div class="table-responsive table-hover">');
                echo('<table id="dataTable" class="table  tablesorter table-hover" width="100%" cellspacing="0">');
                    echo('<thead>');
                        echo('<tr>');
                        echo('<th style="display:none;">id</th>');
                        echo('<th>Data</th>');
                        echo('<th>Evento</th>');
                        echo('<th>Valor</th>');
                        echo('<th>PIX</th>');
                        echo('<th>Status</th>');
                        echo('<th>Executado</th>');
                        echo('<th>Taxas</th>');
                        echo('<th>Comprovantes</th>');
                        echo('</tr>');
                    echo('</thead>');
                    echo('<tbody id="tbody">');
                            $consulta = "SELECT Retiradas.id, Retiradas.valor, Retiradas.tipoPIX, Retiradas.chavePIX, Retiradas.nome, Retiradas.createdAt, 
                            Retiradas.updatedAt, Retiradas.status, Retiradas.comprovante, Retiradas.valorExecutado, Retiradas.valorTaxas, 
                            Retiradas.descricaoTaxas, Evento.nome as nomeEvento, Produtor.nome as nomeProdutor 
                            FROM Retiradas 
                            JOIN Evento ON Evento.id =  Retiradas.idEvento 
                            JOIN Produtor ON Produtor.id = Evento.produtor 
                            WHERE Retiradas.status != '4' 
                            ORDER BY status, createdAt;";
                            $dados = selecionar($consulta);
                            foreach ($dados as $retirada) {
                                echo "<tr>";
                                echo ("<td style='display:none;'>".$retirada['id']."</td>");
                                echo ("<td>GMT+0: ".$retirada['createdAt']."</td>");
                                echo ("<td>".$retirada['nomeProdutor']." - ".$retirada['nomeEvento']."</td>");
                                $valor = $retirada['valor'];
                                $valorExecutado = $retirada['valorExecutado'];
                                $valorTaxas = $retirada['valorTaxas'];
                                echo ("<td>R$".number_format($valor, 2, ',', '.')."</td>");
                                echo ("<td>".$retirada['tipoPIX'].": ".$retirada['chavePIX']." (".$retirada['nome'].")</td>");
                                $status = $retirada['status'];
                                if($status == '1'){
                                    echo ('<td>Aguardando Repasse</td>');
                                    echo ('<td><a href="comprovante.php"><i class="fas fa-link"></i> Concluir Pagamaento </a></td>');
                                }
                                if($status == '2'){
                                    echo ('<td>Repasse Realizado</td>');
                                    echo ("<td>R$".number_format($valorExecutado, 2, ',', '.')."</td>");
                                    echo ("<td>R$".number_format($valorTaxas, 2, ',', '.')." (".$retirada['descricaoTaxas'].")</td>");
                                    echo ("<td>Comprovante Anexado</td>");
                                }
                                echo "</tr>";
                            }
                    echo('</tbody>');
                echo('</table>');
            echo('</div>');
        }
    }
include('../includes/footer.php');
?>
