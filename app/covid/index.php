<?php
include('../includes/verificarAcesso.php');
verificarAcesso(3);
include('../includes/header.php');
?>
<div style='background-image: url("./img/fundoLogin.jpg"); background-size: cover;height: 100%;'>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <i class="fas fa-user"></i>
                        Formulário para emissão de alertas e contenção de surtos de COVID 19
                    </div>
                    <div class="card-body">
                        <form action="emitir.php" id="emitir" method="POST">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputNome">Nome Completo*</label>
                                        <input class="form-control py-4" id="inputNome"  name="inputNome" type="text" placeholder="Digite o nome" required/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputTelefone">Telefone (mesmo cadastrado no ingresso)*</label>
                                        <input class="form-control py-4" id="inputTelefone"  name="inputTelefone" type="text" placeholder="Digite o telefone (DDD obrigatório)" required/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputCPF">CPF*</label>
                                        <input class="form-control py-4" id="inputCPF"  name="inputCPF" type="text" placeholder="Digite o CPF" required/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="dataNascimento">Data de Nascimento*</label>
                                        <input class="form-control py-4" id="dataNascimento"  name="dataNascimento" type="date"  required/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="dataSintomas">Data Primeiros Sintomas*</label>
                                        <input class="form-control py-4" id="dataSintomas"  name="dataSintomas" type="date"  required/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="small mb-1" for="selectVacina">Estágio de Imunização*</label>
                                        <select class="form-control" name="selectVacina" id="selectVacina" form="emitir" required>
                                            <option value="">Clique e Selecione</option>
                                            <option value="2">Imunização Completa (Vacina de dose única ou Duas doses)</option>
                                            <option value="1">Imunização Parcial (Primeira dose de vacinas de dose dupla)</option>
                                            <option value="0">Não vacinado (Nenhuma dose de vacina para COVID 19)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="checkbox" id="sintomas" name="sintomas" value="true">
                                        <label for="sintomas">Apresento <a href="https://www.gov.br/saude/pt-br/coronavirus/sintomas" target="_blank">Sintomas característicos da COVID 19</a></label><br>
                                        <input type="checkbox" id="comorbidades" name="comorbidades" value="true">
                                        <label for="comorbidades">Possuo comorbidade e/ou me encaixo em <a href="https://aps.bvs.br/aps/quais-sao-os-grupos-de-risco-para-agravamento-da-covid-19/" target="_blank">grupos de risco para COVID 19</a></label><br>
                                        <input type="checkbox" id="teste" name="teste" value="true">
                                        <label for="teste">Testei positivo para COVID 19.</label><br>
                                        <input type="checkbox" id="termos" name="termos" value="true" required>
                                        <label for="termos">Concordo Com os <a href="#" target="_blank">Termos e Condições</a> e <a href="#" target="_blank">Política de Privacidade</a> da plataforma</a></label><br>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" onclick="enviarForm()" >Enviar Formulário</button></div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('../includes/footer.php');
?>