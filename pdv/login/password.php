<?php
include('../includes/headerLogin.php');
?>     
    <div style='background-image: url("../assets/img/fundoLogin.jpg"); background-size: cover;height: 100%;'>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Recuperação de senha</h3></div>
                        <div class="card-body">
                            <div class="small mb-3 text-muted">Entre em contato com o número abaixo para recuperar sua senha:</div>
                            <h2>(67) 99965-4445</h2>
                            <!-- <div class="small mb-3 text-muted">Enter your email address and we will send you a link to reset your password.</div> -->
                            <form>
                                <!-- <div class="form-group">
                                    <label class="small mb-1" for="inputEmailAddress">Email</label>
                                    <input class="form-control py-4" id="inputEmailAddress" type="email" aria-describedby="emailHelp" placeholder="Enter email address" />
                                </div> -->
                                <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                    <a class="small" href="index.php">Voltar para o Login</a>
                                    <!-- <a class="btn btn-primary" href="login.html">Reset Password</a> -->
                                </div>
                            </form>
                        </div>
                        <div class="card-footer text-center">
                            <div class="small"><a href="register.php">Ainda não cadastrado? Cadastre-se!</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
include('../includes/footer.php');
?>