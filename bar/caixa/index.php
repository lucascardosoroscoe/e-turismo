<?php
include '../../includes/header.php';
$id = $_GET['id'];

$consulta = "SELECT * FROM `Fichas de Bar` WHERE `codigoQR` = '$id' AND `usuarioProdutor` = '$produtor'";

$dados = selecionar($consulta);

$nCaixa = $_SESSION["nCaixa"];
if ($nCaixa ==""){
    echo ('<div class="row">');
        echo ('<div class="col s12 m6 push-m3 ">');
            echo ('<h3>Entrada no Caixa</h3>');
            echo ('<form action="selecionarcaixa.php" id="selecionarcaixa" method="GET">');
            echo ('<input type="hidden" name="id" id="id" value="'. $id .'" required>');
                echo ('<div class="input-field col s12" style="magin-top: 100px">');
                    echo ('<input type="number" name="nCaixa" id="nCaixa" required>');
                    echo ('<label for="nCaixa">Informe o Número do Caixa</label>  ');
                echo ('</div>');
            echo ('<button type="submit" name="btn-cadastrar" class="btn">Conrfirmar</button>');
            echo ('</form>');
        echo ('</div>');
    echo ('</div>');
}else{
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
include '../../includes/footer.php';
?>