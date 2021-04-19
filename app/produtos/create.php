<?php
    include('../includes/verificarAcesso.php');
    verificarAcesso(1);
    
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
            echo $idImagem;
        }
    }

    criarProduto();

    function criarProduto(){
        global $idImagem, $idUsuario, $categoria, $nome, $valor, $estoque;
        $consulta = "INSERT INTO `Produto`(`usuario`, `idImagem`, `categoria`, `nome`, `valor`, `estoque`) VALUES  ('$idUsuario', '$idImagem', '$categoria', '$nome', '$valor', '$estoque')";
        echo $consulta;
        $msg = executar($consulta);
        echo $msg;
        header('Location: index.php?msg='.$msg);
    }
    function addImagem($imagem){
        $consulta = "INSERT INTO `Imagem` (`imagem`) VALUES ('$imagem')";
        echo $consulta;
        $msg = executar($consulta);
        $consulta = "SELECT MAX(`idImagem`)FROM Imagem";
        $dados = selecionar($consulta);
        $first = $dados[0];
        $idImagem = $first['MAX(`idImagem`)'];
        return $idImagem;
    }

?>