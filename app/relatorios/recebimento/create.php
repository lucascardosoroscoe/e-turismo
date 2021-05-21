<?php
    include('../../includes/verificarAcesso.php');
    verificarAcesso(2);
    $valor   = $_POST['inputValor'];
    $data = date('d/m/Y');
    $consulta = "INSERT INTO `Recebidos`(`vendedor`, `evento`, `valor`, `data`) VALUES ('$idVendedor', '$idEvento', '$valor', '$data')";
    $msg = executar($consulta);
    if($msg != "Sucesso!"){
            $msg = "Erro ao criar Recebimento, por favor contate o suporte!!";
            echo $msg;
            echo "<br>Erro: ". $consulta;
    }else{
        header('Location: index.php?msg='.$msg);
    }
?>