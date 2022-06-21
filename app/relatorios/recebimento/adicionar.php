<?php
include('../../includes/verificarAcesso.php');
verificarAcesso(2);
include('../../includes/header.php');
?>     
    <div style='background-image: url("../img/fundoLogin.jpg"); background-size: cover;height: 100%;'>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Adicionar Recebimento</h3></div>
                        <div class="card-body">
                            <form action="create.php" id="create" method="POST" enctype="multipart/form-data">
                                <h3 class="text-center font-weight-light">Evento: <?php echo $nomeEvento; ?></h3>
                                <h3 class="text-center font-weight-light">Promoter: <?php echo $nomeVendedor; ?></h3>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputValor">Valor*</label>
                                            <input class="form-control py-4" id="inputValor"  name="inputValor" type="text" placeholder="Valor Recebido: R$XX,XX" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" onclick="enviarForm()" >Adicionar Recebimento</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
include('../../includes/footer.php');
?>