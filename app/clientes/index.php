<?php
include('../includes/verificarAcesso.php');
verificarAcesso(3);
include('../includes/header.php');
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
            <?php msgAutomatica(); ?>
            <div class="row">
                <div class="col-md-8" style="float:left; margin-top: 5px;">
                    <input class="form-control" type="text" placeholder="Buscar..." style="margin-bottom: 5px" id="buscar" onkeyup="buscar()"/>
                </div>
                <div class="col-md-4" style="float:left; margin-top: 5px;">
                    <?php selectEvento(); ?>
                </div>
            </div>
            <div class="table-responsive table-hover">
                <table class="table tablesorter table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="display:none;">Id</th>
                            <th>N</th>
                            <th>Nome</th>
                            <th>Whatsapp</th>
                            <th>Telefone</th>
                            
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php
                            if($tipoUsuario == 1){
                                if($idEvento == ""){
                                }else{
                                    $consulta = "SELECT Cliente.id, Cliente.nome, Cliente.telefone, Cliente.email
                                    FROM Cliente
                                    JOIN Ingresso ON Ingresso.idCliente = Cliente.id
                                    WHERE Ingresso.evento = '$idEvento' GROUP BY Cliente.telefone";
                                    addTabela($consulta);
                                }
                            }else if($tipoUsuario == 2){
                                $consulta = "SELECT Cliente.id, Cliente.nome, Cliente.telefone FROM Cliente 
                                JOIN Ingresso ON Ingresso.idCliente = Cliente.id
                                JOIN Vendedor ON Ingresso.vendedor = Vendedor.id
                                JOIN ProdutorVendedor ON Vendedor.id = ProdutorVendedor.idVendedor
                                WHERE ProdutorVendedor.idProdutor = '$idUsuario'
                                GROUP BY Cliente.telefone";
                                addTabela($consulta);
                                $consulta = "SELECT Cliente.id, Cliente.nome, Cliente.telefone FROM Cliente 
                                JOIN Ingresso ON Ingresso.idCliente = Cliente.id
                                JOIN Evento ON Ingresso.evento = Evento.id 
                                WHERE (Ingresso.vendedor = 1 OR Ingresso.vendedor = 2) AND Evento.produtor = $idUsuario GROUP BY Cliente.telefone
                               ";
                                addTabela($consulta);
                            }else if($tipoUsuario == 3){
                                $consulta = "SELECT Cliente.id, Cliente.nome, Cliente.telefone FROM Cliente 
                                JOIN Ingresso ON Ingresso.idCliente = Cliente.id
                                WHERE Ingresso.vendedor = '$idUsuario'
                                GROUP BY Cliente.telefone";
                                addTabela($consulta);
                            }
                        ?>
                    </tbody>
                </table>
                <div class="form-row">
                    <div class="col-md-12">
                        <div class="form-group">
                                <input class="form-control py-4" id="selectPagina"  name="selectPagina" type="text" placeholder="Ir Para Página" onchange="irParaPagina()" required/>
                            </div>
                        </div>
                    </div>        
            </div>
        </div>
    </div>
</div>

<?php
function addTabela($consulta){
    global $msg;
    $usuarios = selecionar($consulta);
    $n = 0;
    foreach ($usuarios as $obj) {
        $n = $n +1;
        echo "<tr>";
            echo ("<td style='display:none;'>".$obj['id']."</td>");
            echo ("<td>".$n."</td>");
            echo ("<td>".$obj['nome']."</td>"); 
            $nomeCompleto = explode(' ',trim($obj['nome']));
            $primeiroNome = $nomeCompleto[0];
            $mensagem = "Oi ".$primeiroNome.", tudo bem? " . $msg;

            $mensagem = urlencode($mensagem);
            echo ("<td><a target='_blank' href='https://api.whatsapp.com/send?phone=55".$obj['telefone']."&text=".$mensagem."'>Contatar</a></td>");
            echo ("<td>".$obj['telefone']."</td>");
            echo ("<td style='display: flex;'><a href='editar.php?id=".$obj['id']."' class='iconeTabela'><i class='fas fa-user-edit'></i></a></td>");  
        echo "</tr>";
    }
}
include('../includes/footer.php');
?>
