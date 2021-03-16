<?php
include('../includes/verificarAcesso.php');
verificarAcesso(3);
$nomeEvento = $_GET['nomeEvento'];
$idEvento = $_GET['idEvento'];
$u = $_GET['u'];
$_SESSION["nomeEvento"] = $nomeEvento;
$_SESSION["idEvento"] = $idEvento;
header('Location: '. $u);

?>