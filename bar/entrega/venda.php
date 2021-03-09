<?php
    session_start();
    /*session created*/
    $idProdutor = $_SESSION["usuario"];
    $idProduto = $_GET['idProduto'];
    $idFicha = $_GET['idFicha'];
    $id = $_GET['id'];
    $nomeFuncionario = 'Lucas Roscoe';
    include_once '../../includes/header.php';

    $consulta = "SELECT * FROM `Produto` WHERE `idProduto` = '$idProduto'";
    $produto = selecionar($consulta);
    $idProduto = $produto[0]['idProduto'];
    $nome = $produto[0]['nome'];
    $valor = $produto[0]['valor'];
    $valor = number_format($valor, 2, '.', '');

    $saldo = consultarSaldo($idFicha);

    if ($saldo >= $valor){
        completarVenda($idFicha, $valor, $nomeFuncionario, $idProduto);
        echo "<body style='background-color: green'>";
        echo ("<h5 style='margin-top: 300px; color:#fff;'>".$nome." vendido com sucesso!!!</h5>");
        $restante = number_format($saldo - $valor , 2, ',', '.');
        echo ("<h4 style='text-align: center; color:#fff;'>Saldo restante: R$".$restante."</h4>");
        echo "</body>";
    }else{
        echo "<body style='background-color: red'>";
        echo "<h5 style='margin-top: 300px; color:#fff;'>O saldo disponível é insuficiente para compra!!!</h5>";
        echo ("<h4 style='text-align: center; color:#fff;'>Saldo disponível: R$".number_format($saldo, 2, ',', '.')."</h4>");
        echo "</body>";
    }

function consultarSaldo($idFicha){
    $consulta = "SELECT `valor` FROM `Fichas de Bar` WHERE `idFicha` = '$idFicha'";
    $dados = selecionar($consulta);
    $saldo = $dados[0]['valor'];
    $saldo = number_format($saldo, 2, '.', '');
    return $saldo;
}
function completarVenda($idFicha, $valor, $nomeFuncionario, $idProduto){
    $consulta = "UPDATE `Fichas de Bar` SET `valor`= `valor` - $valor WHERE `idFicha` = '$idFicha'";
    $msg = executar($consulta);
    $consulta = "INSERT INTO `Log Venda Bar`(`idFicha`, `nomeFuncionario`, `idProduto`, `valor`) VALUES ('$idFicha', '$nomeFuncionario', '$idProduto', '$valor')";
    $msg = executar($consulta);
}

?>