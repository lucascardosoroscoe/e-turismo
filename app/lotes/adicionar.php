<?php
include('../includes/verificarAcesso.php');
verificarAcesso(2);
include('../includes/header.php');
?>     
    <div style='background-image: url("../img/fundoLogin.jpg"); background-size: cover;height: 100%;'>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Adicionar Lote</h3></div>
                        <div class="card-body">
                            <form action="create.php" id="create_lote" method="POST" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputName">Nome do Lote*</label>
                                            <input class="form-control py-4" id="inputName"  name="inputName" type="text" placeholder="Digite o Nome" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputValor">Preço de Venda*</label>
                                            <input class="form-control py-4" id="inputValor"  name="inputValor" type="number" placeholder="Digite o Preço (R$)" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputQuantidade">Quantidade de Ingressos Disponíveis*</label>
                                            <input class="form-control py-4" id="inputQuantidade"  name="inputQuantidade" type="text" placeholder="Digite o Nome" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" type="submit" >Adicionar Lote</button></div>
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