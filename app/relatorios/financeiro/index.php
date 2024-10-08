<?php
include('../../includes/verificarAcesso.php');
include('../../includes/header.php');
$msg = $_GET['msg'];
?>     
    <div style='background-image: url("../img/fundoLogin.jpg"); background-size: cover;height: 100%;'>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header">
                            <h3 class="text-center font-weight-light my-4">Adicionar Evento</h3>
                            <h5 class="text-center font-weight-light my-4 text-warning"><?php echo $msg;?></h5>
                        </div>
                        <div class="card-body">
                            <form action="listar.php" id="listar" method="POST" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputDataInicial">Data Inicial (Data do evento)*</label>
                                            <input class="form-control py-4" id="inputDataInicial"  name="inputDataInicial" type="date" required/>
                                        </div>
                                    </div> 
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputDataFinal">Data Final (Data do evento)*</label>
                                            <input class="form-control py-4" id="inputDataFinal"  name="inputDataFinal" type="date" required/>
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputSenha">Senha Autorização*</label>
                                            <input class="form-control py-4" id="inputSenha"  name="inputSenha" type="password" required/>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php
                                    //Se for tipo 1 -> Selecionar Produtor
                                ?>
                                <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" id="addEvento" onclick="enviarForm()">Lista SKUs e Eventos</button></div>
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