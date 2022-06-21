<?php
include('../includes/verificarAcesso.php');
verificarAcesso(2);
include('../includes/header.php');
$id = $_GET['id'];
$conculta = "SELECT * FROM `Produto` WHERE `idProduto` = '$id'";
$dados = selecionar($conculta);
?>     
    <div style='background-image: url("../img/fundoLogin.jpg"); background-size: cover;height: 100%;'>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Editar Produto</h3></div>
                        <div class="card-body">
                            <form action="edit.php" id="edit_user" method="POST">
                                <input name="id" type="hidden" value="<?php echo $id; ?>" required/>
                                <input name="idImagem" type="hidden" value="<?php echo $dados[0]['idImagem']; ?>" required/>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="small mb-1" for="nome">Nome do Produto</label>
                                            <input class="form-control py-4" id="nome"  name="nome" type="text" value="<?php echo $dados[0]['nome']; ?>" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="small mb-1" for="categoria">Categoria</label>
                                            <input class="form-control py-4" id="categoria"  name="categoria" type="text" value="<?php echo $dados[0]['categoria']; ?>" required/>
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
                                            <input class="form-control py-4" id="valor" name="valor" type="text" value="<?php echo $dados[0]['valor']; ?>" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="estoque">Quantidade em Estoque</label>
                                            <input class="form-control py-4" id="estoque" name="estoque" type="text" value="<?php echo $dados[0]['estoque']; ?>" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" onclick="enviarForm()" >Editar Produtor</button></div>
                            
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