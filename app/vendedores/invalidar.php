<?php
    include('../includes/verificarAcesso.php');
    verificarAcesso(2);
    

    $id = $_GET['id'];
    $consulta = "DELETE FROM `ProdutorVendedor` WHERE `idProdutor` = '$idUsuario' AND `idVendedor` = $id";
    $msg = executar($consulta);

    header('Location: index.php?msg='.$msg);
?>