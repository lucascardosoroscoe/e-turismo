<?php
include('../includes/verificarAcesso.php');
verificarAcesso(2);


$id = $_POST['inputId'];
$nome = $_POST['inputName'];
$imagem      = $_FILES["inputImagem"];
$descricao   = $_POST['inputData'];
$data        = $_POST['inputDescricao'];
if($imagem != NULL) { 
    $nomeFinal = time().'.jpg';
    if (move_uploaded_file($imagem['tmp_name'], $nomeFinal)) {
        $tamanhoImg = filesize($nomeFinal); 
 
        $mysqlImg = addslashes(fread(fopen($nomeFinal, "r"), $tamanhoImg)); 
    }
    $consulta = "UPDATE `Evento` SET `nome`='$nome',`imagem`='$imagem',`data`='$data',`descricao`='$descricao' WHERE `id` = '$id'";
    $msg = executar($consulta);
}else{
    $consulta = "UPDATE `Evento` SET `nome`='$nome',`data`='$data',`descricao`='$descricao' WHERE `id` = '$id'";
    $msg = executar($consulta);
}
header('Location: index.php?msg='.$msg);
?>