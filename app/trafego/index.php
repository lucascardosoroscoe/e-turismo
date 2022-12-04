<?php
include('../includes/verificarAcesso.php');
verificarAcesso(2);
include('../includes/header.php');
$eventoId = $_GET['id'];
if($eventoId == ""){
    $eventoId = $_GET['evento'];
}
if($eventoId != ""){
    $idEvento = $eventoId;
    $_SESSION["idEvento"] = $idEvento;
}
?>
<div class="container-fluid">
    <!-- Tabela dos veículos-->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            Gestão de Tráfego - Entenda de onde vem seus resultados
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
                            <th style="display: none;">id</th>
                            <th>Link</th>
                            <th>Origem</th>
                            <th>Detalhes</th>
                            <!-- <th>Vendidos</th> -->
                            <th>Vendas</th>
                            <th>Valor</th>
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
            Dica: Para promoters e disparos no Whatsapp utilize um encurtador de links
        </div>
    </div>
</div>

<?php
function addTabela($consulta){
    global $tipoUsuario;
    $usuarios = selecionar($consulta);
    foreach ($usuarios as $obj) {
        echo "<tr>";
            echo ("<td style='display: none;'>".$obj['id']."</td>"); 
            echo ("<td>".$obj['link']."</td>"); 
            echo ("<td>R$".$obj['source'].",00</td>"); 
            echo ("<td>Detalhes: ".$obj['quantidade']."</td>");
            echo ("<td>".$obj['quantidade']."</td>");
            echo ("<td>R$".number_format($obj['quantidade'],2,',','.')."</td>");
            
        echo "</tr>";
    }
}
include('../includes/footer.php');
?>
