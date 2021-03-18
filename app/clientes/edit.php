<?php
include('../includes/verificarAcesso.php');
verificarAcesso(2);



$id = $_POST['inputId'];
$nome = $_POST['inputName'];
$telefone = $_POST['inputTelefone'];
    $consulta = "UPDATE `Cliente` SET `nome`='$nome',`telefone`='$telefone' WHERE `id` = '$id'";
    $msg = executar($consulta);
header('Location: index.php?msg='.$msg);
?>