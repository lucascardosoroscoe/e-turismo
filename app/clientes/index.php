<?php
include('../includes/verificarAcesso.php');
verificarAcesso(3);
include('../includes/header.php');
if($tipoUsuario == 4){
    $msg = "Faça Login como Administrador ou Gerente";
    echo "<h1>".$msg."</h1>";
}


?>
<div class="container-fluid">
    <!-- Tabela dos veículos-->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            CLIENTES
            <div class="btn btnAdd" onclick="fnExcelReport('dataTable')" style="margin-left: 2px;"><i class="far fa-file-excel"></i> Exportar Excel</div>
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
                            <th>Telefone</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php
                            if($tipoUsuario == 1){
                                $consulta = "SELECT * FROM Cliente";
                                addTabela($consulta);
                            }else if($tipoUsuario == 2){
                                $consulta = "SELECT tc_users.id, tc_users.name, tc_users.email FROM tc_users JOIN tc_user_driver ON tc_user_driver.driverid = tc_users.id WHERE tc_users.type = 4 AND tc_user_driver.userid = '$idUsuario'";
                                addTabela($consulta);
                                $consulta = "SELECT tc_users.id, tc_users.name, tc_users.email FROM tc_users JOIN tc_user_driver ON tc_user_driver.driverid = tc_users.id JOIN tc_user_user ON tc_user_user.manageduserid = tc_user_driver.userid WHERE tc_users.type = 4 AND tc_user_user.userid = '$idUsuario'";
                                addTabela($consulta);
                            }else if($tipoUsuario == 3){
                                $consulta = "SELECT tc_users.id, tc_users.name, tc_users.email FROM tc_users JOIN tc_user_driver ON tc_user_driver.driverid = tc_users.id WHERE tc_users.type = 4 AND tc_user_driver.userid = '$idUsuario'";
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
            echo ("<td>".$obj['telefone']."</td>");
            echo ("<td style='display: flex;'><a href='editar.php?id=".$obj['id']."' class='iconeTabela'><i class='fas fa-user-edit'></i></a></td>");  
        echo "</tr>";
    }
}
include('../includes/footer.php');
?>
