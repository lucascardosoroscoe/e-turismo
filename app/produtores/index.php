<?php
include('../includes/verificarAcesso.php');
verificarAcesso(1);
include('../includes/header.php');


?>
<div class="container-fluid">
    <!-- Tabela dos veículos-->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            PRODUTORES
            <div class="btn btnAdd" onclick="fnExcelReport('dataTable')" style="margin-left: 2px;"><i class="far fa-file-excel"></i> Exportar Excel</div>
            <a href='adicionar.php'><div class="btn btnAdd"><i class='fas fa-user-plus'></i> Adicionar</div></a>
        </div>
        <div class="card-body">
            <?php msgAutomatica(); ?>
            <div class="row">
                <div class="col-md-8" style="float:left; margin-top: 5px;">
                    <input class="form-control" type="text" placeholder="Buscar..." style="margin-bottom: 5px" id="buscar" onkeyup="buscar()"/>
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
                            <th>Cidade</th>
                            <th>Validade</th>
                            <th>Whatsapp</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php
                            $consulta = "SELECT * FROM Produtor WHERE validade = 'VALIDO'";
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
    global $tipoUsuario, $msg;
    $usuarios = selecionar($consulta);
    foreach ($usuarios as $obj) {
        echo "<tr>";
        echo ("<td style='display:none;'>".$obj['id']."</td>"); 
        echo ("<td>".$obj['usuario']."</td>"); 
        echo ("<td>".$obj['nome']." - ".$obj['CPF']."</td>"); 
        echo ("<td>".$obj['telefone']."</td>");
        echo ("<td>".$obj['endereco'].", ".$obj['numero'].", ".$obj['cidade'].", ".$obj['estado']."</td>");
        $validade = $obj['validade'];
        echo ("<td>".$obj['validade']."</td>");
        $nomeCompleto = explode(' ',trim($obj['nome']));
        $primeiroNome = $nomeCompleto[0];
        $mensagem = "Oi ".$primeiroNome.", tudo bem? " . $msg;
        $mensagem = urlencode($mensagem);
        // $
        $telefone = $obj['telefone'];
        $telefone = str_replace(" ", "", $telefone);
        $telefone = str_replace("(", "", $telefone);
        $telefone = str_replace(")", "", $telefone);
        $telefone = str_replace("-", "", $telefone);
        $telefone = str_replace("+55", "", $telefone);
        $prim = substr($telefone,0,1);
        if($prim == 0){
            $telefone = substr($telefone,1,11);
        }
        echo ("<td><a href='https://api.whatsapp.com/send?phone=55".$telefone."&text=".$mensagem."'>Contatar</a></td>");
        if($validade == "VALIDO"){
            echo ("<td style='display: flex;'>
            <a href='editar.php?id=".$obj['id']."' class='iconeTabela'><i class='fas fa-user-edit'></i></a>
            <a href='invalidar.php?id=".$obj['id']."' target='_blank'  class='iconeTabela red'><i class='fas fa-user-times'></i></a>");  
            if($tipoUsuario == 1){
                echo ("<a href='acessar.php?id=".$obj['id']."&nome=".$obj['nome']."&email=".$obj['usuario']."' class='iconeTabela'>Acessar Como</a>");
            } 
            echo("</td>");  
        }else{
            echo ("<td><a href='reativar.php?id=".$obj['id']."' style='margin-left: 15px;'>Reativar</a></td>");
        }
        echo "</tr>";
    }
}
include('../includes/footer.php');
?>
