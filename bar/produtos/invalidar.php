<?php
    
    session_start();
    /*session created*/
    $idProdutor = $_SESSION["usuario"];

    include_once '../../includes/header.php';

        $id = $_GET["id"];
        $consulta = "UPDATE `Produto` SET `validade` = 'INVALIDO' WHERE `idProduto` = $id";
        $msg = executar($consulta);

        header('Location: index.php?msg='.$msg);
?>