<?php
    include('../../includes/verificarAcesso.php');
    verificarAcesso(2);
    

    $id = $_POST['codigo'];
    $selectMotivo = $_POST['selectMotivo'];
    $motivoInvalidar = "Ingresso cancelado por " . $usuario . ", motivo: " . $selectMotivo;
    $consulta = "UPDATE `Ingresso` SET `validade`='CANCELADO', `motivoInvalidar`='$motivoInvalidar' WHERE `codigo` = '$id'";
    echo $consulta;
    $msg = executar($consulta);
    $consulta = "UPDATE `Lote` SET `vendidos`=`vendidos` - 1 WHERE `id` = (SELECT lote FROM Ingresso WHERE codigo = '$id')";
    echo $consulta;
    $msg = executar($consulta);


    

    header('Location: index.php?msg='.$msg);

?>