<?php
include('./header.php');
?>
    <div class="container">
        <div class="row shadow-lg rounded-lg justify-content-center mt-5" style="padding-top: 15px;">
            <div class="col-lg-5" style="height: 100%;">
                <img src="../../app/getImagem.php?id=<?php echo $idEvento;?>" alt="Imagem Evento"  loading="lazy" style="width: 100%;">
            </div>
            <div class="col-lg-7">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header">
                    <i class="fas fa-glass-cheers"></i>  Para transferir Seu ingresso da Só Track Boa Campo Grande 2020 para o Vintage 11/03, preencha com o seu e-mail utilizado na compra do ingresso, nome completo e telefone abaixo:
                    </div>
                    <div class="card-body">
                        <h2><?php echo $nomeEvento ?> </h2> 
                        <form action="../troca.php" id="comprar" method="POST">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="small mb-1" for="email">E-mail*</label>
                                        <input class="form-control py-4" id="email"  name="email" type="mail" placeholder="Digite seu E-mail" value="<?php echo $email;?>" required/>
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
                            <button class="form-group mt-4 mb-0 btn btn-primary btn-block" onclick="enviarForm()">Trocar Ingressos</button>
                        </form>
                        <br>
                        <?php
                            $texto  = 'Já fez sua troca de titularidade do STB CG, para o Vintage 11/03???
                            Garanta sua troca: 
                            http://ingressozapp.com/transferencia/stb';
                            $url = urldecode($texto);
                        ?>
                        <div>
                            <div class="fb-like" data-href="http://ingressozapp.com/transferencia/stb" data-width="200" data-layout="button" data-action="recommend" data-size="small" data-share="true"></div>
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
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

        <script src="<?php echo $HTTP_HOST . "/app";?>/js/jquery.mask.min.js"></script>
        <script src="<?php echo $HTTP_HOST . "/app";?>/js/mascara.js"></script>
        <script src="<?php echo $HTTP_HOST . "/app";?>/js/scripts.js"></script>

    </body>
</html>
