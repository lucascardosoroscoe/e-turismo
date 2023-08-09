<?php
    session_start();
    /*session created*/
    $idProdutor = $_SESSION["usuario"];
    include_once '../../includes/header.php';

        $nome = $_POST['nome'];
        $idProduto = $_POST['idProduto'];
        $valor = $_POST['valor'];
        $categoria = $_POST['categoria'];
        $estoque = $_POST['estoque'];
        $imagem = $_FILES['imagem'];

        $idImagem = 0;
        if($imagem != NULL) { 
            $nomeFinal = time().'.jpg';
            if (move_uploaded_file($imagem['tmp_name'], $nomeFinal)) {
                $tamanhoImg = filesize($nomeFinal); 

                $imagem = addslashes(fread(fopen($nomeFinal, "r"), $tamanhoImg)); 
                $idImagem = addImagem($imagem);
            }
        }
        editarProduto();

    


    function editarProduto(){
        global $idImagem, $nome, $categoria, $valor, $idProduto, $estoque;
        if ($idImagem != 0){
        $consulta = "UPDATE `Produto` SET `categoria`='$categoria', `nome`='$nome', `valor`='$valor', `idImagem`='$idImagem', `estoque`='$estoque'  WHERE `idProduto`='$idProduto'";
        }else{
            $consulta = "UPDATE `Produto` SET `categoria`='$categoria', `nome`='$nome', `valor`='$valor', `estoque`='$estoque'  WHERE `idProduto`='$idProduto'";
        }
        echo $consulta;
        $msg = executar($consulta);
        $msg = "Dados Atualizados com ".$msg;
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