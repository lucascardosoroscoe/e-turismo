<?php
include('../includes/verificarAcesso.php');
verificarAcesso(3);
$msg = $_GET['msg'];
$u = $_GET['u'];
$_SESSION["msg"] = $msg;
header('Location: '. $u);

?>