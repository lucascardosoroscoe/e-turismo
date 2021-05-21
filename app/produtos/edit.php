<?php
    include('../includes/verificarAcesso.php');
    verificarAcesso(2);
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $valor = $_POST['valor'];
    $categoria = $_POST['categoria'];
    $estoque = $_POST['estoque'];
    $idImagem = $_POST['idImagem'];
    $imagem = $_FILES['imagem'];

    if($imagem != NULL) { 
        $nomeFinal = time().'.jpg';
        if (move_uploaded_file($imagem['tmp_name'], $nomeFinal)) {
            $tamanhoImg = filesize($nomeFinal); 

            $imagem = addslashes(fread(fopen($nomeFinal, "r"), $tamanhoImg)); 
            $idImagem = editImagem($idImagem, $imagem);
        }
    }

    $consulta = "UPDATE `Produto` SET `categoria`='$categoria',`nome`='$nome',`valor`='$valor',`estoque`='$estoque' WHERE `idProduto` = '$id'";
    $msg = executar($consulta);
    if($msg == "Sucesso!"){
        header('Location: index.php?msg='.$msg);
    }

    function editImagem($idImagem, $imagem){
        $consulta = "UPDATE `Imagem` SET `imagem`='$imagem' WHERE `idImagem` = '$idImagem'";
        $msg = executar($consulta);
        return $idImagem;
    }
?>