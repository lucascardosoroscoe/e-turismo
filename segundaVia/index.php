<?php
include('../app/includes/headerLogin.php');
?>     
    <div style='background-image: url("../app/assets/img/fundoLogin.jpg"); background-size: cover;height: 100%;'>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header">
                            <h3 class="text-center font-weight-light my-4">Segunda Via</h3>
                            <h6 class="text-center font-weight-light">Preencha com os dados a seguir para pegar a segunda via do seu ingresso</h6>
                        </div>
                        <div class="card-body">
                            <!-- <div class="small mb-3 text-muted">Enter your email address and we will send you a link to reset your password.</div> -->
                            <form action="recuperar.php" id="recuperar" method="POST">
                                <div class="form-group">
                                    <label class="small mb-1" for="inputEmailAddress">E-mail</label>
                                    <input class="form-control py-4" id="inputEmailAddress" name="inputEmailAddress" type="text" placeholder="Digite seu e-mail" />
                                </div>
                                <div class="form-group">
                                    <label class="small mb-1" for="pedido">Número do Pedido</label>
                                    <input class="form-control py-4" id="pedido" name="pedido" type="number" placeholder="Digite o número do Pedido" />
                                </div>
                                <button class="btn btn-primary"  type="submit" >Pegar minha segunda via</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
<?php
include('../app/includes/footer.php');
?>