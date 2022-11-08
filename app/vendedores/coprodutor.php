<?php
include('../includes/verificarAcesso.php');
verificarAcesso(2);
include('../includes/header.php');


$consulta = "SELECT slug FROM Evento WHERE id = '$idEvento'";
$evento = selecionar($consulta);
    $slug = $evento[0]['slug'];
?>
<div class="container-fluid">
    <!-- Tabela dos veículos-->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            COPRODUTORES
            <div class="btn btnAdd" onclick="fnExcelReport('dataTable')" style="margin-left: 2px;"><i class="far fa-file-excel"></i> Exportar Excel</div>
            <a href='addCoprodutor.php'><div class="btn btnAdd"><i class='fas fa-user-plus'></i> Adicionar</div></a>
        </div>
        <div class="card-body">
            Um Co-produtor detém acesso administrativo para adicionar/editar/excluir lotes, ingressos do seu evento como 'Vendedor Oficial' e acessar relatórios de vendas do evento selecionado.
            <div class="row">
                <div class="col-md-12" style="float:left; margin-top: 5px;">
                    <input class="form-control" type="text" placeholder="Buscar..." style="margin-bottom: 5px" id="buscar" onkeyup="buscar()"/>
                </div>
            </div>
            
            <div class="table-responsive table-hover">
                <table class="table tablesorter table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="display:none;">Id</th>
                            <th>Evento</th>
                            <th>Produtor</th>
                            <th>Dono Evento</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php
                            $consulta = "SELECT Coprodutor.id, Evento.nome as evento, Produtor.nome as produtor, donoEvento.nome as dono FROM `Coprodutor` JOIN Evento ON Evento.id = Coprodutor.idEvento JOIN Produtor ON Produtor.id = Coprodutor.idProdutor JOIN Produtor as donoEvento ON donoEvento.id = Evento.produtor WHERE donoEvento.id = '$idUsuario'";
                            addTabela($consulta);
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
        echo ("<td>".$obj['evento']."</td>"); 
        echo ("<td>".$obj['produtor']."</td>"); 
        echo ("<td>".$obj['dono']."</td>"); 
//         if($validade == "VALIDO"){
//             $msg = "Olá ".$obj['nome'].", tudo bem? Segue seu link de promoter para o evento ".$nomeEvento.". 
// Com este link você pode indicar para um cliente a venda online e e ter reconhcecida a sua indicação.
// https://ingressozapp.com/evento/?evento=".$idEvento."&promoter=".$obj['id']."";
//             $msg = urlencode($msg);
            
//             echo ("<td style='display: flex;'><a href='editar.php?id=".$obj['id']."' class='iconeTabela'><i class='fas fa-user-edit'></i></a><a href='invalidar.php?id=".$obj['id']."' class='iconeTabela red'><i class='fas fa-user-times'></i></a><a href='https://api.whatsapp.com/send?phone=55".$obj['telefone']."&text=".$msg."' class='iconeTabela'><i class='fas fa-external-link-alt'></i></a>");  
//             if($tipoUsuario == 1){
//                 echo ("<a href='acessar.php?id=".$obj['id']."&nome=".$obj['nome']."&email=".$obj['usuario']."' class='iconeTabela'>Acessar Como</a>");
//             } 
//             echo ("</td>");  
//         }else{
//             echo ("<td><a href='reativar.php?id=".$obj['id']."' style='margin-left: 15px;'>Reativar</a></td>");
//         }
        echo "</tr>";
    }
}

include('../includes/footer.php');
?>
