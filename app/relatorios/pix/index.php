<?php
include('../../includes/verificarAcesso.php');
verificarAcesso(1);
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
        <!-- <?php 
        selectEvento();
        ?> -->
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
            echo ('<p style="font-size: x-large;">Entrada de Recursos via PIX</p>');
            ?>
        </div>
        <div class="card-body" style="background-color: #eee;">
            <!-- <div id="graphsList" style="display:none;"><?php echo getGraphs();?></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="chartArea">
                        <div class="chat" id="chart_div5"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="chartArea">
                        <div class="chat" id="chart_div1"></div>
                    </div>
                    <div class="chartArea">
                        <div class="chat" id="chart_div2"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="chartArea">
                        <div class="chat" id="chart_div3"></div>
                    </div>
                    <div class="chartArea">
                        <div class="chat" id="chart_div4"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="chartArea">
                        <div class="chat" id="chart_div6"></div>
                    </div>
                    <div class="chartArea">
                        <div class="chat" id="chart_div7"></div>
                    </div>
                </div>
            </div> -->
            
            <!-- <div class="row">
                <div class="col-md-6">
                    <div class="chartArea">
                        <div class="chat" id="chart_div6"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="chartArea">
                        <div class="chat" id="chart_div7"></div>
                    </div>
                </div>
            </div> -->
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
        // echo "Consulta: ". $consulta ."<br>";
        $obg = selecionar($consulta1);
        $graph1 = graph1($obg);
        array_push($graphs, $graph1);
        $obg = selecionar($consulta2);
        $graph2 = graph2($obg);
        array_push($graphs, $graph2);
        $obg = selecionar($consulta3);
        $graph3 = graph3($obg);
        array_push($graphs, $graph3);
        $obg = selecionar($consulta4);
        $graph4 = graph4($obg);
        array_push($graphs, $graph4);
        $obg = selecionar($consulta5);
        $graph5 = graph5($obg);
        array_push($graphs, $graph5);
        $graph6 = graph6($obg);
        array_push($graphs, $graph6);
        $graph7 = graph7($obg);
        array_push($graphs, $graph7);
        return json_encode($graphs);
    }

    function graph1($obg){
        $columns = [
            ['string', 'Lote'],
            ['number', 'Quantidade'],
        ];
        
        $rows = [];
        foreach ($obg as $row) {
            $row = [ $row['lote'], floatval($row['quantidade'])];
            array_push($rows, $row);
        }

        $options = (object) [
            'title' => 'Quantidade de Ingressos / Lote',
            'chartArea' => ['left' =>  5,'right' =>  0,],
            'legend' => 'left',
            'height' =>  300,
            'is3D' => true,
            'vAxis' =>   ['title' =>  'R$'],
            'hAxis' =>   ['title' =>  'Dia'],
        ];

        $graph = (object) [
            'columns' => $columns,
            'rows' => $rows,
            'width' =>  '100%',
            'chartType' => 'PieChart',
            'chartDiv' => 'chart_div1',
            'options' => $options,
        ];
          
        return $graph;
    }

    function graph2($obg){
        $columns = [
            ['string', 'Lote'],
            ['number', 'Faturamento (R$)'],
        ];
        
        $rows = [];
        foreach ($obg as $row) {
            $row = [ $row['lote'], floatval($row['valor'])];
            array_push($rows, $row);
        }

        $options = (object) [
            'title' => 'Faturamento (R$) / Lote',
            'chartArea' => ['left' =>  5,'right' =>  0,],
            'legend' => 'left',
            'is3D' => true,
            'height' =>  300,
            'vAxis' =>   ['title' =>  'R$'],
            'hAxis' =>   ['title' =>  'Veículo'],
        ];

        $graph = (object) [
            'columns' => $columns,
            'rows' => $rows,
            'width' =>  '100%',
            'chartType' => 'PieChart',
            'chartDiv' => 'chart_div2',
            'options' => $options,
        ];
          
        return $graph;
    }

    function graph3($obg){
        $columns = [
            ['string', 'Vendedor'],
            ['number', 'Quantidade'],
        ];
        
        $rows = [];
        foreach ($obg as $row) {
            $row = [ $row['vendedor'], floatval($row['quantidade'])];
            array_push($rows, $row);
        }

        $options = (object) [
            'title' => 'Ingressos Vendidos/Vendedor',
            'chartArea' => ['left' =>  5,'right' =>  0,],
            'legend' => 'left',
            'height' =>  300,
            'is3D' => true,
            'vAxis' =>   ['title' =>  ''],
            'hAxis' =>   ['title' =>  'Vendedor'],
        ];

        $graph = (object) [
            'columns' => $columns,
            'rows' => $rows,
            'width' =>  '100%',
            'chartType' => 'PieChart',
            'chartDiv' => 'chart_div3',
            'options' => $options,
        ];
          
        return $graph;
    }
    function graph4($obg){
        $columns = [
            ['string', 'Vendedor'],
            ['number', 'Faturamento'],
        ];
        
        $rows = [];
        foreach ($obg as $row) {
            $row = [ $row['vendedor'], floatval($row['valor'])];
            array_push($rows, $row);
        }

        $options = (object) [
            'title' => 'Faturamento R$/Vendedor',
            'chartArea' => ['left' =>  5,'right' =>  0,],
            'legend' => 'left',
            'height' =>  300,
            'is3D' => true,
            'vAxis' =>   ['title' =>  'Faturamento'],
            'hAxis' =>   ['title' =>  'Vendedor'],
        ];

        $graph = (object) [
            'columns' => $columns,
            'rows' => $rows,
            'width' =>  '100%',
            'chartType' => 'PieChart',
            'chartDiv' => 'chart_div4',
            'options' => $options,
        ];
          
        return $graph;
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
    function graph6($obg){
        $columns = [
            ['string', 'Data'],
            ['number', 'Faturamento Acumulado'],
        ];
        
        $rows = [];
        $soma = 0;
        foreach ($obg as $row) {
            $soma += floatval($row['valor']);
            $row = [ $row['data'], $soma];
            array_push($rows, $row);
        }

        $options = (object) [
            'title' => 'Faturamento Acumulado / Data',
            'chartArea' => ['left' =>  5,'right' =>  0,],
            'legend' => 'left',
            'height' =>  300,
            'is3D' => true,
            'vAxis' =>   ['title' =>  'Faturamento'],
        ];

        $graph = (object) [
            'columns' => $columns,
            'rows' => $rows,
            'width' =>  '100%',
            'chartType' => 'AreaChart',
            'chartDiv' => 'chart_div6',
            'options' => $options,
        ];
          
        return $graph;
    }

    function graph7($obg){
        $columns = [
            ['string', 'Data'],
            ['number', 'Ingressos Vendidos Acumulado'],
        ];
        
        $rows = [];
        $soma = 0;
        foreach ($obg as $row) {
            $soma += floatval($row['quantidade']);
            $row = [ $row['data'], $soma];
            array_push($rows, $row);
        }

        $options = (object) [
            'title' => 'Ingressos Vendidos Acumulado / Data',
            'chartArea' => ['left' =>  5,'right' =>  0,],
            'legend' => 'left',
            'height' =>  300,
            'is3D' => true,
            'vAxis' =>   ['title' =>  'Faturamento'],
        ];

        $graph = (object) [
            'columns' => $columns,
            'rows' => $rows,
            'width' =>  '100%',
            'chartType' => 'AreaChart',
            'chartDiv' => 'chart_div7',
            'options' => $options,
        ];
          
        return $graph;
    }

    function addTabelaOnline(){
        global $idEvento, $idUsuario, $dataInicial, $dataFinal, $consulta;
        echo('<div class="table-responsive">');
            echo('<table id="dataTable" class="table  tablesorter table-hover" width="100%" cellspacing="0">');
                echo('<thead>');
                    echo('<tr>');
                    echo('<th style="display:none;">id</th>');
                    echo('<th>Cliente</th>');
                    echo('<th>Telefone</th>');
                    echo('<th>Valor</th>');
                    echo('<th>CEP</th>');
                    echo('<th>Data</th>');
                    echo('<th>Status</th>');
                    echo('<th></th>');
                    echo('</tr>');
                echo('</thead>');
                echo('<tbody id="tbody">');
                    if($idEvento == ""){
                        $consulta = "SELECT wp_wc_order_stats.order_id, wp_wc_order_stats.date_created, 
                        wp_wc_order_stats.net_total, wp_wc_order_stats.status, wp_wc_customer_lookup.email , 
                        wp_wc_customer_lookup.first_name, wp_wc_customer_lookup.last_name, wp_wc_customer_lookup.postcode 
                        FROM wp_wc_order_stats 
                        JOIN wp_wc_customer_lookup ON wp_wc_customer_lookup.customer_id = wp_wc_order_stats.customer_id 
                        WHERE wp_wc_order_stats.date_created >= '$dataInicial' AND wp_wc_order_stats.date_created <= '$dataFinal'
                        ORDER BY wp_wc_order_stats.date_created";
                    }else{
                        $consulta = "SELECT wp_wc_order_stats.order_id, wp_wc_order_stats.date_created, 
                        wp_wc_order_stats.net_total, wp_wc_order_stats.status, wp_wc_customer_lookup.email , 
                        wp_wc_customer_lookup.first_name, wp_wc_customer_lookup.last_name, wp_wc_customer_lookup.postcode 
                        FROM wp_wc_order_stats 
                        JOIN wp_wc_customer_lookup ON wp_wc_customer_lookup.customer_id = wp_wc_order_stats.customer_id 
                        WHERE wp_wc_order_stats.date_created >= '$dataInicial' AND wp_wc_order_stats.date_created <= '$dataFinal'
                        ORDER BY wp_wc_order_stats.date_created";
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
            echo ("<td style='display:none;'>".$obj['order_id']."</td>");
            echo ("<td>".$obj['first_name']." - ".$obj['email']."</td>"); 
            echo ("<td>".$obj['last_name']."</td>"); 
            echo ("<td>R$".UsToBr($obj['net_total'])."</td>"); 
            echo ("<td>".$obj['postcode']."</td>"); 
            echo ("<td>".formatarData($obj['date_created'])."</td>"); 
            if($obj['status'] == 'wc-processing'){
                echo ("<td>Pago</td>");
                echo ("<td style='display: flex;'><a href='invalidar.php?id=".$obj['codigo']."' class='iconeTabela red'><i class='fas fa-user-times'></i></a></td>");  
            }else if($obj['status'] == 'wc-completed'){
                echo ("<td>Crédito Adicionado</td>");
                echo ("<td><a href='reativar.php?id=".$obj['codigo']."' style='margin-left: 15px;'>Reativar</a></td>");
            }else if($obj['status'] == 'wc-on-hold'){
                echo ("<td>Aguardando Pagamento</td>");
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