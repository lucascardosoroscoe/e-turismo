<?php
include('../includes/verificarAcesso.php');
verificarAcesso(1);
include('../includes/header.php');
$id = $_GET['id'];
$conculta = "SELECT * FROM `Vendedor` WHERE `id` = '$id'";
$dados = selecionar($conculta);
?>      
    <div style='background-image: url("../img/fundoLogin.jpeg"); background-size: cover;height: 1080px;'>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Adicionar Vendedor</h3></div>
                        <div class="card-body">
                            <form action="edit.php" id="edit_user" method="POST">
                                <input  name="inputId" type="hidden" value="<?php echo $id; ?>" required/>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputEmailAddress">E-mail</label>
                                            <input class="form-control py-4" id="inputEmailAddress"  name="inputEmailAddress" type="email" aria-describedby="emailHelp" placeholder="Digite o e-mail" value="<?php echo $dados[0]['email']; ?>" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputName">Nome</label>
                                            <input class="form-control py-4" id="inputName"  name="inputName" type="text" placeholder="Digite o nome completo" value="<?php echo $dados[0]['nome']; ?>" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputTelefone">Telefone</label>
                                            <input class="form-control py-4" id="inputTelefone"  name="inputTelefone" type="text" placeholder="Digite o telefone" value="<?php echo $dados[0]['telefone']; ?>" required/>
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
                                <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" type="submit" >Editar Produtor</button></div>
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