<?php
include('../includes/verificarAcesso.php');
verificarAcesso(2);
include('../includes/header.php');
$id = $_GET["id"];
$consulta = "SELECT * FROM Evento WHERE id = '$id'";
$dados = selecionar($consulta);
$obj = $dados[0];
$nome = $obj['nome'];
$produtor = $obj['produtor'];
?>     
    <div style='background-image: url("../img/fundoLogin.jpg"); background-size: cover;height: 100%;'>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4"><?php echo $nome;?></h3></div>
                        <div class="card-body">
                            <?php
                                echo ("<img class='imgEvento' src='../../getImagem.php?nome=$nome&produtor=$produtor'/>");
                                echo ("<br><br><h4>Data do Evento: ".$obj['data']."</h4>"); 
                                echo ("<br><h4>Descrição do Evento: ".$obj['descricao']."</h4>"); 
                                echo ("<br><h4>Validade do Evento: ".$obj['validade']."</h4>");
                            ?>
                            <div class="form-group mt-4 mb-0"><a class="btn btn-primary btn-block" href="./index.php" type="submit" >Voltar</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
include('../includes/footer.php');
?>