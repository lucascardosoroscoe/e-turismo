<?php
    include('../includes/verificarAcesso.php');
    verificarAcesso(2);
    include('../includes/trello.php');

    $produtor = $idUsuario;
    $consulta = "SELECT * FROM `Produtor` WHERE id = '$produtor'";
    $dados = selecionar($consulta);
    $nomeProdutor = $dados[0]['nome'];
    $telefoneProdutor = $dados[0]['telefone'];
    $cidadeProdutor = $dados[0]['cidade'];
    $estadoProdutor = $dados[0]['estado'];
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
    $consulta = "SELECT id FROM Evento WHERE nome = '$nome' AND produtor = '$produtor' AND data = '$data' AND descricao = '$descricao'";
    $dados = selecionar($consulta);
    $idEvento = $dados[0]['id'];
    $nomeCard = $nomeProdutor . " - " . $nome . ' (' . $cidadeProdutor . '-' . $estadoProdutor . ')';
    $descricaoCard = "
        telefone: $telefoneProdutor \n
        descrição do Evento: $descricao
        imagem: ingressozapp.com/app/getImagem.php?id=$idEvento
    "; 
    criarCard($nomeCard, $descricaoCard, $data, $idListaEventoCadastrado);
    header('Location: index.php?msg='.$msg);
?>