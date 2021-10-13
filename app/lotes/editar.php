<?php
include('../includes/verificarAcesso.php');
verificarAcesso(2);
include('../includes/header.php');
$id = $_GET['id'];
$consulta = "SELECT * FROM `Lote` WHERE `id` = '$id'";
$dados = selecionar($consulta);
?>      
    <div style='background-image: url("../img/fundoLogin.jpg"); background-size: cover;height: 100%;'>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Editar Lote</h3></div>
                        <div class="card-body">
                            <form action="edit.php" id="edit_evento" method="POST" enctype="multipart/form-data">
                                <input  name="inputId" type="hidden" value="<?php echo $id; ?>" required/>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputName">Nome do Lote*</label>
                                            <input class="form-control py-4" id="inputName"  name="inputName" type="text" placeholder="Digite o Nome" value="<?php echo $dados[0]['nome'];?>" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputValor">Preço de Venda*</label>
                                            <input class="form-control py-4" id="inputValor"  name="inputValor" type="text" placeholder="Digite o Preço (R$)" value="<?php echo $dados[0]['valor'];?>" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputQuantidade">Quantidade de Ingressos Disponíveis*</label>
                                            <input class="form-control py-4" id="inputQuantidade"  name="inputQuantidade" type="text" placeholder="Digite o Nome" value="<?php echo $dados[0]['quantidade'];?>" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" type="submit" >Editar Lote</button></div>
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