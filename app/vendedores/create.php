<?php
    include('../includes/verificarAcesso.php');
    verificarAcesso(2);
    

    
    $email = $_POST['inputEmailAddress'];
    $nome = $_POST['inputName'];
    $telefone = $_POST['inputTelefone'];
    $hash = password_hash("ingressozapp", PASSWORD_DEFAULT);
    $consulta = "SELECT `id` FROM `Vendedor` WHERE (`usuario` = '$email' OR `email` = '$email') AND `produtor` = '$idUsuario'";
    $msg = verificar($consulta);
    if($msg == "Sucesso!"){
        $consulta = "INSERT INTO `Vendedor`(`usuario`, `produtor`, `senha`, `nome`, `telefone`, `email`) VALUES ('$email', '$idUsuario', '$hash', '$nome', '$telefone', '$email')";
        $msg = executar($consulta);
        if($msg != "Sucesso!"){
            $msg = "Erro ao criar Vendedor, por favor contate o suporte!!";
        }
    }else{
        $msg = "Vendedor já cadastrado. ";
    }
    
    echo $consulta;
    echo $msg;

   header('Location: index.php?msg='.$msg);
?>