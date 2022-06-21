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
                            <!-- <div class="small mb-3 text-muted">Enter your email address and we will send you a link to reset your password.</div> -->
                            <form action="recuperar.php" id="recuperar" method="POST">
                                <div class="form-group">
                                    <label class="small mb-1" for="inputEmailAddress">E-mail</label>
                                    <input class="form-control py-4" id="inputEmailAddress" name="inputEmailAddress" type="text" placeholder="Digite seu e-mail" />
                                </div>
                                <div class="form-group">
                                    <label class="small mb-1" for="selectTipo">Selecione o Tipo de Usuário*</label>
                                    <select class="form-control" name="selectTipo" id="selectTipo" form="recuperar" required>'
                                        <option value="2">Produtor - Faço eventos</option>
                                        <option value="3">Promoter - Vendo Ingressos</option>
                                        <option value="4">Cliente - Comprei um Ingresso</option>
                                    </select>
                                </div>
                                <button class="btn btn-primary"  onclick="enviarForm()" >Enviar e-mail de recuperação</button>
                            </form>
                        </div>
                        <div class="card-footer text-center">
                            <div class="small"><a href="./produtores/adicionar.php">Ainda não cadastrado? Cadastre-se!</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
<?php
include('../includes/footer.php');
?>