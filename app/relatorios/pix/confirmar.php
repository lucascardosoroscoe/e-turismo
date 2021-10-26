<?php
    include('../../includes/verificarAcesso.php');
    verificarAcesso(2);
    $id = $_GET['id'];


    $consulta = "UPDATE `wp_wc_order_stats` SET `status`='wc-completed' WHERE `order_id`='$id'";
    $msg = executar($consulta);
    if($msg == "Sucesso!"){
        header('Location: index.php?msg='.$msg);
    }

?>