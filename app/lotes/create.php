<?php
    include('../includes/verificarAcesso.php');
    verificarAcesso(2);
    
    
    $nome = $_POST['inputName'];
    $valor   = $_POST['inputValor'];
    
    $quantidade        = $_POST['inputQuantidade'];
    $consulta = "INSERT INTO `Lote`(`nome`, `evento`, `valor`, `quantidade`) VALUES ('$nome', '$idEvento', '$valor', '$quantidade')";
    $msg = executar($consulta);
    if($msg == "Sucesso!"){
        header('Location: index.php?msg='.$msg);
    }else{
        $msg = "Erro ao criar Lote, por favor contate o suporte!!<br>";
        echo $consulta;
    }
?>