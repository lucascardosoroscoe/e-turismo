<?php
include('../app/includes/verificarAcesso.php');
include('./header.php');
$idEvento = $_GET['evento'];
$consulta= "SELECT * FROM `Evento` WHERE id = $idEvento";
$dados = selecionar($consulta);
$nomeEvento = $dados[0]['nome'];
$dataEvento = $dados[0]['data'];
$descricaoEvento = $dados[0]['descricao'];
?>
    <div class="container">
        <div class="row shadow-lg rounded-lg justify-content-center mt-5" style="padding-top: 15px;">
            <div class="col-lg-5">
                <div class="" style="margin-top: 0.7rem;">
                    <img src="../app/getImagem.php?id=<?php echo $idEvento;?>" alt="Imagem Evento" srcset="" style="width: 100%;">
                </div>
            </div>
            <div class="col-lg-7" style="padding-right: 0px !important;">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header">
                    <i class="fas fa-glass-cheers"></i>  Comprar Ingressos do evento
                    </div>
                    <div class="card-body">
                        <h2><?php echo $nomeEvento ?> </h2>
                        
                        <form action="../app/pagSeguro/pagamento.php" id="comprar" method="POST">
                            <input id="idEvento"  name="idEvento" type="hidden" value="<?php echo $idEvento;?>" required/>
                            <div class="form-row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="small mb-1" for="selectLote">Selecione o Lote*</label>
                                        <?php selectLote(); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputQuantidade">Quantidade de Ingressos*</label>
                                        <input class="form-control py-4" id="inputQuantidade"  name="inputQuantidade" type="Number" placeholder="Quantidade" value="<?php echo $quantidade;?>" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="small mb-1" for="senderEmail">E-mail*</label>
                                        <input class="form-control py-4" id="senderEmail"  name="senderEmail" type="mail" placeholder="Digite seu E-mail" value="<?php echo $email;?>" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="senderName">Nome Completo*</label>
                                        <input class="form-control py-4" id="senderName"  name="senderName" type="text" placeholder="Digite seu nome" value="<?php echo $nome;?>" required/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputTelefone">Telefone*</label>
                                        <input class="form-control py-4" id="inputTelefone"  name="inputTelefone" type="text" placeholder="Digite seu telefone (DDD obrigatório)" value="<?php echo $telefone;?>" required/>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="form-group mt-4 mb-0 btn btn-primary btn-block" onclick="checkForm()">Comprar Ingressos</div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    function checkForm() {
        // Fetching values from all input fields and storing them in variables.
        var inputTelefone = document.getElementById("inputTelefone").value;
        var senderName = document.getElementById("senderName").value;
        var split = senderName.split(' ');
        if(inputTelefone.length == 15){
            if(split.length > 1){
                document.getElementById("comprar").submit();
            }else{
                $msg = 'Preencha com o seu nome completo';
                alert($msg);
            }
        }else{
            $msg = 'Telefone inválido, complete o telefone com o DDD e os 9 dígitos principais';
            alert($msg);
        }
    }
</script>
<?php
include('../app/includes/footer.php');
?>