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
    <ol class="breadcrumb mb-4" style="margin-top: 20px !important;">
        <div class="row" style="width: 100%;">
            <div class="col-md-6">
                <?php selectEvento(); ?>
            </div>
            <div class="col-md-6">
                <?php selectVendedor(); ?>
            </div>
        </div>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <?php 
            echo ('<p style="font-size: x-large;"><i class="fas fa-table mr-1"></i> Relatório de Recebimentos de Ingressos - '. $nomeEvento.' ( Vendedor: '.$nomeVendedor.' )</p>');
            ?>
        </div>
        <div class="card-body" style="background-color: #eee;">
            
            <div class="row">
                <div class="col-md-6">
                    <h3>Total Vendido: R$<?php totalVendido(); ?></h3>
                </div>
                <div class="col-md-6">
                    <a href='../vendaIngresso/'><div class="btn btnAdd black"><i class='fas fa-user-plus'></i> Relatório de Vendas</div></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6" style="float:left; margin-top: 5px;">
                    <input class="form-control" type="text" placeholder="Buscar..." style="margin-bottom: 5px" id="buscar" onkeyup="buscar()"/>
                </div>
                <div class="col-md-6" style="margin-top: 6px;">
                    <div class="btn btnAdd black" onclick="fnExcelReport('dataTable')" style="margin-left: 2px;"><i class="far fa-file-excel"></i> Exportar Excel</div>
                    <a href='adicionar.php'><div class="btn btnAdd black"><i class='fas fa-user-plus'></i> Adicionar</div></a>
                </div>
            </div>
            <div class="table-responsive table-hover">
                <table class="table tablesorter table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="display:none;">Id</th>
                            <th>Valor Recebido</th>
                            <th>Data</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php
                                $consulta = "SELECT * FROM Recebidos WHERE `vendedor` = '$idVendedor' AND  `evento` = '$idEvento'";
                                addTabela($consulta);
                        ?>
                    </tbody>
                </table>
                <p style="display: none;" id="somaCustosTotal"><?php echo number_format($somaCustosTotal, 2, ',', '.');?></p>
                <p style="display: none;" id="somaCustosPlanejado"><?php echo number_format($somaCustosPlanejado, 2, ',', '.');?></p>
                <p style="display: none;" id="somaCustosPago"><?php echo number_format($somaCustosPago, 2, ',', '.');?></p>
            </div>

        </div>
    </div>
</div>


<?php

    function totalVendido(){
        global $idEvento, $idVendedor;
        $consulta = "SELECT Ingresso.codigo, Vendedor.nome as vendedor, Cliente.nome as cliente, 
        Ingresso.valor, Ingresso.validade 
        FROM Ingresso JOIN Vendedor ON Ingresso.vendedor = Vendedor.id 
        JOIN Cliente ON Ingresso.idCliente = Cliente.id
        WHERE Ingresso.evento = '$idEvento' AND Ingresso.vendedor = '$idVendedor'";
        $somatotal = 0;
        $dados = selecionar($consulta);
        foreach ($dados as $obj) {
            $validade = $obj['validade'] ;
            if($validade == "VALIDO"){
                $somatotal = $somatotal + floatval($obj['valor']);
            }
        }
        echo number_format($somatotal, 2, ',', '.');
    }

    function addTabela($consulta){
        global $somaRecebido;
        $dados = selecionar($consulta);
        $somaRecebido = 0;
        foreach ($dados as $obj) {
            echo "<tr>";
            echo ("<td style='display:none;'>".$obj['id']."</td>"); 
            echo ("<td>R$".UsToBr($obj['valor'])."</td>");
            echo ("<td>".$obj['data']."</td>"); 
            echo "</tr>";
        }
    }

    include('../../includes/footer.php');
?>