<?php
    include('../includes/verificarAcesso.php');
    verificarAcesso(2);
    

    $id = $_GET['id'];
    $consulta = "UPDATE `Lote` SET `validade`='DISPONÍVEL' WHERE `id` = '$id'";
    $msg = executar($consulta);

    header('Location: index.php?msg='.$msg);
?>