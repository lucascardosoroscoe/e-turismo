<?php
include('../stb/header.php');
?>
    <div class="container">
        <div class="row shadow-lg rounded-lg justify-content-center mt-5" style="padding-top: 15px;">
            <div class="col-lg-5" style="height: 100%;">
                <img src="../../app/getImagem.php?id=<?php echo $idEvento;?>" alt="Imagem Evento"  loading="lazy" style="width: 100%;">
            </div>
            <div class="col-lg-7">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header">
                    <i class="fas fa-glass-cheers"></i>  Ingressos não Encontrados!!!
                    </div>
                    <div class="card-body">
                        <h2>Não encontramos nenhum ingresso vinculado ao e-mail informado, tente outro e-mail ou fale com o suporte. </h2> 
                        <br>
                        <?php
                            $texto  = 'Estou tentando transferir meu ingresso do STB para o Vintage, mas não encontra nenhum ingresso vinculado ao meu e-mail';
                            $url = urldecode($texto);
                        ?>
                        <br><a href="https://api.whatsapp.com/send?text=<?php echo $url;?>&phone=5567993481631" target="_blank" style="float: right;"><h6><i class="fab fa-whatsapp"></i> Segunda via</h6></a>

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
