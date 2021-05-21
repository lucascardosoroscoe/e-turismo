<?php
    include('../includes/verificarAcesso.php');
    verificarAcesso(2);
    

    $id = $_GET['id'];
    $consulta = "UPDATE `Produto` SET `validade`='VALIDO' WHERE `idProduto` = '$id'";
    $msg = executar($consulta);

    header('Location: index.php?msg='.$msg);
?>