<?php
include('../../includes/verificarAcesso.php');
verificarAcesso(3);
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
        <?php 
        selectEvento();
        ?>
        <!-- <form action="veiculo.php" method="get">
            <input type="date" name="dataInicial" id="dataInicial" value="<?php echo $dataInicial;?>">
            <input type="date" name="dataFinal" id="dataFinal" value="<?php echo $dataFinal;?>">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
        </form> -->
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <?php 
            if($idEvento == ""){
                $nomeEvento = "Todos os Eventos";
            }
            echo ('<p style="font-size: x-large;">Relatório de Venda de Ingressos - '. $nomeEvento.'</p>');
            ?>
        </div>
        <div class="card-body" style="background-color: #eee;">
            <div class="row">
                <div class="col-md-12">
                    
                    <h3 style="margin-top: 20px;">Ingressosa Cancelados</h3>
                    <div class="row">
                        <div class="col-md-8" style="float:left; margin-top: 5px;">
                            <input class="form-control" type="text" placeholder="Buscar..." style="margin-bottom: 5px" id="buscar" onkeyup="buscar()"/>
                        </div>
                        <div class="col-md-4" style="margin-top: 10px; text-align:center;">
                            <div class="btn btnAdd" onclick="fnExcelReport('dataTable')" style="margin-left: 2px;color: #000;border-color: #000;"><i class="far fa-file-excel"></i> Exportar Excel</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6" style="margin-top: 10px; text-align:center;">
                            <h5>Numero de Ingressos: <span id='qIngressos'>R$</span></h5>
                        </div>
                        <div class="col-md-6" style="margin-top: 10px; text-align:center;">
                            <h5>Total Faturado: <span id='total'>R$</span></h5>
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
    function addTabelaVendas(){
        global $idEvento, $idUsuario, $tipoUsuario;
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
                    if($idEvento == ""){
                        if($tipoUsuario == 1){
                            $consulta = "SELECT Ingresso.codigo, Ingresso.origem, Ingresso.data, Vendedor.nome as vendedor, Cliente.nome as cliente, Cliente.telefone as telefone, Ingresso.valor, Ingresso.validade, Lote.nome as lote
                            FROM Ingresso JOIN Vendedor ON Ingresso.vendedor = Vendedor.id 
                            JOIN Cliente ON Ingresso.idCliente = Cliente.id
                            JOIN Lote ON Ingresso.lote =  Lote.id
                            ORDER BY Cliente.nome";
                        }else{
                            $consulta = "SELECT Ingresso.codigo, Ingresso.origem, Ingresso.data, Vendedor.nome as vendedor, Cliente.nome as cliente, Cliente.telefone as telefone, Ingresso.valor, Ingresso.validade, Lote.nome as lote
                            FROM Ingresso JOIN Vendedor ON Ingresso.vendedor = Vendedor.id 
                            JOIN Cliente ON Ingresso.idCliente = Cliente.id
                            JOIN Lote ON Ingresso.lote =  Lote.id
                            WHERE Vendedor.produtor = '$idUsuario' AND Ingresso.validade = 'CANCELADO' ORDER BY Cliente.nome";
                        }
                        
                    }else{
                        $consulta = "SELECT Ingresso.codigo, Ingresso.origem, Ingresso.data, Vendedor.nome as vendedor, Cliente.nome as cliente, Cliente.telefone as telefone, Ingresso.valor, Ingresso.validade, Lote.nome as lote
                        FROM Ingresso JOIN Vendedor ON Ingresso.vendedor = Vendedor.id 
                        JOIN Cliente ON Ingresso.idCliente = Cliente.id
                        JOIN Lote ON Ingresso.lote =  Lote.id
                        WHERE Ingresso.evento = '$idEvento' AND Ingresso.validade = 'CANCELADO' ORDER BY Cliente.nome";
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
                echo ("<a href='../../enviar.php?codigo=".$obj['codigo']."' target='_blank' class='iconeTabela'><i class='far fa-copy'></i></a></td>");  
            }else{
                echo ("<td><a href='reativar.php?id=".$obj['codigo']."' style='margin-left: 15px;'>Reativar</a></td>");
            }
            echo "</tr>";
        }
    }
    ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="../../js/graph.js"></script>
    <?php
    include('../../includes/footer.php');
?>