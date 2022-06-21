<?php
include('../includes/verificarAcesso.php');
verificarAcesso(3);
include('../includes/header.php');
$msg = $_GET['msg'];
if($tipoUsuario == 2){
    $consulta = "SELECT * FROM `Produtor` WHERE `id` = '$idUsuario'";
}else if($tipoUsuario == 3){
    $consulta = "SELECT * FROM `Vendedor` WHERE `id` = '$idUsuario'";
}
$dados = selecionar($consulta);
if($dados[0]['id'] != ""){
    $id = $dados[0]['id'];
    $nome = $dados[0]['nome'];
    $telefone = $dados[0]['telefone'];
    $email = $dados[0]['email'];
    $validade = $dados[0]['validade'];
}
?>      
    <div style='background-image: url("../img/fundoLogin.jpg"); background-size: cover;height: 100%;'>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Editar Meu Usuário</h3></div>
                        <div class="card-body">
                            <form action="edit.php" id="edit_evento" method="POST">
                                <?
                                echo $msg;
                                ?>
                                <input  name="inputId" type="hidden" value="<?php echo $id; ?>" required/>
                                <div class="form-row">
                                     <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputEmailAddress">E-mail</label>
                                            <input class="form-control py-4" id="inputEmailAddress"  name="inputEmailAddress" type="email" aria-describedby="emailHelp" placeholder="Digite o e-mail" value="<?php echo $email;?>" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputName">Nome</label>
                                            <input class="form-control py-4" id="inputName"  name="inputName" type="text" placeholder="Digite o nome completo" value="<?php echo $nome;?>" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputTelefone">Telefone</label>
                                            <input class="form-control py-4" id="inputTelefone"  name="inputTelefone" type="text" placeholder="Digite o telefone" value="<?php echo $telefone;?>" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" id="resetPasswordCheck" name="resetPasswordCheck" value='1' type="checkbox" />
                                                <label class="custom-control-label" for="resetPasswordCheck">Modificar Senha</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputPassword">Senha</label>
                                            <input class="form-control py-4" id="inputPassword" name="inputPassword" type="password" placeholder="Digite a senha"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputConfirmPassword">Confirmar senha</label>
                                            <input class="form-control py-4" id="inputConfirmPassword" name="inputConfirmPassword" type="password" placeholder="Confirme a senha"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" onclick="enviarForm()" >Editar</button></div>
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