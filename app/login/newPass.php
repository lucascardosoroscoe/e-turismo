<?php
include('../includes/verificarAcesso.php');
$hash = $_POST['hash'];
$inputSenha = $_POST['inputSenha'];
$inputSenha2 = $_POST['inputSenha2'];
if ($inputSenha == $inputSenha2){
    $hashPass = password_hash($inputSenha, PASSWORD_DEFAULT);
    $consulta = "SELECT * FROM `RedifinirSenha` WHERE `hash`= '$hash' AND status = 1";
    $dados = selecionar($consulta); 
    if ($dados[0]==""){
        $msg = "Link de redefinição de senha inválido ou espirado";
        header('Location: ./index.php?msg='.$msg);
    }else{
        $email = $dados[0]['email'];
        if($dados[0]['tipoUsuario'] == 2){
            $consulta = "UPDATE `Produtor` SET `senha`='$hashPass' WHERE `email` = '$email'";
            $msg = executar($consulta);
        }else if($dados[0]['tipoUsuario'] == 3){
            $consulta = "UPDATE `Vendedor` SET `senha`='$hashPass' WHERE `email` = '$email'";
            $msg = executar($consulta);
        }else if($dados[0]['tipoUsuario'] == 4){
            $consulta = "UPDATE `Cliente` SET `senha`='$hashPass' WHERE `email` = '$email'";
            $msg = executar($consulta);
        }
        if($msg = 'Sucesso!'){
            $msg = "Sucesso ao modificar sua senha, faça login!";
            header('Location: ./index.php?msg='.$msg);
        }else{
            $msg = "Erro ao modificar sua senha, entre em contato com 67 99965-4445!";
            header('Location: ./index.php?msg='.$msg);
        }
    }
}else{
    $msg = "A senha e a confirmação devem ser idênticas.";
    header('Location: ./recover.php?msg='.$msg.'&hash='.$hash);
}
?>