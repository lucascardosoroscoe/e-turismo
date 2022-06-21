<?php
    include('../includes/verificarAcesso.php');
    verificarAcesso(2);
    $selectEvento = $_POST['selectEvento'];
    $selectProdutor = $_POST['selectProdutor'];
    $consulta = "SELECT * FROM Evento WHERE `produtor` = '$idUsuario' AND `id` = '$selectEvento'";
    $dados = selecionar($consulta);
    $selectEvento = $dados[0]['id'];
    $consulta = "INSERT INTO `Coprodutor`(`idProdutor`, `idEvento`) VALUES ('$selectProdutor','$selectEvento')";
    $msg = executar($consulta);
    header('Location: coprodutor.php');
?>