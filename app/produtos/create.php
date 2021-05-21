<?php
    include('../includes/verificarAcesso.php');
    verificarAcesso(2);
    
    $nome = $_POST['nome'];
    $valor = $_POST['valor'];
    $categoria = $_POST['categoria'];
    $estoque = $_POST['estoque'];
    $imagem = $_FILES['imagem'];

    if($imagem != NULL) { 
        $nomeFinal = time().'.jpg';
        if (move_uploaded_file($imagem['tmp_name'], $nomeFinal)) {
            $tamanhoImg = filesize($nomeFinal); 

            $imagem = addslashes(fread(fopen($nomeFinal, "r"), $tamanhoImg)); 
            $idImagem = addImagem($imagem);
        }
    }

    $consulta = "INSERT INTO `Produto`(`produtor`, `idImagem`, `categoria`, `nome`, `valor`, `estoque`) VALUES  ('$idUsuario', '$idImagem', '$categoria', '$nome', '$valor', '$estoque')";
    $msg = executar($consulta);
    if($msg == "Sucesso!"){
        header('Location: index.php?msg='.$msg);
    }

    function addImagem($imagem){
        $consulta = "INSERT INTO `Imagem` (`imagem`) VALUES ('$imagem')";
        $msg = executar($consulta);
        $consulta = "SELECT MAX(`idImagem`)FROM Imagem";
        $dados = selecionar($consulta);
        $first = $dados[0];
        $idImagem = $first['MAX(`idImagem`)'];
        return $idImagem;
    }

?>