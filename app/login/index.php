<?php
    include('../includes/headerLogin.php');
    $msg = $_GET['msg'];
?>     
    <div style='background-image: url("../img/fundoLogin.jpeg"); background-size: cover;height: 1080px;'>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div style="margin-top: 7em !important;" class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header">
                            <h3 class="text-center font-weight-light my-4">Login</h3>
                            <?php echo $msg;?>
                        </div>
                        <div class="card-body">
                            <form action="login.php" method="POST">
                                <div class="form-group">
                                    <label class="small mb-1" for="inputEmailAddress">E-mail</label>
                                    <input class="form-control py-4" id="inputEmailAddress" name="inputEmailAddress" type="email" placeholder="Digite seu e-mail" />
                                </div>
                                <div class="form-group">
                                    <label class="small mb-1" for="inputPassword">Senha</label>
                                    <input class="form-control py-4" id="inputPassword" name="inputPassword" type="password" placeholder="Digite sua senha" />
                                </div>
                                <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                    <a class="small" href="password.php">Esqueceu sua senha?</a>
                                    <button class="btn btn-primary"  type="submit" >Login</button>
                                </div>
                            </form>
                        </div>
                        <!-- <div class="card-footer text-center">
                            <div class="small"><a href="register.php">Ainda não é registrado? Cadastre-se!</a></div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
include('../includes/footer.php');
?>