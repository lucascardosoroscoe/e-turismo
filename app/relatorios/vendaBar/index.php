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
        <div class="row" style="width: 100%;">
            <!-- <div class="col-md-6">
                <form action="index.php" method="get">
                    <input type="date" name="dataInicial" id="dataInicial" value="<?php echo $dataInicial;?>">
                    <input type="date" name="dataFinal" id="dataFinal" value="<?php echo $dataFinal;?>">
                    <button onclick="enviarForm()" class="btn btn-primary"><i class="fas fa-search"></i></button>
                </form>
            </div> -->
            <div class="col-md-12">
                <?php 
                    selectEvento();
                ?>
            </div>
        </div>
        
        
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <?php 
            if($idEvento == ""){
                $nomeEvento = "Todos os Eventos";
            }
            echo ('<p style="font-size: x-large;">Relatório de Vendas no Bar - '. $nomeEvento.'</p>');
            ?>
        </div>
        <div class="card-body" style="background-color: #eee;">
            <div id="graphsList" style="display:none;"><?php echo getGraphs();?></div>
            <div class="row">
                <div class="col-md-6">
                    <div class="chartArea">
                        <div class="chat" id="chart_div1"></div>
                    </div>
                    <!-- <div class="chartArea">
                        <div class="chat" id="chart_div3"></div>
                    </div> -->
                </div>
                <!-- <div class="col-md-6">
                    <div class="chartArea">
                        <div class="chat" id="chart_div2"></div>
                    </div>
                    <div class="chartArea">
                        <div class="chat" id="chart_div4"></div>
                    </div>
                </div> -->
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h3 style="margin-top: 20px;">DETALHAMENTO DE VENDAS NO BAR</h3>
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
                        <?php
                            if ($idEvento != ""){
                                $consulta = "SELECT SUM(VendaBar.valor) as soma
                                FROM VendaBar 
                                JOIN Produto ON Produto.idProduto = VendaBar.idProduto
                                WHERE VendaBar.idEvento = '$idEvento'
                                GROUP BY VendaBar.idEvento";
                            }
                            $dados = selecionar($consulta);
                            echo "<h5>Total Vendido: <span id='total'>R$". UsToBr($dados[0]['soma']) ."</span></h5>";
                        ?>
                            
                        </div>
                    </div>
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
        if($idEvento != ""){
            $consulta1 = "SELECT COUNT(VendaBar.id) as contagem, Produto.nome as produto, (COUNT(VendaBar.id) * Produto.valor) as total
            FROM VendaBar 
            JOIN Produto ON Produto.idProduto = VendaBar.idProduto
            WHERE VendaBar.idEvento = '$idEvento'
            GROUP BY Produto.idProduto
            ORDER BY total DESC";
        }
        // echo "Consulta: ". $consulta ."<br>";
        $obg = selecionar($consulta1);
        $graph1 = graph1($obg);
        array_push($graphs, $graph1);
        // $graph2 = graph2($obg);
        // array_push($graphs, $graph2);
        // $obg = selecionar($consulta3);
        // $graph3 = graph3($obg);
        // array_push($graphs, $graph3);
        // $obg = selecionar($consulta4);
        // $graph4 = graph4($obg);
        // array_push($graphs, $graph4);
        return json_encode($graphs);
    }

    function graph1($obg){
        $columns = [
            ['string', 'Produto'],
            ['number', 'Quantidade'],
        ];
        
        $rows = [];
        foreach ($obg as $row) {
            $row = [ $row['produto'], floatval($row['contagem'])];
            array_push($rows, $row);
        }

        $options = (object) [
            'title' => 'Quantidade Vendidos / Produto',
            'chartArea' => ['left' =>  5,'right' =>  0,],
            'legend' => 'left',
            'height' =>  300,
            'is3D' => true,
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
            ['string', 'Produto'],
            ['number', 'Faturamento (R$)'],
        ];
        
        $rows = [];
        foreach ($obg as $row) {
            $row = [ $row['produto'], floatval($row['total'])];
            array_push($rows, $row);
        }

        $options = (object) [
            'title' => 'Faturamento (R$) / Lote',
            'chartArea' => ['left' =>  5,'right' =>  0,],
            'legend' => 'left',
            'is3D' => true,
            'height' =>  300,
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

    function addTabelaOnline(){
        global $idEvento, $idUsuario, $dataInicial, $dataFinal, $consulta;
        echo('<div class="table-responsive">');
            echo('<table id="dataTable" class="table  tablesorter table-hover" width="100%" cellspacing="0">');
                echo('<thead>');
                    echo('<tr>');
                    echo('<th style="display:none;">Id</th>');
                    echo('<th>Produto</th>');
                    echo('<th>Quantidade</th>');
                    echo('<th>Valor Unitário</th>');
                    echo('<th>Total</th>');
                    echo('</tr>');
                echo('</thead>');
                echo('<tbody id="tbody">');
                    /* if($idEvento == ""){
                    //     $consulta = "SELECT wp_wc_order_stats.order_id, wp_wc_order_stats.date_created, 
                    //     wp_wc_order_stats.net_total, wp_wc_order_stats.status, wp_wc_customer_lookup.email , 
                    //     wp_wc_customer_lookup.first_name, wp_wc_customer_lookup.last_name, wp_wc_customer_lookup.postcode 
                    //     FROM wp_wc_order_stats 
                    //     JOIN wp_wc_customer_lookup ON wp_wc_customer_lookup.customer_id = wp_wc_order_stats.customer_id 
                    //     WHERE (wp_wc_order_stats.status = 'wc-processing' OR wp_wc_order_stats.status = 'wc-completed') 
                    //     AND wp_wc_order_stats.date_created >= '$dataInicial' AND wp_wc_order_stats.date_created <= '$dataFinal'";
                    // }else{
                    //     $consulta = "SELECT wp_wc_order_stats.order_id, wp_wc_order_stats.date_created, 
                    //     wp_wc_order_stats.net_total, wp_wc_order_stats.status, wp_wc_customer_lookup.email , 
                    //     wp_wc_customer_lookup.first_name, wp_wc_customer_lookup.last_name, wp_wc_customer_lookup.postcode 
                    //     FROM wp_wc_order_stats 
                    //     JOIN wp_wc_customer_lookup ON wp_wc_customer_lookup.customer_id = wp_wc_order_stats.customer_id 
                    //     WHERE (wp_wc_order_stats.status = 'wc-processing' OR wp_wc_order_stats.status = 'wc-completed') 
                    //     AND wp_wc_order_stats.date_created >= '$dataInicial' AND wp_wc_order_stats.date_created <= '$dataFinal'";
                     }*/
                    $consulta = "SELECT VendaBar.id, COUNT(VendaBar.id) as contagem, Produto.categoria, Produto.nome, Produto.valor, (COUNT(VendaBar.id) * Produto.valor) as total
                    FROM VendaBar 
                    JOIN Produto ON Produto.idProduto = VendaBar.idProduto
                    WHERE VendaBar.idEvento = '$idEvento'
                    GROUP BY Produto.idProduto
                    ORDER BY total DESC";

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
            echo ("<td>".$obj['categoria']." - ".$obj['nome']."</td>"); 
            echo ("<td>".$obj['contagem']."</td>"); 
            echo ("<td>R$".UsToBr($obj['valor'])."</td>"); 
            echo ("<td>R$".UsToBr($obj['total'])."</td>"); 
            echo ("<td></td>"); 
            echo "</tr>";
        }
    }
    ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="../../js/graph.js"></script>
    <?php
    include('../../includes/footer.php');
?>