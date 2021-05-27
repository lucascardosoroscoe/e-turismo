<?php
include('../../includes/verificarAcesso.php');
verificarAcesso(2);

$codigo = $_POST['codigo'];
$selectLote = $_POST['selectLote'];
$idCliente   = $_POST['idCliente'];
$inputName   = $_POST['inputName'];
$telefone  =  $_POST['inputTelefone'];
$telefone = str_replace(" ", "", $telefone);
$telefone = str_replace("(", "", $telefone);
$telefone = str_replace(")", "", $telefone);
$telefone = str_replace("-", "", $telefone);
$telefone = str_replace("+55", "", $telefone);
$prim = substr($telefone,0,1);
if($prim == 0){
    $telefone = substr($telefone,1,11);
}
$consulta = "SELECT * FROM `Cliente` WHERE `telefone`= '$telefone'";
$dados = selecionar($consulta);
if($dados[0]['id'] != $idCliente && $dados[0]['id'] != ''){
    $idCliente = $dados[0]['id'];
    $consulta = "UPDATE `Ingresso` SET `idCliente`='$idCliente' WHERE `codigo` = '$codigo'";
    $msg = executar($consulta);
}
$consulta = "UPDATE `Cliente` SET `nome`='$inputName',`telefone`= '$telefone' WHERE `id`= $idCliente ";
$msg = executar($consulta);
if($msg == "Sucesso!"){    
    $consulta = "SELECT * FROM `Lote` WHERE `id` = '$selectLote'";
    $dados = selecionar($consulta);
    $valor = $dados[0]['valor'];
    $consulta = "UPDATE `Ingresso` SET `valor`='$valor',`lote`='$selectLote' WHERE `codigo` = '$codigo'";
    $msg = executar($consulta);
    if($msg == "Sucesso!"){
        header('Location: index.php?msg='.$msg);
    }
}
echo $consulta;

?>