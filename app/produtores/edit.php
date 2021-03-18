<?php
include('../includes/verificarAcesso.php');
verificarAcesso(1);



$id = $_POST['inputId'];
$email = $_POST['inputEmailAddress'];
$nome = $_POST['inputName'];
$telefone = $_POST['inputTelefone'];
$cidade = $_POST['inputCidade'];
$estado = $_POST['inputEstado'];
$pagos = $_POST['inputPagos'];
$pagos = 1;
$inputConfirmPassword = $_POST['inputConfirmPassword'];
$inputPassword = $_POST['inputPassword'];
$resetPasswordCheck = $_POST['resetPasswordCheck'];
if($resetPasswordCheck == '1'){
    if($inputPassword == $inputConfirmPassword){
        $hash = password_hash($inputPassword, PASSWORD_DEFAULT);
        $consulta = "UPDATE `Produtor` SET `usuario`='$email',`senha`='$hash',`nome`='$nome',`telefone`='$telefone',
        `email`='$email',`cidade`='$cidade',`estado`='$estado' WHERE `id` = '$id'";
        $msg = executar($consulta);
    }else{
        $msg = "A senha não condiz com a confirmação de Senha";
    }
}else{
    $consulta = "UPDATE `Produtor` SET `usuario`='$email',`nome`='$nome',`telefone`='$telefone',
        `email`='$email',`cidade`='$cidade',`estado`='$estado' WHERE `id` = '$id'";
    $msg = executar($consulta);
}


echo $consulta;
header('Location: index.php?msg='.$msg);
?>