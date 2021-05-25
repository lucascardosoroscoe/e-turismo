<?php
    include('../includes/verificarAcesso.php');
    verificarAcesso(2);
    
    
    $nome = $_POST['inputName'];
    $consulta = "INSERT INTO `Caixa` (`idProdutor`, `nome`) VALUES ('$idUsuario', '$nome')";
    $msg = executar($consulta);
    if($msg == "Sucesso!"){
        header('Location: index.php?msg='.$msg);
    }else{
        $msg = "Erro ao criar Vendedor, por favor contate o suporte!!";
        echo $msg;
    }
    
    
?>