<?php
include('../includes/header.php');
$msg = $_GET['msg'];
$email = $_GET['email'];
?>      
    <div style='background-image: url("../img/fundoLogin.jpg"); background-size: cover;height: 100%;'>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header">
                            <h3 class="text-center font-weight-light my-4">Inscrever-se como Produtor</h3>
                            <p class="small text-center text-light"><a class="text-light" href='../../suporte'>Login exclusivo para produtores de eventos, se você comprou um ingresso Clique Aqui</a></p>
                            <h6><?php echo $msg;?></h6>
                        </div>
                        <div class="card-body">
                            <form action="create.php" id="create_user" method="POST">
                                <div class="row-produtor">
                                    <label class="small mb-1" for="inputEmailAddress">Selecione a opção que melhor te descreve:*</label><br>

                                    <input type="radio" id="produtor" name="eprodutor" value="1" required>
                                    <label for="produtor">Sou produtor (Faço eventos)</label><br>
                                    <input type="radio" id="promoter" name="eprodutor" value="" onclick="selectPromoter()">
                                    <label for="promoter">Sou promoter (Divulgo eventos)</label><br>
                                    <input type="radio" id="cliente" name="eprodutor" value="" onclick="selectCliente()">
                                    <label for="cliente">Sou cliente (comprei um ingresso)</label>

                                </div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputEmailAddress">E-mail*</label>
                                            <input class="form-control py-4" id="inputEmailAddress"  name="inputEmailAddress" type="email" aria-describedby="emailHelp" placeholder="Digite o e-mail" value="<?php echo $email;?>" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputName">Nome/Razão Social*</label>
                                            <input class="form-control py-4" id="inputName"  name="inputName" type="text" placeholder="Digite o nome/razão social" required/>
                                        </div>
                                    </div> 
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputCPF">CPF/CNPJ*</label>
                                            <input class="form-control py-4" id="inputCPF"  name="inputCPF" type="text" placeholder="Digite o CPF/CNPJ" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputTelefone">Telefone*</label>
                                            <input class="form-control py-4" id="inputTelefone"  name="inputTelefone" type="text" placeholder="Digite o telefone" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputCEP">CEP*</label>
                                            <input class="form-control py-4" id="inputCEP" onchange="pesquisacep()" name="inputCEP" type="text" placeholder="Digite o CEP" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputEndereco">Endereço*</label>
                                            <input class="form-control py-4" id="inputEndereco"  name="inputEndereco" type="text" placeholder="Digite o endereço" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputNumero">Número*</label>
                                            <input class="form-control py-4" id="inputNumero"  name="inputNumero" type="text" placeholder="Digite o número" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputBairro">Bairro*</label>
                                            <input class="form-control py-4" id="inputBairro"  name="inputBairro" type="text" placeholder="Digite o bairro" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputCidade">Cidade*</label>
                                            <input class="form-control py-4" id="inputCidade"  name="inputCidade" type="text" placeholder="Digite a cidade" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputEstado">Estado*</label>
                                            <select class="form-control" name="inputEstado" id="inputEstado" required>
                                                <option value="" selected>Selecione</option>
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
                                            <label class="small mb-1" for="inputPassword">Senha*</label>
                                            <input class="form-control py-4" id="inputPassword" name="inputPassword" type="password" placeholder="Digite a senha" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputConfirmPassword">Confirmar senha*</label>
                                            <input class="form-control py-4" id="inputConfirmPassword" name="inputConfirmPassword" type="password" placeholder="Confirme a senha" required/>
                                        </div>
                                    </div>
                                </div>
                                <input type="checkbox" id="verSenha" name="verSenha" onclick="changeView()"/>
                                <label class="small mb-1" for="verSenha">Visualizar/Ocultar Senha</label>
                                <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" onclick="enviarForm()" >Confirmar Inscrição</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let ativo = false;

        function selectPromoter(){
            if(confirm("Para fazer seu cadastro como promoter solicite que o dono do evento que faça sua inscrição. Clique OK para ser direcionado ao nosso suporte.")){
                location.href = 'https://ingressozapp.com/suporte/';
            };
            document.getElementById('promoter').checked = false;
        }

        function selectCliente(){
            if(confirm("Como cliente você não precisa de login e senha para acessar seus ingressos. O ingresso chega no e-mail. Caso não receba entre em contato com o número (67)99348-1631 ou clique ok e siga as instruções do guia para emissão de segunda via do seu ingresso")){
                location.href = 'https://ingressozapp.com/nao-recebi-ingresso/';
            };
            document.getElementById('cliente').checked = false;
        }

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

        function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('inputEndereco').value=("");
            document.getElementById('inputBairro').value=("");
            document.getElementById('inputCidade').value=("");
            document.getElementById('inputEstado').value=("");
        }

        function meu_callback(conteudo) {
            if (!("erro" in conteudo)) {
                //Atualiza os campos com os valores.
                document.getElementById('inputEndereco').value=(conteudo.logradouro);
                document.getElementById('inputBairro').value=(conteudo.bairro);
                document.getElementById('inputCidade').value=(conteudo.localidade);
                document.getElementById('inputEstado').value=(conteudo.uf);
            } //end if.
            else {
                //CEP não Encontrado.
                limpa_formulário_cep();
                alert("CEP não encontrado.");
            }
        }
            
        function pesquisacep() {
            var valor = document.getElementById('inputCEP').value;
            //Nova variável "cep" somente com dígitos.
            var cep = valor.replace(/\D/g, '');
            //Verifica se campo cep possui valor informado.
            if (cep != "") {

                //Expressão regular para validar o CEP.
                var validacep = /^[0-9]{8}$/;

                //Valida o formato do CEP.
                if(validacep.test(cep)) {

                    //Preenche os campos com "..." enquanto consulta webservice.
                    document.getElementById('inputEndereco').value=("");
                    document.getElementById('inputBairro').value=("");
                    document.getElementById('inputCidade').value=("");
                    document.getElementById('inputEstado').value=("");

                    //Cria um elemento javascript.
                    var script = document.createElement('script');

                    //Sincroniza com o callback.
                    script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

                    //Insere script no documento e carrega o conteúdo.
                    document.body.appendChild(script);

                } //end if.
                else {
                    //cep é inválido.
                    limpa_formulário_cep();
                    alert("Formato de CEP inválido.");
                }
            } //end if.
            else {
                //cep sem valor, limpa formulário.
                limpa_formulário_cep();
            }
        };
    </script>
<?php
include('../includes/footer.php');
?>