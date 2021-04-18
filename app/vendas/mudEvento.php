
<?php

$idEvento = $_GET["evento"];
session_start();
$_SESSION["idEvento"] = $idEvento;
header('Location: index.php');
?>

