<?php
include('../includes/header.php');
?>     
    <div style='background-image: url("../img/fundoLogin.jpg"); background-size: cover;height: 100%;'>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Inscrever-se como Produtor</h3></div>
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
                                            <select class="form-control" name="inputEstado" id="inputEstado" required>
                                                <option value="" selected>Selecione o estado</option>
                                                <option value="AC">AC</option>
                                                <option value="AL">AL</option>
                                                <option value="AM">AM</option>
                                                <option value="AP">AP</option>
                                                <option value="BA">BA</option>
                                                <option value="CE">CE</option>
                                                <option value="DF">DF</option>
                                                <option value="ES">ES</option>
                                                <option value="GO">GO</option>
                                                <option value="MA">MA</option>
                                                <option value="MG">MG</option>
                                                <option value="MT">MT</option>
                                                <option value="MS">MS</option>
                                                <option value="PA">PA</option>
                                                <option value="PB">PB</option>
                                                <option value="PE">PE</option>
                                                <option value="PI">PI</option>
                                                <option value="PR">PR</option>
                                                <option value="RJ">RJ</option>
                                                <option value="RN">RN</option>
                                                <option value="RO">RO</option>
                                                <option value="RR">RR</option>
                                                <option value="RS">RS</option>
                                                <option value="SC">SC</option>
                                                <option value="SE">SE</option>
                                                <option value="SP">SP</option>
                                                <option value="TO">TO</option>
                                            </select>
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
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputConfirmPassword">Confirmar senha</label>
                                            <input class="form-control py-4" id="inputConfirmPassword" name="inputConfirmPassword" type="password" placeholder="Confirme a senha" required/>
                                        </div>
                                    </div>
                                </div>
                                <input type="checkbox" id="verSenha" name="verSenha" onclick="changeView()"/>
                                <label class="small mb-1" for="verSenha">Visualizar/Ocultar Senha</label>
                                <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" type="submit" >Confirmar Inscrição</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let ativo = false;
        function changeView(){
            if(ativo == false){
                ativo = true;
                document.getElementById('inputPassword').type = "text";
                document.getElementById('inputConfirmPassword').type = "text";
            }else{
                ativo = false;
                document.getElementById('inputPassword').type = "password";
                document.getElementById('inputConfirmPassword').type = "password";
            }
        }
    </script>
<?php
include('../includes/footer.php');
?>