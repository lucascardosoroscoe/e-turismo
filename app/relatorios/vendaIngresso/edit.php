<?php
include('../../includes/verificarAcesso.php');
verificarAcesso(2);

$codigo = $_POST['codigo'];
$selectLote = $_POST['selectLote'];
$idCliente   = $_POST['idCliente'];
$inputName   = $_POST['inputName'];
$telefone  =  $_POST['inputTelefone'];
$telefoneAntigo  =  $_POST['telefoneAntigo'];
$telefone = limparTelefone($telefone);
$telefoneAntigo = limparTelefone($telefoneAntigo);

// Verifica se o Telefone mudou
if($telefone == $telefoneAntigo){
    modificarNome($inputName, $idCliente);
    echo "Telefone igual";
}else{
    echo "Telefones diferentes";
    modificarCliente($codigo, $telefone, $idCliente, $inputName);
}

if($tipoUsuario == 1){
    $consulta = "SELECT * FROM `Lote` WHERE `id` = '$selectLote'";
    $dados = selecionar($consulta);
    $valor = $dados[0]['valor'];
    $consulta = "UPDATE `Ingresso` SET `valor`='$valor',`lote`='$selectLote' WHERE `codigo` = '$codigo'";
    $msg = executar($consulta);
    if($msg == "Sucesso!"){
        header('Location: index.php?msg='.$msg);
    }
}else{
    header('Location: index.php?msg='.$msg);

}




function modificarCliente($codigo, $telefone, $idCliente, $inputName){
    //Se já existe outro cliente que tem esse telefone, coloca ele como cliente principal e muda o nome
    $consulta = "SELECT * FROM `Cliente` WHERE `telefone`= '$telefone'";
    $dados = selecionar($consulta);
    echo $dados[0]['id'] . '<br>';
    echo $idCliente . '<br>';
    if($dados[0]['id'] != $idCliente && $dados[0]['id'] != ''){
        $idCliente = $dados[0]['id'];
        $consulta = "UPDATE `Ingresso` SET `idCliente`='$idCliente' WHERE `codigo` = '$codigo'";
        $msg = executar($consulta);  
        modificarNome($inputName, $idCliente);
    }else if($dados[0]['id'] == ''){
        $consulta = "INSERT INTO `Cliente`(`nome`, `telefone`) VALUES ('$inputName','$telefone')";
        $msg = executar($consulta); 
        $consulta = "SELECT id FROM `Cliente` WHERE `nome` = '$inputName' AND `telefone` = '$telefone'";
        $Cliente  = selecionar($consulta);
        $idCliente = $Cliente[0]['id'];
        $consulta = "UPDATE `Ingresso` SET `idCliente`='$idCliente' WHERE `codigo` = '$codigo'";
        $msg = executar($consulta);  
    }else{
        modificarNome($inputName, $idCliente);
    }
    echo $consulta;
}

function modificarNome($inputName, $idCliente){
    $consulta = "UPDATE `Cliente` SET `nome`='$inputName' WHERE `id`= $idCliente ";
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