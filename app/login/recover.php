<?php
include('../includes/headerLogin.php');
$hash = $_GET['hash'];
$msg = $_GET['msg'];
?>     
    <div style='background-image: url("../assets/img/fundoLogin.jpg"); background-size: cover;height: 100%;'>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Recuperação de senha</h3><br><h6 class="text-center"><?php echo $msg;?></h6></div>
                        <div class="card-body">
                            <!-- <div class="small mb-3 text-muted">Enter your email address and we will send you a link to reset your password.</div> -->
                            <form action="newPass.php" id="newPass" method="POST">
                                <input id="hash" name="hash" type="hidden" value="<?php echo $hash;?>"/>
                                <div class="form-group">
                                    <label class="small mb-1" for="inputSenha">Nova Senha</label>
                                    <input class="form-control py-4" id="inputSenha" name="inputSenha" type="password" placeholder="Digite sua senha" />
                                </div>
                                <div class="form-group">
                                    <label class="small mb-1" for="inputSenha2">Repita sua senha</label>
                                    <input class="form-control py-4" id="inputSenha2" name="inputSenha2" type="password" placeholder="Repita sua senha" />
                                </div>
                                <button class="btn btn-primary"  type="submit" >Alterar Senha</button>
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