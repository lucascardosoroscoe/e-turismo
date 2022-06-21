<?php
include('../includes/verificarAcesso.php');
verificarAcesso(2);
include('../includes/header.php');
?>     
    <div style='background-image: url("../img/fundoLogin.jpg"); background-size: cover;height: 100%;'>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Adicionar Produto</h3></div>
                        <div class="card-body">
                            <form action="create.php" id="create" method="POST" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="small mb-1" for="nome">Nome do Produto</label>
                                            <input class="form-control py-4" id="nome"  name="nome" type="text" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="small mb-1" for="categoria">Categoria</label>
                                            <input class="form-control py-4" id="categoria"  name="categoria" type="text" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="small mb-1" for="imagem">Imagem do Produto</label>
                                            <input class="form-control py-1" type="file" name="imagem" id="imagem">                                     
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="valor">Valor (R$)</label>
                                            <input class="form-control py-4" id="valor" name="valor" type="text" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="estoque">Quantidade em Estoque</label>
                                            <input class="form-control py-4" id="estoque" name="estoque" type="text" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" onclick="enviarForm()" >Adicionar Produtor</button></div>
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