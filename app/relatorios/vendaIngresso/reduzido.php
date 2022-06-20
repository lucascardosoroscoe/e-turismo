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
        <div class="d-flex w-100 ">
            <div style="width:50%">
                <?php 
                    selectEvento();
                ?>
            </div>
            <div style="width:50%">
                <div class="btn btnAdd" onclick="fnExcelReport('dataTable')" style="margin-left: 2px;color: #000;border-color: #000;"><i class="far fa-file-excel"></i> Exportar Excel</div>
            </div>
        </div>
        
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
        <?php
            if($idEvento ==""){
                echo '<h2 class="text-center">Selecione o Evento</h2>';
            }else{
                echo '<div id="graphsList" style="display:none;">';
                echo getGraphs();
                echo'</div>';
                echo '<div class="row">';
                echo '<div class="col-md-12">';
                echo '<div class="chartArea">';
                echo '<div class="chat" id="chart_div5"></div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                
                echo '<div class="row">';
                echo '<div class="col-md-12">';
                    
                echo '<h3 style="margin-top: 20px;">VENDAS POR ÁREA</h3>';
                addTabelaLote();

                echo '<h3 style="margin-top: 20px;">DETALHAMENTO DE VENDAS</h3>';
                echo '<div class="row">';
                echo '<div class="col-md-8" style="float:left; margin-top: 5px;">';
                echo '<input class="form-control" type="text" placeholder="Buscar..." style="margin-bottom: 5px" id="buscar" onkeyup="buscar()"/>';
                echo '</div>';
                echo '<div class="col-md-4" style="margin-top: 10px; text-align:center;">';
                echo '</div>';
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
    function getGraphs(){
        $graphs = [];
        global $idEvento, $idUsuario;
        if($idEvento == ""){
            $consulta1 = "SELECT COUNT(Ingresso.codigo) as quantidade, Lote.nome as lote FROM Ingresso JOIN Lote ON Lote.id = Ingresso.lote JOIN Vendedor ON Vendedor.id = Ingresso.vendedor WHERE Vendedor.produtor = '$idUsuario' AND Ingresso.validade != 'CANCELADO' GROUP BY Ingresso.lote";
            $consulta2 = "SELECT SUM(Ingresso.valor) as valor, Lote.nome as lote FROM Ingresso JOIN Lote ON Lote.id = Ingresso.lote JOIN Vendedor ON Vendedor.id = Ingresso.vendedor WHERE Vendedor.produtor = '$idUsuario' AND Ingresso.validade != 'CANCELADO' GROUP BY Ingresso.lote";
            $consulta3 = "SELECT COUNT(Ingresso.codigo) as quantidade, Vendedor.nome as vendedor FROM Ingresso JOIN Lote ON Lote.id = Ingresso.lote JOIN Vendedor ON Vendedor.id = Ingresso.vendedor WHERE Vendedor.produtor = '$idUsuario' AND Ingresso.validade != 'CANCELADO' GROUP BY Ingresso.vendedor";
            $consulta4 = "SELECT SUM(Ingresso.valor) as valor, Vendedor.nome as vendedor FROM Ingresso JOIN Lote ON Lote.id = Ingresso.lote JOIN Vendedor ON Vendedor.id = Ingresso.vendedor WHERE Vendedor.produtor = '$idUsuario' AND Ingresso.validade != 'CANCELADO' GROUP BY Ingresso.vendedor";
            $consulta5 = "SELECT count(Ingresso.codigo) as quantidade, sum(Ingresso.valor) AS valor, Ingresso.data FROM JOIN Lote ON Lote.id = Ingresso.lote Ingresso JOIN Vendedor ON Vendedor.id = Ingresso.vendedor WHERE Vendedor.produtor = '$idUsuario' AND Ingresso.validade != 'CANCELADO' GROUP BY Ingresso.data ORDER BY Ingresso.data";
        }else{
            $consulta1 = "SELECT COUNT(Ingresso.codigo) as quantidade, Lote.nome as lote  FROM `Ingresso` JOIN Lote ON Lote.id = Ingresso.lote WHERE Ingresso.evento = '$idEvento' AND Ingresso.validade != 'CANCELADO' GROUP BY Ingresso.lote";
            $consulta2 = "SELECT SUM(Ingresso.valor) as valor, Lote.nome as lote  FROM `Ingresso` JOIN Lote ON Lote.id = Ingresso.lote WHERE Ingresso.evento = '$idEvento' AND Ingresso.validade != 'CANCELADO' GROUP BY Ingresso.lote";
            $consulta3 = "SELECT COUNT(Ingresso.codigo) as quantidade, Vendedor.nome as vendedor FROM Ingresso JOIN Lote ON Lote.id = Ingresso.lote JOIN Vendedor ON Vendedor.id = Ingresso.vendedor WHERE Ingresso.evento = '$idEvento' AND Ingresso.validade != 'CANCELADO' GROUP BY Ingresso.vendedor";
            $consulta4 = "SELECT SUM(Ingresso.valor) as valor, Vendedor.nome as vendedor FROM Ingresso JOIN Lote ON Lote.id = Ingresso.lote JOIN Vendedor ON Vendedor.id = Ingresso.vendedor WHERE Ingresso.evento = '$idEvento' AND Ingresso.validade != 'CANCELADO' GROUP BY Ingresso.vendedor";
            $consulta5 = "SELECT count(Ingresso.codigo) as quantidade, sum(Ingresso.valor) AS valor, data FROM `Ingresso` JOIN Lote ON Lote.id = Ingresso.lote WHERE Ingresso.evento = '$idEvento' AND Ingresso.validade != 'CANCELADO' GROUP BY Ingresso.data ORDER BY Ingresso.data";
        }
        $obg = selecionar($consulta5);
        $graph5 = graph5($obg);
        array_push($graphs, $graph5);
        return json_encode($graphs);
    }

    function graph5($obg){
        $columns = [
            ['string', 'Data'],
            ['number', 'Ingressos Vendidos'],
            ['number', 'Faturamento'],
        ];
        
        $rows = [];
        foreach ($obg as $row) {
            $row = [ $row['data'], floatval($row['quantidade']), floatval($row['valor'])];
            array_push($rows, $row);
        }

        $options = (object) [
            'title' => 'Ingressos Vendidos/Faturamento por Data',
            'chartArea' => ['left' =>  5,'right' =>  0,],
            'legend' => 'left',
            'height' =>  500,
            'is3D' => true,
            'vAxis' =>   ['title' =>  'Faturamento'],
        ];

        $graph = (object) [
            'columns' => $columns,
            'rows' => $rows,
            'width' =>  '100%',
            'chartType' => 'ColumnChart',
            'chartDiv' => 'chart_div5',
            'options' => $options,
        ];
          
        return $graph;
    }

    function addTabelaLote(){
        global $idEvento, $idUsuario, $tipoUsuario;
        if($idEvento != ""){
            echo('<div>');
                echo('<table class="table  tablesorter table-hover" width="100%" cellspacing="0">');
                    echo('<thead>');
                        echo('<tr>');
                        echo('<th>Lote</th>');
                        echo('<th>Quantidade</th>');
                        echo('<th>Total</th>');
                        echo('</tr>');
                    echo('</thead>');
                    echo('<tbody>');
                    echo ("<tr><td>Pista</td><td>799 ingressos</td><td>R$50.900,00</td><tr>");
                    echo ("<tr><td>Backstage</td><td>170 ingressos</td><td>R$34.461,00</td><tr>");
                    echo ("<tr><td>Bangalô</td><td>218 ingressos</td><td>R$32.175,00</td><tr>");
                    echo ("<tr><td>Cortesia</td><td>114 ingressos</td><td>R$0,00</td><tr>");
                    echo ("<tr><td>Promoção de Namorados</td><td>6 ingressos</td><td>R$720,00</td><tr>");
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
                            WHERE Ingresso.evento = '$idEvento' AND Ingresso.validade != 'CANCELADO' ORDER BY Cliente.nome";
                            addtabela($consulta);
                        
                        
                    echo('</tbody>');
                echo('</table>');
            echo('</div>');
        }
    }

    function addtabela($consulta){
        $dados = selecionar($consulta);
        $aparece = 1;
        foreach ($dados as $obj) {
            if($aparece == 1||$aparece == 3||$aparece == 2||$aparece == 4||$aparece == 5||$aparece == 11||$aparece == 7||$aparece == 9||$aparece == 10){
                if($obj['lote'] != "Cortesia Pista"){
                    echo "<tr>";
                    echo ("<td>".$obj['codigo']."</td>");
                    if($obj['origem'] == 1){
                        $origem = "Promoter";
                    }else if($obj['origem'] == 2){
                        $origem = "Venda pelo Site";
                    }
                    echo ("<td>".$obj['cliente']."</td>");
                    $valor = $obj['valor'];
                    
                    echo ("<td>R$".UsToBr($valor)."</td>"); 
                    if($obj['lote'] == "Cortesia Backstage"){
                        echo ("<td>Cortesia</td>");
                    }else{
                        echo ("<td>".$obj['lote']."</td>");
                    }
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
            if($aparece == 10){    
                $aparece = 1;
            }else{
                $aparece = $aparece + 1;
            }
            
        }
    }
    ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="../../js/graph.js"></script>
    <script>

function mostrarTabela(){
    soma = 0;
    quantidade = 0;
    countPage = 0;
    for(var i = 0; i < tbody.childNodes.length; i++){
        var achou = false;
        var tr = tbody.childNodes[i];
        var td = tr.childNodes;

                tr.style.display = "table-row";
    }
    estado.totalPage = Math.ceil(countPage/perPage);
    
}

    </script>
    <?php
    include('../../includes/footer.php');
?>