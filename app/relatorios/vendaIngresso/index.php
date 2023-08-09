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
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <?php 
            if($idEvento == ""){
                $nomeEvento = "Todos os Eventos";
            }
            echo ('<p style="font-size: x-large;"><img src="http://ingressozapp.com/app/img/logo.png" alt="IngressoZapp" srcset="" style="height:40px;"> Relatório de Venda de Ingressos - '. $nomeEvento.'</p>');
            ?>
        </div>
        <div class="card-body" style="background-color: #eee;">
            <?php
                if($idEvento ==""){
                    echo '<h2 class="text-center">Selecione o Evento</h2>';
                }else{
                    echo '<div class="row">';
                        echo '<div class="col-md-12">';
                            echo '<h3 style="margin-top: 20px;">VENDAS POR LOTE</h3>';
                            addTabelaBordero();
                            echo '<h3 style="margin-top: 20px;">VENDAS POR VENDEDOR</h3>';
                            addTabelaVendedor();
                            echo '<h3 style="margin-top: 20px;">DETALHAMENTO DE VENDAS</h3>';
                            echo '<div class="row">';
                                echo '<div class="col-md-8" style="float:left; margin-top: 5px;">';
                                    echo '<input class="form-control" type="text" placeholder="Buscar..." style="margin-bottom: 5px" id="buscar" onkeyup="buscar()"/>';
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
                    
                    echo '<div id="graphsList" style="display:none;">';
                    echo getGraphs();
                    echo'</div>';
                    echo '<div class="row">';
                        echo '<div class="col-md-12">';
                            echo '<div class="chartArea">';
                            echo '<div class="chat" id="chart_div1"></div>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';                        
                }
            ?>
        </div>
        <div class="card-footer" style="background-color: #eee;">
            OBS.: Os ingressos Impressos podem ser emitidos com o valor = R$0,00 mas ser vendidos por outros valores, tendo em vista que apenas o lote é exibido no ingresso, sem o valor.<br>
            Data de Emissão: <?php echo date('d/m/Y h:i');?> (Brasília)<br>
            https://ingressozapp.com/app/relatorios/bordero/?evento=<?php echo $idEvento;?>
        </div>
    </div>
</div>

</div></div>


