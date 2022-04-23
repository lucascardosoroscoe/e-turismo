<?php
    include('../includes/verificarAcesso.php');
    verificarAcesso(2);
    $nCaixa = $_POST['selectCaixa'];
    $id = $_POST['id'];
    echo $selectCaixa;
    $_SESSION["nCaixa"] = $nCaixa;
    header('Location: http://ingressozapp.com/app/caixa/index.php?id=' . $id);
?>