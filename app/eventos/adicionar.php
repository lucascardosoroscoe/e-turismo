<?php
include('../includes/verificarAcesso.php');
verificarAcesso(2);
include('../includes/header.php');
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
                            <form action="create.php" id="create_evento" method="POST" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputName">Nome do Evento*</label>
                                            <input class="form-control py-4" id="inputName"  name="inputName" type="text" placeholder="Digite o Nome" onchange="sugerirSlug()" onclick="voltarTexto()" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            Link do Evento: www.ingressozapp.com/eventos/<span id='slugTxt'></span></label>
                                            <input class="" id="slug"  name="slug" type="hidden" placeholder="Digite o link" required/>
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="small mb-1" for="selectEstilo">Estilo Músical*</label>
                                            <select class="form-control" name="selectEstilo" onclick="voltarTexto()" id="selectEstilo" form="create_evento" required>
                                                <option value="">Selecione o estilo musical</option>
                                                <?php
                                                    $consulta = "SELECT * FROM EstiloMusical WHERE 1 ORDER BY estilo";
                                                    $dados = selecionar($consulta);
                                                    foreach ($dados as $estilo) {
                                                        echo('<option value="'. $estilo['id'] .'">'. $estilo['estilo'] .'</option>');
                                                    }
                                                ?>
                                            </select>

                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputImagem">Imagem de Capa (JPEG/PNG) obs.: Até 900px de altura ou largura*</label>
                                            <input style="padding: 4px;" class="form-control" onclick="voltarTexto()" name="inputImagem" type="file" id="inputImagem"  accept="image/jpeg, image/png" required> 
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputData">Data de Realização*</label>
                                            <input class="form-control py-4" type="date" onclick="voltarTexto()" name="inputData" id="inputData" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputDescricao" onclick="voltarTexto()">Descrição do Evento</label>
                                            <textarea class="form-control py-4" id="inputDescricao" onclick="voltarTexto()" name="inputDescricao" rows="5" placeholder="Texto descritivo do Evento para ser exibido no ingresso."></textarea>
                                            <!-- <input class="form-control py-4" id="inputDescricao"  name="inputDescricao" type="text" placeholder="Digite o nome completo" required/> -->
                                        </div>
                                    </div>
                                </div>
                                <?php
                                    //Se for tipo 1 -> Selecionar Produtor
                                ?>
                                <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" id="addEvento" onclick="enviarForm()">Adicionar Evento</button></div>
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
            if(slug.substr(-1) == ' '){
                slug = slug.substr(0, slug.length-1);
            }
            slug = slug.replace(new RegExp('[ÁÀÂÃ]','gi'), 'a');
            slug = slug.replace(new RegExp('[ÉÈÊ]','gi'), 'e');
            slug = slug.replace(new RegExp('[ÍÌÎ]','gi'), 'i');
            slug = slug.replace(new RegExp('[ÓÒÔÕ]','gi'), 'o');
            slug = slug.replace(new RegExp('[ÚÙÛ]','gi'), 'u');
            slug = slug.replace(new RegExp('[Ç]','gi'), 'c');
		    slug = slug.replace(er, "-");
            document.getElementById('slug').value = slug;
            document.getElementById('slugTxt').innerHTML = slug;
        }
    </script>
<?php
include('../includes/footer.php');
?>