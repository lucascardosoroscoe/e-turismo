<?php
include('../app/includes/verificarAcesso.php');
verificarAcesso(1);
include('../app/includes/header.php');
$idEvento = $_GET['evento'];
try {
    
    $nome = $_GET['nome'];
    $telefone = $_GET['telefone'];
    $email = $_GET['email'];
    $evento = $_GET['evento'];
} catch (\Throwable $th) {
    throw $th;
}
?>
<div style='background-image: url("../app/img/fundoLogin.jpg"); background-size: cover;height: 100%;'>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <i class="fas fa-user"></i>
                        <?php 
                        if($tipoUsuario != ""){echo $usuario;}
                        ?> , seja bem vindo ao IngressoZapp!
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <h3>Imprimir Ingresso</h3>
                                <h5>
                                    <?php
                                        try {
                                            echo $_GET['msg'];
                                        } catch (\Throwable $th) {
                                            //throw $th;
                                        }
                                    ?>
                                </h5>
                            </div>
                        </div>
                        <form action="emitir.php" id="emitir" method="POST" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="small mb-1" for="selectEvento">Selecione o Evento*</label>
                                        <?php selectEvento(); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="small mb-1" for="selectLote">Selecione o Lote*</label>
                                        <?php selectLote(); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="small mb-1" for="inputQuantidade">Quantidade de Ingressos*</label>
                                    <div style="display:flex;">
                                        <div style="font-size: x-large;" onclick="diminuir()"><i class="far fa-window-minimize"></i></div>
                                        <div style="width: 80px; margin-left: 3px; margin-right: 3px;">
                                            <input class="form-control py-4" id="inputQuantidade" style="border: none; border-bottom: solid;text-align: center;" name="inputQuantidade" type="Number" value="1" style="margin-left: 3px;margin-right: 3px;width: 74px;" required/>
                                        </div>
                                        <div style="font-size: x-large;padding-top: 8px;" onclick="aumentar()"><i class="fas fa-plus"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputImagem">Logo (horizontal): *</label>
                                        <input style="padding: 4px;" class="form-control" name="inputImagem" type="file" id="inputImagem"  accept="image/jpeg, image/png, image/webp"required> 
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <h6>Opções:</h6><br>
                                    <div class="form-group">
                                        <input style="padding: 4px;" name="inputPreco" type="checkbox" id="inputPreco" checked> 
                                        <label class="mb-1" for="inputPreco">Mostrar Preço no Ingresso</label>
                                    </div>
                                    <div class="form-group">
                                        <input style="padding: 4px;" name="inputLote" type="checkbox" id="inputLote" checked> 
                                        <label class="mb-1" for="inputLote">Mostrar Lote no Ingresso</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-4 mb-0 btn btn-primary btn-block" onclick="checkForm()">Emitir Ingresso</div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function checkForm() {
        if (window.confirm("Confirmar Emissão de Ingresso?")) {
            document.getElementById("emitir").submit();
        }
    }
    function copiar() {
    /* Get the text field */
    var linkPromoter = document.getElementById("linkPromoter").value;
    var evento = document.getElementById("selectEvento").value;

    /* Alert the copied text */
    if(evento == ""){
        alert("Selecione o Evento");
    }else{
        /* Copy the text inside the text field */
        navigator.clipboard.writeText(linkPromoter);
        alert("Link de Promoter copiado com Sucesso!!!");
    }
    
    }
    function aumentar(){
        document.getElementById('inputQuantidade').value = parseInt(document.getElementById('inputQuantidade').value) + 1;
    }
    function diminuir(){
         valor = parseInt(document.getElementById('inputQuantidade').value) - 1;
         if(valor <= 0){
            document.getElementById('inputQuantidade').value = 1;
         }else{
            document.getElementById('inputQuantidade').value = valor;
         }
         
    }
</script>
<?php
include('../app/includes/footer.php');
?>