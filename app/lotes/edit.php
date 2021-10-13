<?php
include('../includes/verificarAcesso.php');
verificarAcesso(2);


$id = $_POST['inputId'];
$nome = $_POST['inputName'];
$valor   = $_POST['inputValor'];
$valor = substr($valor, 0, -3);
$quantidade        = $_POST['inputQuantidade'];
$consulta = "UPDATE `Lote` SET `nome`='$nome',`valor`='$valor',`quantidade`='$quantidade' WHERE `id` = '$id'";
$msg = executar($consulta);

header('Location: index.php?msg='.$msg);
?>