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
            PRODUTOS
            <div class="btn btnAdd" onclick="fnExcelReport('dataTable')" style="margin-left: 2px;"><i class="far fa-file-excel"></i> Exportar Excel</div>
            <a href='adicionar.php'><div class="btn btnAdd"><i class='fas fa-user-plus'></i> Adicionar</div></a>
        </div>
        <div class="card-body">
            <div class="col-md-8" style="float:left; margin-top: 5px;">
                <input class="form-control" type="text" placeholder="Buscar..." style="margin-bottom: 5px" id="buscar" onkeyup="buscar()"/>
            </div>
            <div class="table-responsive table-hover">
                <table class="table tablesorter table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="display:none;">Id</th>
                            <th>Categoria</th>
                            <th>Nome</th>
                            <th>Valor</th>
                            <th>Estoque</th>
                            <th>Validade</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php
                            $consulta = "SELECT * FROM `Produto` WHERE `produtor` = '$idUsuario' ORDER BY categoria, nome";
                            addTabela($consulta);
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- <?php echo $consulta;?> -->
        </div>
    </div>
</div>

<?php
function addTabela($consulta){
    
    $usuarios = selecionar($consulta);
    foreach ($usuarios as $obj) {
        echo "<tr>";
        echo ("<td style='display:none;'>".$obj['id']."</td>"); 
        echo ("<td>".$obj['categoria']."</td>"); 
        echo ("<td>".$obj['nome']."</td>"); 
        echo ("<td>R$".number_format(floatval($obj['valor']),2,",",".")."</td>");
        echo ("<td>".$obj['estoque']."</td>");
        $validade = $obj['validade'];
        echo ("<td>".$validade."</td>");
        if($validade == "VALIDO"){
            // <a href='editar.php?id=".$obj['id']."' class='iconeTabela'><i class='fas fa-user-edit'></i></a>
            echo ("<td style='display: flex;'><a href='invalidar.php?id=".$obj['id']."' class='iconeTabela red'><i class='fas fa-user-times'></i></a></td>");  
        }else{
            echo ("<td><a href='reativar.php?id=".$obj['id']."' style='margin-left: 15px;'>Reativar</a></td>");
        }
        echo "</tr>";
    }
}
include('../includes/footer.php');
?>