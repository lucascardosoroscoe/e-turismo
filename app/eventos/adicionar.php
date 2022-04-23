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
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Adicionar Evento</h3></div>
                        <div class="card-body">
                            <form action="create.php" id="create_evento" method="POST" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputName">Nome do Evento*</label>
                                            <input class="form-control py-4" id="inputName"  name="inputName" type="text" placeholder="Digite o Nome" onchange="sugerirSlug()" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            Link do Evento* (letras minúsculas, sem caracteres especiais ou acentos, apenas '-')<br>
                                            <label class="small mb-1" for="slug">ingressozapp.com/produtos/</label>
                                            <input class="" id="slug"  name="slug" type="text" placeholder="Digite o link" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="inputImagem">Imagem de Capa*</label>
                                            <input style="padding: 4px;" class="form-control" name="inputImagem" type="file" id="inputImagem" required> 
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="inputData">Data de Realização*</label>
                                            <input class="form-control py-4" type="date" name="inputData" id="inputData" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputDescricao">Descrição do Evento*</label>
                                            <textarea class="form-control py-4" id="inputDescricao"  name="inputDescricao" rows="5" placeholder="Texto descritivo do Evento para ser exibido no ingresso." required></textarea>
                                            <!-- <input class="form-control py-4" id="inputDescricao"  name="inputDescricao" type="text" placeholder="Digite o nome completo" required/> -->
                                        </div>
                                    </div>
                                </div>
                                <?php
                                    //Se for tipo 1 -> Selecionar Produtor
                                ?>
                                <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" type="submit" >Adicionar Evento</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function sugerirSlug(){
            var nome = document.getElementById('inputName').value;
            var slug = nome.toLowerCase();
            var er = /[^a-z0-9]/gi;
		    slug = slug.replace(er, "-");
            document.getElementById('slug').value = slug;
        }
    </script>
<?php
include('../includes/footer.php');
?>