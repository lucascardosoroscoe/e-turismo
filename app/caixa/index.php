<?php
include '../includes/header.php';


$nCaixa = $_SESSION["nCaixa"];
if ($nCaixa ==""){
    $url = "../img/fundoLogin.jpg";
    echo ('<div style="background-image: url('.$url.'); background-size: cover;height: 100%;">');
        echo ('<div class="container">');
            echo ('<div class="row justify-content-center">');
                echo ('<div class="col-lg-8">');
                    echo ('<div class="card shadow-lg border-0 rounded-lg mt-5">');
                        echo ('<div class="card-header"><h3 class="text-center font-weight-light my-4">Entrada no Caixa</h3></div>');
                        echo ('<div class="card-body">');
                            echo ('<form action="selecionarcaixa.php" id="selecionarcaixa" method="POST" enctype="multipart/form-data">');
                                echo ('<input type="hidden" name="id" id="id" value="'. $id .'" required>');
                                echo ('<div class="col-md-12">');
                                    echo ('<label class="small mb-1" for="inputName">Nome do Caixa*</label>');
                                    echo ('<input class="form-control py-4" id="inputName"  name="inputName" type="text" placeholder="Digite o Nome" required/>');
                                echo ('</div>');
                                echo ('<div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" type="submit" >Entrar</button></div>');
                            echo ('</form>');
                        echo ('</div>');
                    echo ('</div>');
                echo ('</div>');
            echo ('</div>');
        echo ('</div>');
    echo ('</div>');
}else{
    $id = $_GET['id'];

    $consulta = "SELECT * FROM `Caixa` WHERE `codigoQR` = '$id' AND `usuarioProdutor` = '$produtor'";

    $dados = selecionar($consulta);
    if ($dados[0] == ""){
        $consulta = "INSERT INTO `Fichas de Bar`(`codigoQR`, `usuarioProdutor`, `valor`) VALUES ('$id','$produtor', '0')";
        $msg = executar($consulta);
    }else{
        $saldo = $dados[0]['valor'];
        $idFicha = $dados[0]['idFicha'];
    }
    echo ('<div class="row">');
        echo ('<div class="col s12 m6 push-m3 ">');
        echo ('<br><h3>Caixa nº '. $nCaixa .' - Ficha nº '. $idFicha .'</h3>');
            echo ('<div class="saldo">');
            echo ('<p>Saldo Disponível:</p>');
                echo ('<h2>R$'. number_format($saldo, 2, ',', '.') .'</h2>');
                echo ('</div>');
            echo ('<div class="Adicionar">');
                echo ('<h5>Adicionar Saldo</h5>');
                echo ('<div class="col s5 m5 adicionarDiv" >');
                    echo ('<a class="adicionarValor" href="adicionar.php?id='. $id .'&idFicha='. $idFicha .'&valor=1">+ R$1,00</a>');
                echo ('</div>');
                echo ('<div class="col s5 m5 adicionarDiv" >');
                echo ('<a class="adicionarValor" href="adicionar.php?id='. $id .'&idFicha='. $idFicha .'&valor=5">+ R$5,00</a>');
                echo ('</div>');
                echo ('<div class="col s5 m5 adicionarDiv" >');
                echo ('<a class="adicionarValor" href="adicionar.php?id='. $id .'&idFicha='. $idFicha .'&valor=10">+ R$10,00</a>');
                echo ('</div>');
                echo ('<div class="col s5 m5 adicionarDiv" >');
                echo ('<a class="adicionarValor" href="adicionar.php?id='. $id .'&idFicha='. $idFicha .'&valor=20">+ R$20,00</a>');
                echo ('</div>');
                echo ('<div class="col s5 m5 adicionarDiv" >');
                echo ('<a class="adicionarValor" href="adicionar.php?id='. $id .'&idFicha='. $idFicha .'&valor=50">+ R$50,00</a>');
                echo ('</div>');
                echo ('<div class="col s5 m5 adicionarDiv" >');
                echo ('<a class="adicionarValor" href="adicionar.php?id='. $id .'&idFicha='. $idFicha .'&valor=100">+ R$100,00</a>');
                echo ('</div>');
            echo ('</div>');
        echo ('</div>');
    echo ('</div>');
}

?>
<style>
.saldo{
    background-color: #eee;
    padding: 20px;
    border: solid;
    border-color: #000;
    border-radius: 12px;
    margin-top: 20px;
}
.adicionarDiv{
    background-color: #eee;
    border: solid;
    border-color: #000;
    border-radius: 12px;
    margin-top: 10px;
    padding-top: 10px !important;
    padding-bottom: 10px !important;
    margin-left: 20px !important;
    margin-bottom: 10px !important;
}

.adicionarValor {
    font-size: x-large;
}
</style>
<?php
include '../includes/footer.php';
?>