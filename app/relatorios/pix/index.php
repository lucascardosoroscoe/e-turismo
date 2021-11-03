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


<?php 
    function addTabelaOnline(){
        global $idEvento, $idUsuario, $dataInicial, $dataFinal, $consulta;
        echo('<div class="table-responsive">');
            echo('<table id="dataTable" class="table  tablesorter table-hover" width="100%" cellspacing="0">');
                echo('<thead>');
                    echo('<tr>');
                    echo('<th style="display:none;">id</th>');
                    echo('<th>Ingresso</th>');
                    echo('<th>Cliente</th>');
                    echo('<th>Telefone</th>');
                    echo('<th>Valor</th>');
                    echo('<th>Data</th>');
                    echo('<th>Status</th>');
                    echo('<th></th>');
                    echo('</tr>');
                echo('</thead>');
                echo('<tbody id="tbody">');
                    if($idEvento == ""){
                        $consulta = "SELECT wp_wc_order_stats.order_id, wp_wc_order_stats.date_created, 
                        wp_wc_order_stats.net_total, wp_wc_order_stats.status, wp_wc_customer_lookup.email , 
                        wp_wc_customer_lookup.first_name, wp_wc_customer_lookup.last_name, wp_wc_customer_lookup.postcode,
                        wp_wc_order_product_lookup.product_qty, wp_woocommerce_order_items.order_item_name
                        FROM wp_wc_order_stats 
                        JOIN wp_wc_customer_lookup ON wp_wc_customer_lookup.customer_id = wp_wc_order_stats.customer_id 
                        JOIN wp_wc_order_product_lookup ON wp_wc_order_product_lookup.order_id = wp_wc_order_stats.order_id
                        JOIN wp_woocommerce_order_items ON wp_woocommerce_order_items.order_id =  wp_wc_order_stats.order_id
                        WHERE wp_wc_order_stats.date_created >= '$dataInicial' AND wp_wc_order_stats.date_created <= '$dataFinal' AND wp_wc_order_stats.status != 'wc-trash' AND wp_woocommerce_order_items.order_item_type = 'line_item'
                        ORDER BY wp_wc_order_stats.date_created DESC";
                    }else{
                        $consulta = "SELECT wp_wc_order_stats.order_id, wp_wc_order_stats.date_created, 
                        wp_wc_order_stats.net_total, wp_wc_order_stats.status, wp_wc_customer_lookup.email , 
                        wp_wc_customer_lookup.first_name, wp_wc_customer_lookup.last_name, wp_wc_customer_lookup.postcode,
                        wp_wc_order_product_lookup.product_qty, wp_woocommerce_order_items.order_item_name
                        FROM wp_wc_order_stats 
                        JOIN wp_wc_customer_lookup ON wp_wc_customer_lookup.customer_id = wp_wc_order_stats.customer_id 
                        JOIN wp_wc_order_product_lookup ON wp_wc_order_product_lookup.order_id = wp_wc_order_stats.order_id
                        JOIN wp_woocommerce_order_items ON wp_woocommerce_order_items.order_id =  wp_wc_order_stats.order_id
                        WHERE wp_wc_order_stats.date_created >= '$dataInicial' AND wp_wc_order_stats.date_created <= '$dataFinal' AND wp_wc_order_stats.status != 'wc-trash' AND wp_woocommerce_order_items.order_item_type = 'line_item'
                        ORDER BY wp_wc_order_stats.date_created DESC";
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
            echo ("<td>".$obj['product_qty']." ingressos - ".$obj['order_item_name']."</td>"); 
            echo ("<td>".$obj['first_name']." - ".$obj['email']."</td>"); 
            echo ("<td>".$obj['last_name']."</td>"); 
            echo ("<td>R$".UsToBr($obj['net_total'])."</td>"); 
            echo ("<td>".formatarData($obj['date_created'])."</td>"); 
            if($obj['status'] == 'wc-processing'){
                echo ("<td>Aguardando Emissão</td>");
                echo ("<td style='display: table; text-align:center;'><a href='emitir.php?id=".$obj['order_id']."' style='color: blue !important;'><i class='fas fa-ticket-alt'></i> Ingresso</a></td>");  
            }else if($obj['status'] == 'wc-completed'){
                echo ("<td>Finalizado</td>");
                echo ("<td style='display: table; text-align:center;'><a href='https://api.whatsapp.com/send?phone=55".$obj['last_name']."' style='color: green !important;'><i class='fab fa-whatsapp'></i> Contato</a></td>");
            }else if($obj['status'] == 'wc-on-hold'){
                echo ("<td>Aguardando Pagamento</td>");
                echo ("<td style='display: table; text-align:center;'><a href='https://api.whatsapp.com/send?phone=55".$obj['last_name']."' style='color: green !important;'><i class='fab fa-whatsapp'></i> Contato</a></td>");
            }else if($obj['status'] == 'wc-repasse'){
                echo ("<td>Aguardando repasse</td>");
                echo ("<td style='display: table; text-align:center;'><a href='confirmar.php?id=".$obj['order_id']."' style='color: blue !important;'><i class='fas fa-search-dollar'></i> Repasse</a></td>");
            }else if($obj['status'] == 'wc-cancelled' || $obj['status'] == 'wc-failed' ){
                echo ("<td>Cancelado</td>");
                echo ("<td style='display: table; text-align:center;'><a href='https://api.whatsapp.com/send?phone=55".$obj['last_name']."' style='color: green !important;'><i class='fab fa-whatsapp'></i> Contato</a></td>");
            }else if($obj['status'] == 'wc-pending'){
                echo ("<td>Pagamento Pendente</td>");
                echo ("<td style='display: table; text-align:center;'><a href='https://api.whatsapp.com/send?phone=55".$obj['last_name']."' style='color: green !important;'><i class='fab fa-whatsapp'></i> Contato</a></td>");
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