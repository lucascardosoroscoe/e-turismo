<?php
include('../includes/verificarAcesso.php');
verificarAcesso(2);



$id = $_POST['inputId'];
$email = $_POST['inputEmailAddress'];
$nome = $_POST['inputName'];
$telefone = $_POST['inputTelefone'];
$resetPasswordCheck = $_POST['resetPasswordCheck'];
if($resetPasswordCheck == '1'){
        $hash = password_hash("ingressozapp", PASSWORD_DEFAULT);
        $consulta = "UPDATE `Vendedor` SET `usuario`='$email',`senha`='$hash',`nome`='$nome',`telefone`='$telefone',
        `email`='$email' WHERE `id` = '$id'";
        $msg = executar($consulta);
}else{
    $consulta = "UPDATE `Vendedor` SET `usuario`='$email',`nome`='$nome',`telefone`='$telefone',
        `email`='$email' WHERE `id` = '$id'";
    $msg = executar($consulta);
}


echo $consulta;
header('Location: index.php?msg='.$msg);
?>