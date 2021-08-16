<?php
    include('../includes/verificarAcesso.php');
    verificarAcesso(2);
    include('../includes/headerLogin.php');
    $idProduto = $_GET['idProduto'];
    $idCarteira = $_GET['idCarteira'];
    $id = $_GET['id'];
    $nomeFuncionario = 'Bar Principal';

    $consulta = "SELECT * FROM `Produto` WHERE `idProduto` = '$idProduto'";
    $produto = selecionar($consulta);
    $idProduto = $produto[0]['idProduto'];
    $nome = $produto[0]['nome'];
    $valor = $produto[0]['valor'];
    $valor = number_format($valor, 2, '.', '');

    $saldo = consultarSaldo($idCarteira);

    if ($saldo >= $valor){
        $restante = $saldo - $valor;
        $msg = completarVenda($idCarteira, $restante, $nomeFuncionario, $idProduto, $valor);
        if($msg == "Sucesso!"){
            echo "<body style='background-color: green'>";
            echo ("<h5 style='margin-top: 300px;text-align: center; color:#fff;'>".$nome." vendido com sucesso!!!</h5>");
            echo ("<h4 style='text-align: center; color:#fff;'>Saldo restante: R$".number_format($restante , 2, ',', '.')."</h4>");
            echo ("<a class='btn btn-primary btn-block adicionarDiv' href='venda.php?idProduto=".$idProduto."&id=".$id."&idCarteira=".$idCarteira."'
            style='width: 110px;
            height: 110px;
            padding-top: 40px;
            border-radius: 55px;
            margin: auto;
            margin-top: 35px;'
            >+1 unidade</a>");
            echo "</body>";
        }else{
            echo $msg;
        }
        
    }else{
        echo "<body style='background-color: red'>";
        echo "<h5 style='margin-top: 200px;text-align: center; color:#fff;'>O saldo disponível é insuficiente para compra!!!</h5>";
        echo ("<h4 style='text-align: center; color:#fff;'>Saldo disponível: R$".number_format($saldo, 2, ',', '.')."</h4>");
        echo "</body>";
    }

function consultarSaldo($idCarteira){
    $consulta = "SELECT `saldo` FROM `Carteira` WHERE `id` = '$idCarteira'";
    $dados = selecionar($consulta);
    $saldo = $dados[0]['saldo'];
    return $saldo;
}
function completarVenda($idCarteira, $saldo, $nomeFuncionario, $idProduto, $valor){
    
    $consulta = "INSERT INTO `VendaBar`(`idCarteira`, `nomeFuncionario`, `idProduto`, `valor`) VALUES ('$idCarteira', '$nomeFuncionario', '$idProduto', '$valor')";
    $msg = executar($consulta);
    if($msg == "Sucesso!"){
        $consulta = "UPDATE `Carteira` SET `saldo`= $saldo WHERE `id` = '$idCarteira'";
        $msg = executar($consulta);
    }
    return $msg;
}

    include('../includes/footer.php');
?>