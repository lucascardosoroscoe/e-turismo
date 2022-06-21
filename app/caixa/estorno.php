<?php
include('../includes/verificarAcesso.php');
verificarAcesso(2);
include '../includes/headerLogin.php';


$nCaixa = $_SESSION["nCaixa"];

    $url = "../img/fundoLogin.jpg";
    echo ('<div style="background-image: url('.$url.'); background-size: cover;height: 100%;">');
        echo ('<div class="container">');
            echo ('<div class="row justify-content-center">');
                echo ('<div class="col-lg-8">');
                    echo ('<div class="card shadow-lg border-0 rounded-lg mt-5">');
                        if ($nCaixa ==""){
                            echo ('<div class="card-header"><h3 class="text-center font-weight-light my-4">Entrada no Caixa</h3></div>');
                            echo ('<div class="card-body">');
                                echo ('<form action="selecionarCaixa.php" id="selecionarCaixa" method="POST" enctype="multipart/form-data">');
                                    echo ('<input type="hidden" name="id" id="id" value="'. $id .'" required>');

                                    echo ('<div class="col-md-12">');
                                        selectCaixa();
                                    echo ('</div>');
                                    echo ('<div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block adicionarDiv" onclick="enviarForm()" >Selecionar</button></div>');
                                    echo ('<br><a class="btn btn-primary btn-block adicionarDiv" href="adicionar.php" >Adicionar</a>');
                                echo ('</form>');
                            echo ('</div>');
                        }else{
                            $id = $_GET['id'];
                            $consulta = "SELECT * FROM `Carteira` WHERE `idIngresso` = '$id'";
                            $dados = selecionar($consulta);
                            if ($dados[0] == ""){
                                $consulta = "INSERT INTO `Carteira`(`idIngresso`, `saldo`) VALUES ('$id', '0')";
                                echo $consulta;
                                $msg = executar($consulta);
                            }else{
                                $saldo = $dados[0]['saldo'];
                                $idCarteira = $dados[0]['id'];
                            }



                            echo ('<div class="card-header"><h3 class="text-center font-weight-light my-4">Cartão nº '. $id .'</h3></div>');
                            echo ('<div class="card-body">');
                                echo ('<div class="saldo">');
                                    echo ('<p style="float: left;">Saldo Disponível:</p>');
                                    echo ('<h2 style="float: right; color: #1a6ae1;">   R$'. number_format($saldo, 2, ',', '.') .'</h2>');
                                echo ('</div>');
                                echo ('<div class="Adicionar">');
                                    // echo ('<h5>Adicionar Saldo</h5>');
                                    echo ('<div class="form-row">');
                                        echo ('<a class="btn btn-primary btn-block adicionarDiv" href="estornar.php?codigo='.$id.'&idCaixa='.$nCaixa.'&valor=1">Devolver R$1,00</a>');
                                        echo ('<a class="btn btn-primary btn-block adicionarDiv" href="estornar.php?codigo='.$id.'&idCaixa='.$nCaixa.'&valor=5">Devolver R$5,00</a>');
                                        echo ('<a class="btn btn-primary btn-block adicionarDiv" href="estornar.php?codigo='.$id.'&idCaixa='.$nCaixa.'&valor=10">Devolver R$10,00</a>');
                                        echo ('<a class="btn btn-primary btn-block adicionarDiv" href="estornar.php?codigo='.$id.'&idCaixa='.$nCaixa.'&valor=20">Devolver R$20,00</a>');
                                        echo ('<a class="btn btn-primary btn-block adicionarDiv" href="estornar.php?codigo='.$id.'&idCaixa='.$nCaixa.'&valor=50">Devolver R$50,00</a>');
                                        echo ('<a class="btn btn-primary btn-block adicionarDiv" href="estornar.php?codigo='.$id.'&idCaixa='.$nCaixa.'&valor=100">Devolver R$100,00</a>');
                                        echo ('<a class="btn btn-primary btn-block adicionarDiv" href="estornar.php?codigo='.$id.'&idCaixa='.$nCaixa.'&valor='.$saldo.'">Devolver Tudo</a>');
                                        
                                    echo ('</div>');
                                echo ('</div>');
                            echo ('</div>');
                        }
                    echo ('</div>');
                echo ('</div>');
            echo ('</div>');
        echo ('</div>');
    echo ('</div>');


?>
<style>
.saldo{
    padding: 10px;
    border: solid 2px;
    border-color: #f45a2a;
    border-radius: 8px;
    margin-bottom: 20px;
}
.adicionarDiv{
    margin-top: 10px;
    padding-top: 10px !important;
    padding-bottom: 10px !important;
    margin-bottom: 10px !important;
}

.btn{
    font-size: x-large;
}
.saldo{
    display: flow-root;
}
</style>
<script src="index.js"></script>
<?php

function selectCaixa(){
    global $idUsuario, $tipoUsuario;
      $consulta = "SELECT `id`, `nome` FROM `Caixa` WHERE `idProdutor` = '$idUsuario' ORDER BY `nome`";
    $dados = selecionar($consulta);
    echo('<select class="form-control" name="selectCaixa" id="selectCaixa" form="selecionarCaixa" required>');
        echo('<option value="">Selecione o Caixa</option>');
        foreach ($dados as $caixa) {
            echo('<option value="'. $caixa['id'] .'">'. $caixa['nome'] .'</option>');
        }
    echo('</select>');
}

function verificarPIX(){
    
}
include '../includes/footer.php';
?>