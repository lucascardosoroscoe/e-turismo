<?php
    include('../../includes/verificarAcesso.php');
    verificarAcesso(1);
    

    $id = $_GET['id'];
    $consulta = "UPDATE `Ingresso` SET `validade`='USADO' WHERE `codigo` = '$id'";
    $msg = executar($consulta);

    header('Location: index.php?msg='.$msg);
?>