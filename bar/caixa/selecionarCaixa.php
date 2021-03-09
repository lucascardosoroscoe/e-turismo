<?php
    $nCaixa = $_GET['nCaixa'];
    $id = $_GET['id'];
    session_start();
    $_SESSION["nCaixa"]=$nCaixa;
    echo $_SESSION["nCaixa"];
    header('Location: https://ingressozapp.com/bar/caixa/index.php?id=' . $id);
?>