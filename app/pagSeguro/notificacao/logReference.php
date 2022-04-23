<?php
    include('../../includes/verificarAcesso.php');
    $consulta = "SELECT * FROM `PagSeguroRetornoLog` WHERE 1";
    $dados = selecionar($consulta);
    foreach ($dados as $log) {
        $id = $log['id'];
        $reference = $log['reference'];
        $status = $log['status'];
        $consulta = "UPDATE `PedidoPagSeguro` SET `status`='$status' WHERE `reference` = '$reference'";
        $msg = executar($consulta);
    }

?>