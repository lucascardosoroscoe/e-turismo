<?php
include('../includes/verificarAcesso.php');
verificarAcesso(2);

$codigo = $_POST['codigo'];
$id   = $_POST['id'];
$hash   = $_POST['hash'];
$idCliente   = $_POST['idCliente'];
$inputName   = $_POST['inputName'];
$telefone  =  $_POST['inputTelefone'];
$telefoneAntigo  =  $_POST['telefoneAntigo'];
$nomeAntigo  =  $_POST['nomeAntigo'];
$telefone = limparTelefone($telefone);
$telefoneAntigo = limparTelefone($telefoneAntigo);

// Verifica se o Telefone mudou
if($telefone == $telefoneAntigo){
    modificarNome($inputName, $idCliente);
    echo "Telefone igual";
    $msg = "Leia as instruções para fazer a mudança de titularidade corretamente. Se tiver trocando a titularidade para outra pessoa, lembre-se de trocar o número de telefone.";
}else{
    echo "Telefones diferentes";
    modificarCliente($codigo, $telefone, $idCliente, $inputName);
    modificarTitularidade($codigo, $nomeAntigo, $inputName);
    $msg = "Mudança de Titularidade feita com sucesso!";
}

header('Location: index.php?id='.$id.'&hash='.$hash.'&msg='.$msg);


function modificarCliente($codigo, $telefone, $idCliente, $inputName){
    //Se já existe outro cliente que tem esse telefone, coloca ele como cliente principal e muda o nome
    $consulta = "SELECT * FROM `Cliente` WHERE `telefone`= '$telefone'";
    $dados = selecionar($consulta);
    echo $dados[0]['id'] . '<br>';
    echo $idCliente . '<br>';

    $consulta = "INSERT INTO `Cliente`(`nome`, `telefone`) VALUES ('$inputName','$telefone')";
    $msg = executar($consulta); 
    $consulta = "SELECT id FROM `Cliente` WHERE `nome` = '$inputName' AND `telefone` = '$telefone'";
    $Cliente  = selecionar($consulta);
    $idCliente = $Cliente[0]['id'];
    $consulta = "UPDATE `Ingresso` SET `idCliente`='$idCliente' WHERE `codigo` = '$codigo'";
    echo $consulta;
    $msg = executar($consulta);  
    echo $consulta;
}

function modificarNome($inputName, $idCliente){
    $consulta = "UPDATE `Cliente` SET `nome`='$inputName' WHERE `id`= $idCliente ";
    $msg = executar($consulta);
}

function modificarTitularidade($codigo, $nomeAntigo, $cliente){
    $msg = "#ATENÇÃO: Esse ingresso já teve 1 Mudança de Titularidade, de ".$nomeAntigo." para ".$cliente; 
    $consulta = "UPDATE `Ingresso` SET `msgTitularidade`= '$msg' WHERE `codigo` = '$codigo'";
    $msg = executar($consulta);
}

function limparTelefone($telefone){
    $telefone = str_replace(" ", "", $telefone);
    $telefone = str_replace("(", "", $telefone);
    $telefone = str_replace(")", "", $telefone);
    $telefone = str_replace("-", "", $telefone);
    $telefone = str_replace("+55", "", $telefone);
    $prim = substr($telefone,0,1);
    if($prim == 0){
        $telefone = substr($telefone,1,11);
    }
    return $telefone;
}
?>