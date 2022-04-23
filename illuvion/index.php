<?php
include('./header.php');
?>
    <div class="container">
        <div class="row shadow-lg rounded-lg justify-content-center mt-5" style="padding-top: 15px;">
            <div class="col-lg-7" style="height: 100%;">
                <img src="../app/getImagem.php?id=<?php echo $idEvento;?>" alt="Imagem Evento"  loading="lazy" style="width: 100%;">
            </div>
            <div class="col-lg-5">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header">
                    <i class="fas fa-glass-cheers"></i>  Illuvion - Lote Especial (cortesia) -> Gerar ingresso
                    </div>
                    <div class="card-body">
                        <form action="./gerar.php" id="gerar" method="POST">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="small mb-1" for="senderEmail">E-mail*</label>
                                        <input class="form-control py-4" id="senderEmail"  name="senderEmail" type="mail" placeholder="Digite seu E-mail" value="<?php echo $email;?>" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="small mb-1" for="senderName">Nome Completo*</label>
                                        <input class="form-control py-4" id="senderName"  name="senderName" type="text" placeholder="Digite seu nome" value="<?php echo $nome;?>" required/>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputTelefone">Telefone*</label>
                                        <input class="form-control py-4" id="inputTelefone"  name="inputTelefone" type="text" placeholder="Digite seu telefone (DDD obrigatório)" value="<?php echo $telefone;?>" required/>
                                    </div>
                                </div>
                                
                            </div>
                            <button class="form-group mt-4 mb-0 btn btn-primary btn-block" type="submit" >Ganhar Ingressos</button>
                        </form>
                        <br>
                        <?php
                            $texto  = 'Eu já garanti meu ingresso, bora???
                            Garanta o seu também: 
                            http://ingressozapp.com/evento/?evento='.$idEvento.'&promoter='.$promoter;
                            $url = urldecode($texto);
                        ?>
                        <div>
                            <div class="fb-like" data-href="http://ingressozapp.com/evento/?evento=<?php echo $idEvento?>&promoter=<?php echo $promoter?>" data-width="200" data-layout="button" data-action="recommend" data-size="small" data-share="true"></div>
                        </div>
                        <br><a href="https://api.whatsapp.com/send?text=<?php echo $url;?>" target="_blank" style="float: right;"><h6><i class="fab fa-whatsapp"></i> Enviar no Whatsapp</h6></a>
                    </div>
                </div>
                
            </div>
        </div>
        <br><br>
    </div>

</main>
                <footer class="py-4 bg-light">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <!-- jQuery e Tablesorter -->
        <script>
            function checkForm() {
                // Fetching values from all input fields and storing them in variables.
                var inputTelefone = document.getElementById("inputTelefone").value;
                var senderName = document.getElementById("senderName").value;
                var senderEmail = document.getElementById("senderEmail").value;
                var inputQuantidade = document.getElementById("inputQuantidade").value;
                var selectLote = document.getElementById("selectLote").value;
                var split = senderName.split(' ');
                if(inputTelefone.length == 15){
                    if(split.length > 1){
                        if(senderEmail != "" && inputQuantidade !="" && selectLote != ""){
                            document.getElementById("comprar").submit();
                        }else{
                            $msg = 'Preencha todos os dados';
                            alert($msg);
                        }
                    }else{
                        $msg = 'Preencha com o seu nome completo';
                        alert($msg);
                    }
                }else{
                    $msg = 'Telefone inválido, complete o telefone com o DDD e os 9 dígitos principais';
                    alert($msg);
                }
            }
            function aumentar(){
                var quantidade = parseInt(document.getElementById('inputQuantidade').value);
                if(quantidade>= 5){
                    alert("O máximo de ingressos permitidos por compra é de 5 ingressos");
                }else{
                    document.getElementById('inputQuantidade').value = quantidade + 1;
                }
            }
            function diminuir(){
                valor = parseInt(document.getElementById('inputQuantidade').value) - 1;
                if(valor <= 0){
                    document.getElementById('inputQuantidade').value = 1;
                }else{
                    document.getElementById('inputQuantidade').value = valor;
                }
                
            }
            function setValor(){
                var quantidade = parseInt(document.getElementById('inputQuantidade').value);
                if(quantidade>= 5){
                    alert("O máximo de ingressos permitidos por compra é de 5 ingressos");
                    document.getElementById('inputQuantidade').value = 5
                }else if(valor <= 1){
                    document.getElementById('inputQuantidade').value = 1;
                }
            }
        </script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

        <script src="<?php echo $HTTP_HOST . "/app";?>/js/jquery.mask.min.js"></script>
        <script src="<?php echo $HTTP_HOST . "/app";?>/js/mascara.js"></script>
        <script src="<?php echo $HTTP_HOST . "/app";?>/js/scripts.js"></script>

    </body>
</html>
