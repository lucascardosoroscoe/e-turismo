<?php
include('../includes/bancoDados.php');
    $idProdutor = $_POST['idProdutor'];
    $vendedor = $_POST['vendedor'];
    $consulta = "INSERT INTO `ProdutorVendedor`(`idProdutor`, `idVendedor`) VALUES ('$idProdutor', '$vendedor')";
    $msg = executar($consulta);
    header('Location: index.php?msg=' . $msg);
?>