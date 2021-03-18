<?php
    include('../includes/verificarAcesso.php');
    verificarAcesso(2);
    

    $id = $_GET['id'];
    $consulta = "UPDATE `Evento` SET `validade`='VALIDO' WHERE `id` = '$id'";
    $msg = executar($consulta);

    header('Location: index.php?msg='.$msg);
?>