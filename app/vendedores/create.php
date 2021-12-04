<?php
    include('../includes/verificarAcesso.php');
    verificarAcesso(2);
    

    
    $email = $_POST['inputEmailAddress'];
    $nome = $_POST['inputName'];
    $telefone = $_POST['inputTelefone'];
    $hash = password_hash("ingressozapp", PASSWORD_DEFAULT);
    $consulta = "SELECT `id` FROM `Vendedor` WHERE (`usuario` = '$email' OR `email` = '$email')";
    $dados = selecionar($consulta);
    $idVendedor = $dados[0]['id'];
    if($idVendedor == ""){
        $consulta = "INSERT INTO `Vendedor`(`usuario`, `produtor`, `senha`, `nome`, `telefone`, `email`) VALUES ('$email', '$idUsuario', '$hash', '$nome', '$telefone', '$email')";
        $msg = executar($consulta);
        if($msg == "Sucesso!"){
            $consulta = "SELECT `id` FROM `Vendedor` WHERE (`usuario` = '$email' OR `email` = '$email')";
            $dados = selecionar($consulta);
            $idVendedor = $dados[0]['id'];
            $consulta = "INSERT INTO `ProdutorVendedor`(`idProdutor`, `idVendedor`) VALUES ('$idUsuario', '$idVendedor')";
            $msg = executar($consulta);
        }else{
            $msg = "Erro ao criar Vendedor, por favor contate o suporte!!";
        }
    }else{
        $consulta = "INSERT INTO `ProdutorVendedor`(`idProdutor`, `idVendedor`) VALUES ('$idUsuario', '$idVendedor')";
        $msg = executar($consulta);
    }
    $msg = "Olá " . $nome . ", tudo bem? " . "Você acaba de ser cadastrado como promoter do(a) " . $usuario . " no aplicativo IngressoZapp. Caso nunca tenha usado o app, seu primeiro acesso, utilize a senha padrão 'ingressozapp' (minusculo e sem aspas). Para vender ingressos via android acesse e baixe o app em: https://play.google.com/store/apps/details?id=ingressozapp.com.promoteringressozapp . Para vender via IOS, acesse o site: https://ingressozapp.com/app .";
    $txt = urlencode($msg);
    header('Location: https://api.whatsapp.com/send?phone=55'.$telefone.'&text='.$msg);
?>