<?php
include('../includes/verificarAcesso.php');
verificarAcesso(2);
include('../includes/header.php');
?>     
    <div style='background-image: url("../img/fundoLogin.jpg"); background-size: cover;height: 100%;'>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Adicionar Co-produtor</h3>
                            Um Co-produtor detém acesso administrativo para adicionar/editar/excluir lotes, ingressos do seu evento como 'Vendedor Oficial' e acessar relatórios de vendas do evento selecionado.
                        </div>
                        <div class="card-body">
                            <form action="createCoprodutor.php" id="create_user" method="POST">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputTelefone">Selecione o Evento:</label>
                                            <?php
                                                selectEvento($idEvento);
                                            ?>
                                        </div> 
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputTelefone">Selecione o Produtor:</label>
                                            <?php
                                                selectProdutor();
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" type="submit" >Adicionar Co-Produtor</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
function selectProdutor(){
    global $tipoUsuario, $idUsuario;
    $consulta = "SELECT * FROM `Produtor` WHERE validade = 'VALIDO' ORDER BY nome";
    $dados = selecionar($consulta);
    echo('<select class="form-control" name="selectProdutor" id="selectProdutor" form="emitir" required>');
        echo('<option value="">Selecione um Produtor</option>');
        foreach ($dados as $produtor) {
            echo('<option value="'. $produtor['id'] .'">'. $produtor['nome'] .' - '. $produtor['cidade'] .' ('. $produtor['estado'] .')</option>');
        }
    echo('</select>');
}
include('../includes/footer.php');
?>