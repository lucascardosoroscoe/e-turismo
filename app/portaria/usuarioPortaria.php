<?php
include('../includes/verificarAcesso.php');
$email = $_POST['inputEmailAddress'];

$consulta = "SELECT `id`, `nome`, `senha` FROM `Produtor` WHERE `email` = '$email'";
$dados = selecionar($consulta);
$id = $dados[0]['id'];
$nome = $dados[0]['nome'];
if($id != ""){
    $_SESSION["idUsuarioPortaria"] = $id;
    $_SESSION["nomeUsuarioPortaria"] = $nome;
    $msg = "Produtor vinculado com sucesso!";
}else{
    $msg = "Erro ao encontrar produtor!";
}
header('Location: ../../index.php?msg='.$msg);