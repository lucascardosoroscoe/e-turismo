<?php
    include('../includes/verificarAcesso.php');
    verificarAcesso(1);
    

    $id = $_GET['id'];
    $consulta = "UPDATE `Produtor` SET `validade`='VALIDO' WHERE `id` = '$id'";
    $msg = executar($consulta);

    header('Location: index.php?msg='.$msg);
?>