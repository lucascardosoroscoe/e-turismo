<?php
include('../includes/verificarAcesso.php');
verificarAcesso(2);
include('../includes/header.php');

?>
<div class="container-fluid">
    <!-- Tabela dos veículos-->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            Custos
            <div class="btn btnAdd" onclick="fnExcelReport('dataTable')" style="margin-left: 2px;"><i class="far fa-file-excel"></i> Exportar Excel</div>
            <a href='adicionar.php'><div class="btn btnAdd"><i class='fas fa-user-plus'></i> Adicionar</div></a>
        </div>
        <div class="card-body">
            <div class="col-md-8" style="float:left; margin-top: 5px;">
                <input class="form-control" type="text" placeholder="Buscar..." style="margin-bottom: 5px" id="buscar" onkeyup="buscar()"/>
            </div>
            <div class="col-md-4" style="float:right; margin-top: 5px;">
                <?php selectEvento();?>
            </div>
            <div class="table-responsive table-hover">
                <table class="table tablesorter table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="display:none;">Id</th>
                            <th>Categoria</th>
                            <th>Valor</th>
                            <th>Descrição</th>
                            <th>Status</th> 
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php
                                $consulta = "SELECT Custos.id, Categorias.categoria, Custos.valor, Custos.descricao, Custos.status FROM Custos JOIN Categorias ON Categorias.id = Custos.categoria WHERE Custos.evento = '$idEvento' ORDER BY Categorias.categoria, Custos.descricao";
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
function addTabela($consulta){
    global $somaCustosTotal, $somaCustosPago, $somaCustosPlanejado;
    $dados = selecionar($consulta);
    $somaCustosTotal = 0;
    $somaCustosPago = 0;
    $somaCustosPlanejado = 0;
    foreach ($dados as $obj) {
        echo "<tr>";
        echo ("<td style='display:none;'>".$obj['id']."</td>"); 
        echo ("<td>".$obj['categoria']."</td>"); 
        echo ("<td>R$".number_format($obj['valor'], 2, ',', '.')."</td>");
        echo ("<td>".$obj['descricao']."</td>");
        if ($obj['status'] == '1'){
            $somaCustosTotal = $somaCustosTotal + $obj['valor'];
            $somaCustosPlanejado = $somaCustosPlanejado + $obj['valor'];
            echo ("<td>Planejado</td>");
            echo ("<td><a href='pagar.php?id=".$obj['id']."' style='margin-left: 15px;' class='iconeTabela green'><i class='fas fa-check'></i> Pagar   </a>");
            echo ("<a href='invalidar.php?id=".$obj['id']."' class='iconeTabela red'><i class='fas fa-user-times'></i></a></td>");
        }else if($obj['status'] == '2'){
            $somaCustosTotal = $somaCustosTotal + $obj['valor'];
            $somaCustosPago = $somaCustosPago + $obj['valor'];
            echo ("<td>Pago</td>");
            echo ("<td><a href='invalidar.php?id=".$obj['id']."' class='iconeTabela red'><i class='fas fa-user-times'></i> Cancelar</a></td>");
        }else if($obj['status'] == '3'){
            echo ("<td>Cancelado</td>");
            echo ("<td><a href='reativar.php?id=".$obj['id']."' style='margin-left: 15px;'>Reativar</a>");
        }
        echo "</tr>";
    }
}
include('../includes/footer.php');
?>
