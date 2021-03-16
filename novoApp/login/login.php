<?php
include('../includes/bancoDados.php');

$email = $_POST['inputEmailAddress'];
$inputPassword = $_POST['inputPassword'];

$consulta = "SELECT `id`, `name`, `email`, `hashedpassword`, `type` FROM `tc_users` WHERE `email` = '$email'";
$dados = selecionar($consulta);
$hash = $dados[0]['hashedpassword'];
$valid = password_verify($inputPassword, $hash);
if ($valid == 1){
    $msg = "Sucesso!";
    session_start();
    /*session created*/
    $_SESSION["idUsuario"] = $dados[0]['id'];
    $_SESSION["usuario"] = $dados[0]['name'];
    $_SESSION["tipoUsuario"] = $dados[0]['type'];
    header('Location: ../index.php?msg='.$msg);
}else{
    $msg = "Login os Senha Incorretos";
    header('Location: index.php?msg='.$msg);
}
?>