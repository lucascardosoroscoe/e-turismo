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
            Lotes
            <div class="btn btnAdd" onclick="fnExcelReport('dataTable')" style="margin-left: 2px;"><i class="far fa-file-excel"></i> Exportar Excel</div>
            <div class="btn btnAdd" onclick="adicionarlote()"><i class='fas fa-user-plus'></i> Adicionar</div>
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
                            <th>SKU</th>
                            <th>Lote</th>
                            <th>Valor</th>
                            <th>Quantidade</th>
                            <!-- <th>Vendidos</th> -->
                            <th>Validade</th>
                            <th></th>
                            <th>Lote Exclusivo</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php
                            if($idEvento != ""){
                                $consulta = "SELECT * FROM `Lote` WHERE `evento` = '$idEvento' AND validade != 'EXCLUIDO'";
                                addTabela($consulta);
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            Obs.: <b>Tornar Exclusivo</b> significa que apenas o produtor do Evento consegue visualizar e emitir ingressos desse lote, ideal para cortesias e ingressos de lotes com desconto no valor.
        </div>
    </div>
</div>

<?php
function addTabela($consulta){
    
    $usuarios = selecionar($consulta);
    foreach ($usuarios as $obj) {
        echo "<tr>";
            echo ("<td>".$obj['id']."</td>"); 
            echo ("<td>".$obj['nome']."</td>"); 
            echo ("<td>R$".$obj['valor'].",00</td>"); 
            echo ("<td>".$obj['quantidade']."</td>");
            // echo ("<td>".$obj['vendidos']."</td>");
            $validade = $obj['validade'];
            echo ("<td>".$validade."</td>");
            if($validade == "DISPONÍVEL"){
                // <a href='editar.php?id=".$obj['id']."' class='iconeTabela'><i class='fas fa-user-edit'></i></a>
                echo ("<td style='display: flex;'><a href='invalidar.php?id=".$obj['id']."' class='iconeTabela red'><i class='fas fa-user-times'></i></a></td>");  
            }else if($validade == "ESGOTADO"){
                echo ("<td><a href='reativar.php?id=".$obj['id']."' style='margin-left: 15px;'>Reativar</a><a href='excluir.php?id=".$obj['id']."' style='margin-left: 15px;'>Excluir</a></td>");
            }else if($validade == "EM BREVE"){
                echo ("<td><a href='reativar.php?id=".$obj['id']."' style='margin-left: 15px;'>Liberar</a></td>");
            }else if($validade == "EXCLUSIVO"){
                echo ("<td>EXCLUSIVO p/ PRODUTOR</td>");
            }
            if($validade == "EXCLUSIVO"){
                echo ("<td><a href='reativar.php?id=".$obj['id']."' style='margin-left: 15px;'>Reativar</a></td>");
            }else{
                echo ("<td><a href='exclusivo.php?id=".$obj['id']."' style='margin-left: 15px;'>Tornar Exclusivo</a></td>");
            }
        echo "</tr>";
    }
}
include('../includes/footer.php');
?>
