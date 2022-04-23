<?php
include('../includes/verificarAcesso.php');
verificarAcesso(2);



$id = $_POST['inputId'];
$email = $_POST['inputEmailAddress'];
$nome = $_POST['inputName'];
$telefone = $_POST['inputTelefone'];
$resetPasswordCheck = $_POST['resetPasswordCheck'];
$inputPassword = $_POST['inputPassword'];
$inputConfirmPassword = $_POST['inputConfirmPassword'];
if($resetPasswordCheck == '1'){
    if($tipoUsuario == 2){
        if($inputPassword == $inputConfirmPassword){
            $hash = password_hash($inputPassword, PASSWORD_DEFAULT);
            $consulta = "UPDATE `Produtor` SET `usuario`='$email',`senha`='$hash',`nome`='$nome',`telefone`='$telefone',
            `email`='$email',`cidade`='$cidade',`estado`='$estado' WHERE `id` = '$id'";
            $msg = executar($consulta);
        }else{
            $msg = "A senha não condiz com a confirmação de Senha";
        }
    }else if($tipoUsuario == 3){
        if($inputPassword == $inputConfirmPassword){
            $hash = password_hash($inputPassword, PASSWORD_DEFAULT);
            $consulta = "UPDATE `Vendedor` SET `usuario`='$email',`senha`='$hash',`nome`='$nome',`telefone`='$telefone',
            `email`='$email' WHERE `id` = '$id'";
            $msg = executar($consulta);
        }else{
            $msg = "A senha não condiz com a confirmação de Senha";
        }
    }
}else{
    $consulta = "UPDATE `Vendedor` SET `usuario`='$email',`nome`='$nome',`telefone`='$telefone',
        `email`='$email' WHERE `id` = '$id'";
    $msg = executar($consulta);
    $msg = "Dados alterados com Sucesso!!!";
}
header('Location: ../../index.php?msg='.$msg);
?>   