<?php
    include('../includes/verificarAcesso.php');
    verificarAcesso(2);
    
    $categoria = $_POST['categoria'];
    $inputDescricao   = $_POST['inputDescricao'];
    $inputValor        = $_POST['inputValor'];
    
    $valor = substr($inputValor, 0, -3);
    $centavos = substr($inputValor, -2);
    $inputValor = $valor . '.' . $centavos;
    $status        = $_POST['status'];

    $consulta = "INSERT INTO `Custos`(`evento`, `categoria`, `descricao`, `valor`, `status`) VALUES ('$idEvento', '$categoria', '$inputDescricao', '$inputValor', '$status')";
    $msg = executar($consulta);
    if($msg != "Sucesso!"){
        $msg = "Erro ao criar Vendedor, por favor contate o suporte!!";
    }else{
        header('Location: index.php?msg='.$msg);

    }

?>