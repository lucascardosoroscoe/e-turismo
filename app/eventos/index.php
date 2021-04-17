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
            Eventos
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
                            <th>Nome</th>
                            <th>Produtor</th>
                            <th>Data</th>
                            <th>Descrição</th>
                            <th>Validade</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php
                            if($tipoUsuario == 1){
                                $consulta = "SELECT * FROM Evento";
                                addTabela($consulta);
                            }else if($tipoUsuario == 2){
                                $consulta = "SELECT * FROM Evento WHERE produtor = '$idUsuario'";
                                addTabela($consulta);
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
function addTabela($consulta){
    
    $usuarios = selecionar($consulta);
    foreach ($usuarios as $obj) {
        echo "<tr>";
        echo ("<td style='display:none;'>".$obj['id']."</td>"); 
        echo ("<td>".$obj['nome']."</td>"); 
        echo ("<td>".$obj['produtor']."</td>"); 
        echo ("<td>".$obj['data']."</td>");
        echo ("<td>".$obj['descricao']."</td>");
        $validade = $obj['validade'];
        echo ("<td>".$obj['validade']."</td>");
        if($validade == "VALIDO"){
            echo ("<td style='display: flex;'><a href='editar.php?id=".$obj['id']."' class='iconeTabela'><i class='fas fa-user-edit'></i></a><a href='invalidar.php?id=".$obj['id']."' class='iconeTabela red'><i class='fas fa-user-times'></i></a><a href='detalhar.php?id=".$obj['id']."' class='iconeTabela'><i class='fas fa-eye'></i></a></td>");  
        }else{
            echo ("<td><a href='reativar.php?id=".$obj['id']."' style='margin-left: 15px;'>Reativar</a></td>");
        }
        echo "</tr>";
    }
}
include('../includes/footer.php');
?>
