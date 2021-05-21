<?php
    include('../includes/verificarAcesso.php');
    verificarAcesso(2);
    
    $categoria = $_POST['categoria'];
    $inputDescricao   = $_POST['inputDescricao'];
    $inputValor        = $_POST['inputValor'];
    $status        = $_POST['status'];

    $consulta = "INSERT INTO `Custos`(`evento`, `categoria`, `descricao`, `valor`, `status`) VALUES ('$idEvento', '$categoria', '$inputDescricao', '$inputValor', '$status')";
    $msg = executar($consulta);
    if($msg != "Sucesso!"){
        $msg = "Erro ao criar Vendedor, por favor contate o suporte!!";
    }else{
        header('Location: index.php?msg='.$msg);
    }

?>