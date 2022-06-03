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
            VENDEDORES
            <div class="btn btnAdd" onclick="fnExcelReport('dataTable')" style="margin-left: 2px;"><i class="far fa-file-excel"></i> Exportar Excel</div>
            <a href='adicionar.php'><div class="btn btnAdd"><i class='fas fa-user-plus'></i> Adicionar</div></a>
        </div>
        <div class="card-body">
            <?php msgAutomatica(); ?>
            <div class="row">
                <div class="col-md-8" style="float:left; margin-top: 5px;">
                    <input class="form-control" type="text" placeholder="Buscar..." style="margin-bottom: 5px" id="buscar" onkeyup="buscar()"/>
                </div>
                <div class="col-md-4" style="float:right; margin-top: 5px;">
                    <?php selectEvento();?>
                </div>
            </div>
            
            <div class="table-responsive table-hover">
                <table class="table tablesorter table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="display:none;">Id</th>
                            <th>Usuário</th>
                            <th>Nome</th>
                            <th>Telefone</th>
                            <th>Validade</th>
                            <th>Link Indicação</th>
                            <th>Whatsapp</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php
                            if($tipoUsuario == 1){
                                $consulta = "SELECT * FROM Vendedor";
                                addTabela($consulta);
                            }else if($tipoUsuario == 2){
                                $consulta = "SELECT Vendedor.id, Vendedor.usuario, Vendedor.nome, Vendedor.telefone, Vendedor.validade
                                FROM Vendedor 
                                JOIN ProdutorVendedor ON Vendedor.id = ProdutorVendedor.idVendedor
                                WHERE ProdutorVendedor.idProdutor = '$idUsuario'";
                                addTabela($consulta);
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <a href="adicionar.php" class="btn btn-primary btn-block mt-3"><i class='fas fa-user-plus'></i> Adicionar Vendedor</a>

            <!-- <h5>Adicionar Vendedor Existente</h5>
            <?php addVendedor();?> -->
        </div>
    </div>
</div>

<?php
function addTabela($consulta){
    global $msg, $idEvento, $nomeEvento, $tipoUsuario, $slug;
    $usuarios = selecionar($consulta);
    
    foreach ($usuarios as $obj) {
        $nomeCompleto = explode(' ',trim($obj['nome']));
        $primeiroNome = $nomeCompleto[0];
        $mensagem = "Oi ". $primeiroNome .", tudo bem? " . $msg;
        $mensagem = urlencode($mensagem);
        echo "<tr>";
        echo ("<td style='display:none;'>".$obj['id']."</td>"); 
        echo ("<td>".$obj['usuario']."</td>"); 
        echo ("<td>".$obj['nome']."</td>"); 
        echo ("<td>".$obj['telefone']."</td>");
        $validade = $obj['validade'];
        echo ("<td>".$obj['validade']."</td>");
        echo ("<td>https://ingressozapp.com/eventos/".$slug."/?wt_coupon=".$obj['usuario']."</td>");
        echo ("<td><a target='_blank' href='https://api.whatsapp.com/send?phone=55".$obj['telefone']."&text=".$mensagem."'>Contatar</a></td>");
        if($validade == "VALIDO"){
            $msg = "Olá ".$obj['nome'].", tudo bem? Segue seu link de promoter para o evento ".$nomeEvento.". 
Com este link você pode indicar para um cliente a venda online e e ter reconhcecida a sua indicação.
http://ingressozapp.com/evento/?evento=".$idEvento."&promoter=".$obj['id']."";
            $msg = urlencode($msg);
            
            echo ("<td style='display: flex;'><a href='editar.php?id=".$obj['id']."' class='iconeTabela'><i class='fas fa-user-edit'></i></a><a href='invalidar.php?id=".$obj['id']."' class='iconeTabela red'><i class='fas fa-user-times'></i></a><a href='https://api.whatsapp.com/send?phone=55".$obj['telefone']."&text=".$msg."' class='iconeTabela'><i class='fas fa-external-link-alt'></i></a>");  
            if($tipoUsuario == 1){
                echo ("<a href='acessar.php?id=".$obj['id']."&nome=".$obj['nome']."&email=".$obj['usuario']."' class='iconeTabela'>Acessar Como</a>");
            } 
            echo ("</td>");  
        }else{
            echo ("<td><a href='reativar.php?id=".$obj['id']."' style='margin-left: 15px;'>Reativar</a></td>");
        }
        echo "</tr>";
    }
}

function addVendedor(){
    global $idUsuario;
    echo'<form action="add.php" id="add" method="POST">';
        echo'<input name="idProdutor" type="hidden" value="'. $idUsuario .'" required/>';
        $consulta = "SELECT * FROM Vendedor WHERE validade = 'VALIDO' ORDER BY nome ";
        echo'<select class="form-control" id="vendedor" form="add" name="vendedor" onchange="selecionarVendedor()">';
        echo'<option value="">Selecione o Vendedor</option>';
        $vendedores = selecionar($consulta);
        foreach ($vendedores as $vendedor) {
            $id = $vendedor['id'];
            $email = $vendedor['email'];
            $nome = $vendedor['nome'];
            echo ('<option value="'.$id.'">'.$nome.' ('.$email.')</option>');
        }   
        echo'</select>';
        echo'<div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" type="submit" >Adicionar Vendedor</button></div>';
    echo'</form>';
}

include('../includes/footer.php');
?>
