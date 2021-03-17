<?php
include('./includes/verificarAcesso.php');
verificarAcesso(3);
include('./includes/header.php');
?>
<div style='background-image: url("./img/fundoLogin.jpeg"); background-size: cover;height: 1080px;'>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <i class="fas fa-user"></i>
                        <?php if($tipoUsuario != ''){echo $usuario;}?> , seja bem vindo ao IngressoZapp!
                    </div>
                    <div class="card-body">
                        <h2>Emitir Ingresso</h2>
                        <form action="emitir.php" id="emitir" method="POST">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="small mb-1" for="selectEvento">Selecione o Evento*</label>
                                        <?php selectEvento(); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="small mb-1" for="selectLote">Selecione o Lote*</label>
                                        <?php selectLote(); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputNome">Nome do Cliente*</label>
                                        <input class="form-control py-4" id="inputNome"  name="inputNome" type="text" placeholder="Digite o nome" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputTelefone">Telefone do Cliente*</label>
                                        <input class="form-control py-4" id="inputTelefone"  name="inputTelefone" type="text" placeholder="Digite o telefone (DDD obrigatório)" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" type="submit" >Emitir Ingresso</button></div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('./includes/footer.php');
?>