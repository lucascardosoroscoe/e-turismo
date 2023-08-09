<?php
    session_start();
    /*session created*/
    $produtor = $_SESSION["usuario"];
    include_once '../../includes/header.php';

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

        criarProduto();

    function criarProduto(){
        global $idImagem, $produtor, $categoria, $nome, $valor, $estoque;
        $consulta = "INSERT INTO `Produto`(`usuario`, `idImagem`, `categoria`, `nome`, `valor`, `estoque`) VALUES  ('$produtor', '$idImagem', '$categoria', '$nome', '$valor', '$estoque')";
        echo $consulta;
        $msg = executar($consulta);
        echo $msg;
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