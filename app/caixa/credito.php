<?php
    include('../includes/verificarAcesso.php');
    verificarAcesso(2);
    include('../includes/headerLogin.php');
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
                $consulta = "SELECT saldo FROM `Carteira` WHERE `idIngresso` = '$codigo'";
                $saldo = selecionar($consulta);
                $resultante = $saldo[0]['saldo'];
                echo "<body style='background-color: green'>";
                    echo ("<h5 style='margin-top: 300px;text-align: center; color:#fff;'>Saldo adicionado com sucesso!!!</h5>");
                    echo ("<h4 style='text-align: center; color:#fff;'>Saldo resultante: R$".number_format($resultante , 2, ',', '.')."</h4>");
                    echo ("<div style='display:flex;'>");
                        echo ("<div style='width:50%;padding:3px;'>");
                            echo ("<a class='btn btn-primary btn-block adicionarDiv' href='index.php?id=".$codigo."'>Adicionar Mais</a>");
                        echo ('</div>');
                        echo ("<div style='width:50%;padding:3px;'>");
                            echo ("<a class='btn btn-primary btn-block adicionarDiv' href='../index.php'>Finalizar</a>");
                        echo ('</div>');
                    echo ('</div>');
                echo "</body>";
            }else{
                echo $msg;
            }           
        }else{
            $msg = "Erro ao criar Crédito, por favor contate o suporte!!";
            echo $msg;
        }
    }else{
        $msg = "Erro ao criar Transação, por favor contate o suporte!!";
        echo $msg;
    }
    include('../includes/footer.php');
?>