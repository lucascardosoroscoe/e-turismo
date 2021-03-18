<?php
include('../includes/verificarAcesso.php');
verificarAcesso(3);
$idLote = $_GET['idLote'];
$u = $_GET['u'];
$_SESSION["idLote"] = $idLote;
header('Location: '. $u);

?>