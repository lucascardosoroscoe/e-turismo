<?php
include('../includes/verificarAcesso.php');
verificarAcesso(2);
include('../includes/header.php');
$msg = $_GET['msg'];
?>     
    <div style='background-image: url("../img/fundoLogin.jpg"); background-size: cover;height: 100%;'>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header">
                            <h3 class="text-center font-weight-light my-4">Adicionar Link de Rastreio de Tráfego</h3>
                            <h6 class="text-center font-weight-light my-4 text-warning"><?php echo $msg;?></h6>
                        </div>
                        <div class="card-body">
                            <form action="create.php" id="create_lote" method="POST" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group"> 
                                            <label class="small mb-1" for="selectEvento">Selecione o Evento*</label>
                                            <?php selectEvento();?>                                        
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="small mb-1" for="selectFonte">Selecione a Origem do Tráfego*</label>
                                            <?php selectFonte();?>  
                                        </div>
                                    </div>
                                </div>
                                <div style="display:none;" id="divMedium"class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputMedium" id="labelMedium">Meio *</label>
                                            <input class="form-control py-4" id="inputMedium"  name="inputMedium" type="text" placeholder="Digite o meio"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputExtra">Parâmetro Extra (opcional)</label>
                                            <input class="form-control py-4" id="inputExtra"  name="inputExtra" type="text"  placeholder="Ex.: Teste Outdoor Av. Afonso Pena"/>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" onclick="enviarForm()" >Criar Link</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
function selectFonte(){
    echo('<select class="form-control" name="selectFonte" id="selectFonte" onchange="selectfonte()"  form="create_lote" required>');
        echo('<option value="">Selecione uma Origem de Tráfego</option>');    
        echo('<option value="Banner/Flyer/Impressos">Banner/Flyer/Impressos</option>');
        echo('<option value="Disparo Whatsapp">Disparo Whatsapp</option>');
        echo('<option value="Disparo E-mail">Disparo E-mail</option>');
        echo('<option value="Facebook/Instagram Orgânico">Facebook/Instagram Orgânico</option>');
        echo('<option value="Facebook/Instagram Impulsionamento">Facebook/Instagram Impulsionamento</option>');
        echo('<option value="Google/Youtube Ads">Google/Youtube Ads</option>');
        echo('<option value="Linktree">Linktree</option>');
        echo('<option value="Outdoor">Outdoor</option>');
        echo('<option value="Promoters">Promoters</option>');
        echo('<option value="Tik Tok">Tik Tok</option>');      
    echo('</select>');
  }
include('../includes/footer.php');
?>