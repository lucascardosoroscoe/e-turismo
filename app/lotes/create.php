<?php
    include('../includes/verificarAcesso.php');
    verificarAcesso(2);
    include('../includes/bancoDados.php');
    
    $nome = $_POST['inputName'];
    $valor   = $_POST['inputValor'];
    $quantidade        = $_POST['inputQuantidade'];
    if($imagem != NULL) { 
        $nomeFinal = time().'.jpg';
        if (move_uploaded_file($imagem['tmp_name'], $nomeFinal)) {
            $tamanhoImg = filesize($nomeFinal); 
     
            $mysqlImg = addslashes(fread(fopen($nomeFinal, "r"), $tamanhoImg)); 
        }
    }
    $consulta = "INSERT INTO `Lote`(`nome`, `evento`, `valor`, `quantidade`) VALUES ('$nome', '$idEvento', '$valor', '$quantidade')";
    $msg = executar($consulta);
    if($msg != "Sucesso!"){
            $msg = "Erro ao criar Vendedor, por favor contate o suporte!!";
    }
    header('Location: index.php?msg='.$msg);
?>