<?php
    function getGraphs(){
        $graphs = [];
        global $idEvento, $idUsuario;
        if($idEvento != ""){
            $consulta1 = "SELECT Ingresso.codigo, Ingresso.valor, Ingresso.created_at as data FROM `Ingresso` JOIN Lote ON Lote.id = Ingresso.lote WHERE Ingresso.evento = '$idEvento' AND Ingresso.validade != 'CANCELADO' AND (Ingresso.origem = 1 OR Ingresso.origem = 2) ORDER BY Ingresso.created_at";
            $consulta3 = "SELECT COUNT(Ingresso.codigo) as quantidade, Vendedor.nome as vendedor FROM Ingresso JOIN Lote ON Lote.id = Ingresso.lote JOIN Vendedor ON Vendedor.id = Ingresso.vendedor WHERE Ingresso.evento = '$idEvento' AND Ingresso.validade != 'CANCELADO' GROUP BY Ingresso.vendedor";
            $consulta4 = "SELECT SUM(Ingresso.valor) as valor, Vendedor.nome as vendedor FROM Ingresso JOIN Lote ON Lote.id = Ingresso.lote JOIN Vendedor ON Vendedor.id = Ingresso.vendedor WHERE Ingresso.evento = '$idEvento' AND Ingresso.validade != 'CANCELADO' GROUP BY Ingresso.vendedor";
            // echo "Consulta: ". $consulta ."<br>";
            
            $obg = selecionar($consulta1);
            $graph1 = graph1($obg);
            array_push($graphs, $graph1);
            $obg = selecionar($consulta3);
            $graph3 = graph3($obg);
            array_push($graphs, $graph3);
            $obg = selecionar($consulta4);
            $graph4 = graph4($obg);
            array_push($graphs, $graph4);
            return json_encode($graphs);
        }
        
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
    function graph1($obg){
        $columns = [
            ['string', 'Data'],
            ['number', 'Ingressos Vendidos'],
            ['number', 'Faturamento'],
        ];
        
        $rows = [];
        $dataAnterior = "";
        $contagem = 0;
        $valor = 0;
        foreach ($obg as $row) {
            $dataGTM0 = $row['data'];
            $dataMS = date('d/m/Y', strtotime( $dataGTM0 ) - (60*60*4));
            if($dataAnterior == "" || $dataAnterior == $dataMS){
                $contagem = $contagem + 1;
                $valor = $valor + $row['valor'];
            }else{
                $valorNovo = $row['valor'] + 0;
                $row = [ $dataAnterior, $contagem, $valor];
                array_push($rows, $row);
                $contagem = 1;
                $valor = $valorNovo;
            }
            $dataAnterior = $dataMS;
        }
        if($obg[0] != ""){ 
            $array = [ $dataMS, $contagem, $valor];
            array_push($rows, $array);
        }

        $options = (object) [
            'title' => 'Ingressos Vendidos/Faturamento por Data (Fora Impressos)',
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
            'chartDiv' => 'chart_div1',
            'options' => $options,
        ];
          
        return $graph;
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
                        
                            $consulta = "SELECT Ingresso.codigo, Ingresso.origem, Ingresso.pedido, Ingresso.created_at as data, Vendedor.nome as vendedor, Cliente.nome as cliente, Cliente.telefone as telefone, Ingresso.valor, Ingresso.validade, Lote.nome as lote
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
        global $tipoUsuario;
        $dados = selecionar($consulta);
        foreach ($dados as $obj) {
            echo "<tr>";
            echo ("<td>".$obj['codigo']."</td>");
            echo ("<td>".$obj['cliente']."</td>");
            echo ("<td>R$".UsToBr($obj['valor'])."</td>"); 
            echo ("<td>".$obj['lote']."</td>");
            echo ("<td>".$obj['telefone']."</td>"); 
            if($obj['origem'] == 1){
                $origem = "Promoter";
                echo ("<td>".$origem." - ".$obj['vendedor']."</td>"); 

            }else if($obj['origem'] == 2){
                $origem = "Venda pelo Site";
                echo ("<td>".$origem." - ".$obj['vendedor']." - Pedido: ".$obj['pedido']."</td>"); 
            }else if($obj['origem'] == 3){
                $origem = "Ingresso Impresso";
                echo ("<td>".$origem."</td>"); 
            }
            $dataGTM0 = $obj['data'];
            $dataMS = date('d/m/Y', strtotime( $dataGTM0 ) - (60*60*4));
            echo ("<td>".$dataMS."</td>"); 
            $validade = $obj['validade'];
            echo ("<td>".$validade."</td>");
            echo ("<td style='display: flex;'>");
            if($validade == "VALIDO"){
                echo ("<a href='editar.php?id=".$obj['codigo']."' class='iconeTabela'><i class='fas fa-user-edit'></i></a>");  
                echo ("<a href='cancelar.php?id=".$obj['codigo']."' class='iconeTabela red'><i class='fas fa-user-times'></i></a>");  
                if($tipoUsuario == 1){
                    echo ("<a href='usado.php?id=".$obj['codigo']."' style='margin-left: 15px;'>Baixar</a>");
                }
                echo ("<a href='../../enviar.php?codigo=".$obj['codigo']."' target='_blank' class='iconeTabela'><i class='far fa-copy'></i></a></td>");  
            }else{
                if($tipoUsuario == 1){
                    echo ("<a href='reativar.php?id=".$obj['codigo']."' style='margin-left: 15px;'>Reativar</a>");
                }
            }
            echo ("</td>");
            
            echo "</tr>";
        }
    }
    function addTabelaBordero(){
        global $idEvento, $somabordero, $contagembordero;
        if($idEvento != ""){
            echo('<div>');
                echo('<table id="dataTable" class="table  tablesorter table-hover" width="100%" cellspacing="0">');
                    echo('<thead>');
                        echo('<tr>');
                            echo('<th>Lote</th>');
                            echo('<th>Quantidade</th>');
                            echo('<th>Valor</th>');
                        echo('</tr>');
                    echo('</thead>');
                    echo('<tbody>');
                            $somabordero = 0;
                            $contagembordero = 0;
                        
                            $consulta = "SELECT Lote.nome as lote, count(Ingresso.valor) AS contagem, sum(Ingresso.valor) AS soma FROM Ingresso JOIN Vendedor ON Ingresso.vendedor = Vendedor.id
                            JOIN Cliente ON Ingresso.idCliente = Cliente.id
                            JOIN Lote ON Ingresso.lote =  Lote.id 
                            WHERE Ingresso.evento = '$idEvento' AND Ingresso.validade != 'CANCELADO'
                            GROUP BY Lote.id";

                            addbordero($consulta);
                        
                            echo "<tr style='border-top: solid;'>";
                                echo ("<td>TOTAL</td>");
                                echo ("<td>".$contagembordero."</td>");
                                echo ("<td>R$".UsToBr($somabordero)."</td>"); 
                            echo "</tr>";
                    echo('</tbody>');
                echo('</table>'); 
            echo('</div>');
        }
    }
    function addbordero($consulta){
        global $tipoUsuario, $somabordero, $contagembordero;
        $dados = selecionar($consulta);
        foreach ($dados as $obj) {
            echo "<tr>";
                echo ("<td>".$obj['lote']."</td>");
                echo ("<td>".$obj['contagem']."</td>");
                echo ("<td>R$".UsToBr($obj['soma'])."</td>"); 
                $somabordero = $somabordero + $obj['soma'];
                $contagembordero = $contagembordero + $obj['contagem'];
            echo "</tr>";
        }
    }
    function addTabelaVendedor(){
        global $idEvento, $somavendedor, $contagemvendedor;
        if($idEvento != ""){
            echo('<div>');
                echo('<table class="table  tablesorter table-hover" width="100%" cellspacing="0">');
                    echo('<thead>');
                        echo('<tr>');
                            echo('<th>Vendedor</th>');
                            echo('<th>Quantidade</th>');
                            echo('<th>Valor</th>');
                        echo('</tr>');
                    echo('</thead>');
                    echo('<tbody>');
                            $somavendedor = 0;
                            $contagemvendedor = 0;
                        
                            $consulta = "SELECT Vendedor.nome as vendedor, count(Ingresso.valor) AS contagem, sum(Ingresso.valor) AS soma FROM Ingresso 
                            JOIN Vendedor ON Ingresso.vendedor = Vendedor.id
                            WHERE Ingresso.evento = '$idEvento' AND Ingresso.validade != 'CANCELADO'
                            GROUP BY Vendedor.nome";

                            addVendedor($consulta);
                            echo "<tr style='border-top: solid;'>";
                                echo ("<td>TOTAL</td>");
                                echo ("<td>".$contagemvendedor."</td>");
                                echo ("<td>R$".UsToBr($somavendedor)."</td>"); 
                            echo "</tr>";
                    echo('</tbody>');
                echo('</table>'); 
            echo('</div>');
        }
    }
    function addVendedor($consulta){
        global $somavendedor, $contagemvendedor;
        $dados = selecionar($consulta);
        foreach ($dados as $obj) {
            echo "<tr>";
                echo ("<td>".$obj['vendedor']."</td>");
                echo ("<td>".$obj['contagem']."</td>");
                echo ("<td>R$".UsToBr($obj['soma'])."</td>"); 
                $somavendedor = $somavendedor + $obj['soma'];
                $contagemvendedor = $contagemvendedor + $obj['contagem'];
            echo "</tr>";
        }
    }
    ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="../../js/graph.js"></script>
    <?php
    include('../../includes/footer.php');
?>