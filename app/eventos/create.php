<?php
    include('../includes/verificarAcesso.php');
    verificarAcesso(2);
    

    $produtor = $idUsuario;
    $nome = $_POST['inputName'];
    $imagem      = $_FILES["inputImagem"];
    $descricao   = $_POST['inputDescricao'];
    $data        = $_POST['inputData'];
    if($imagem != NULL) { 
        $nomeFinal = time().'.jpg';
        if (move_uploaded_file($imagem['tmp_name'], $nomeFinal)) {
            $tamanhoImg = filesize($nomeFinal); 
     
            $mysqlImg = addslashes(fread(fopen($nomeFinal, "r"), $tamanhoImg)); 
        }
    }
    $consulta = "insert into Evento (nome, produtor, imagem, data, descricao) values ('$nome', '$produtor', '$mysqlImg', '$data', '$descricao')";
    $msg = executar($consulta);
    if($msg != "Sucesso!"){
            $msg = "Erro ao criar Vendedor, por favor contate o suporte!!";
        
    }
    header('Location: index.php?msg='.$msg);
?>