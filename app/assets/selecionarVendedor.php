<?php
include('../includes/verificarAcesso.php');
verificarAcesso(3);
$nomeVendedor = $_GET['nomeVendedor'];
$idVendedor = $_GET['idVendedor'];
$u = $_GET['u'];
$_SESSION["nomeVendedor"] = $nomeVendedor;
$_SESSION["idVendedor"] = $idVendedor;
echo $_SESSION["nomeVendedor"];
echo $_SESSION["idVendedor"];
header('Location: '. $u);

?>