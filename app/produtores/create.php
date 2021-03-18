<?php
    include('../includes/verificarAcesso.php');
    verificarAcesso(1);
    

    $email = $_POST['inputEmailAddress'];
    $nome = $_POST['inputName'];
    $telefone = $_POST['inputTelefone'];
    $cidade = $_POST['inputCidade'];
    $estado = $_POST['inputEstado'];
    $inputConfirmPassword = $_POST['inputConfirmPassword'];
    $inputPassword = $_POST['inputPassword'];

    if($inputPassword == $inputConfirmPassword){
        $hash = password_hash($inputPassword, PASSWORD_DEFAULT);
        $consulta = "SELECT `id` FROM `Produtor` WHERE `usuario` = '$email'";
        $msg = verificar($consulta);
        if($msg == "Sucesso!"){
            $consulta = "INSERT INTO `Produtor`(`usuario`, `senha`, `nome`, `telefone`, `email`, `cidade`, `estado`) VALUES ('$email', '$hash', '$nome', '$telefone', '$email', '$cidade', '$estado')";
            $msg = executar($consulta);
            if($msg != "Sucesso!"){
                $msg = "Erro ao criar Usuário, por favor contate o suporte!!";
            }
        }else{
            $msg = "E-mail do Usuário já cadastrado. ";
        }
    }else{
        $msg = "A senha não condiz com a confirmação de Senha";
    }
    echo $consulta;
    echo $msg;

   header('Location: index.php?msg='.$msg);
?>