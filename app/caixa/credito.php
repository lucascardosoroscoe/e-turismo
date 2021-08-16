<?php
    include('../includes/verificarAcesso.php');
    verificarAcesso(2);
    echo json_encode($_GET);
    
    $codigo = $_GET['codigo'];
    $idCaixa = $_GET['idCaixa'];
    $valor = $_GET['valor'];

    $consulta = "INSERT INTO `Transacoes`(`valor`, `type`, `codigo`) VALUES ('$valor', 1, '$codigo')";
    $msg = executar($consulta);
    if($msg == "Sucesso!"){
        $consulta = "SELECT `id` FROM `Transacoes` WHERE `codigo` = '$codigo' ORDER BY `id` DESC";
        $dados = selecionar($consulta);
        $idTransacao = $dados[0]['id'];
        $consulta = "INSERT INTO `TransacoesCredito`(`idTansacao`, `tipoCredito`, `responsavel`) VALUES ($idTransacao, 1, $idCaixa)";
        $msg = executar($consulta);
        if($msg == "Sucesso!"){
            $consulta ="UPDATE `Carteira` SET `saldo`= `saldo` + $valor WHERE `idIngresso` = '$codigo'";
            $msg = executar($consulta);
            if($msg == "Sucesso!"){
                header('Location: index.php?id='.$codigo);
            }            
        }else{
            $msg = "Erro ao criar Crédito, por favor contate o suporte!!";
            echo $msg;
        }
    }else{
        $msg = "Erro ao criar Transação, por favor contate o suporte!!";
        echo $msg;
    }
    
    
?>