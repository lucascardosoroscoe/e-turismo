<?php
    include('../includes/verificarAcesso.php');
    verificarAcesso(2);
    include('../includes/bancoDados.php');

    $id = $_GET['id'];
    $consulta = "UPDATE `Lote` SET `validade`='ESGOTADO' WHERE `id` = '$id'";
    $msg = executar($consulta);

    header('Location: index.php?msg='.$msg);
?>