<?php
include('./includes/verificarAcesso.php');
verificarAcesso(3);
include('./includes/header.php');
$idEvento = $_GET['evento'];
try {
    $nome = $_GET['nome'];
    $telefone = $_GET['telefone'];
    $email = $_GET['email'];
    $evento = $_GET['evento'];
} catch (\Throwable $th) {
    throw $th;
}
$link = "http://ingressozapp.com/evento/?evento=".$idEvento."&promoter=".$idUsuario;
?>
<div style='background-image: url("./img/fundoLogin.jpg"); background-size: cover;height: 100%;'>
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
                            <div class="col-lg-6">
                                <h3>Emitir Ingresso</h3>
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
                            <div class="col-lg-6">
                                <!-- <input type="hidden" id="linkPromoter" value="<?php echo $link;?>">
                                <h6 style="margin-bottom:10px;" class="btn btn-primary btn-block" onclick="copiar()">Copiar Meu Link de Promoter</h6> -->
                            </div>
                        </div>
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
                                        <label class="small mb-1" for="inputNome">Nome do Cliente*</label>
                                        <input class="form-control py-4" id="inputNome"  name="inputNome" type="text" placeholder="Digite o nome" value="<?php echo $nome;?>" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputEmail">E-mail (opcional)</label>
                                        <input class="form-control py-4" id="inputEmail"  name="inputEmail" type="text" placeholder="Digite o e-mail" value="<?php echo $email;?>" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputTelefone">Telefone do Cliente*</label>
                                        <input class="form-control py-4" id="inputTelefone"  name="inputTelefone" type="text" placeholder="Digite o telefone (DDD obrigatório)" value="<?php echo $telefone;?>" required/>
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
        // Fetching values from all input fields and storing them in variables.
        var inputTelefone = document.getElementById("inputTelefone").value;
        if(inputTelefone.length == 15){
            document.getElementById("emitir").submit();
        }else{
            $msg = 'Telefone inválido, complete o telefone com o DDD e os 9 dígitos principais';
            alert($msg);
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
include('./includes/footer.php');
?>