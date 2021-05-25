<?php
include('../includes/verificarAcesso.php');
verificarAcesso(1);
include('../includes/header.php');
?>     
    <div style='background-image: url("../img/fundoLogin.jpg"); background-size: cover;height: 100%;'>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Adicionar Produtor</h3></div>
                        <div class="card-body">
                            <form action="create.php" id="create_user" method="POST">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputEmailAddress">E-mail</label>
                                            <input class="form-control py-4" id="inputEmailAddress"  name="inputEmailAddress" type="email" aria-describedby="emailHelp" placeholder="Digite o e-mail" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputName">Nome</label>
                                            <input class="form-control py-4" id="inputName"  name="inputName" type="text" placeholder="Digite o nome completo" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputTelefone">Telefone</label>
                                            <input class="form-control py-4" id="inputTelefone"  name="inputTelefone" type="text" placeholder="Digite o telefone" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputCidade">Cidade</label>
                                            <input class="form-control py-4" id="inputCidade"  name="inputCidade" type="text" placeholder="Digite a cidade" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputEstado">Estado</label>
                                            <input class="form-control py-4" id="inputEstado"  name="inputEstado" type="text" placeholder="Digite o estado" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputPassword">Senha</label>
                                            <input class="form-control py-4" id="inputPassword" name="inputPassword" type="password" placeholder="Digite a senha" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputConfirmPassword">Confirmar senha</label>
                                            <input class="form-control py-4" id="inputConfirmPassword" name="inputConfirmPassword" type="password" placeholder="Confirme a senha" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" type="submit" >Adicionar Produtor</button></div>
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