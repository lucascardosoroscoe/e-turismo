
<?php

$evento = $_GET["evento"];
echo $evento;
session_start();
$_SESSION["evento"] = $evento;
header('Location: visualizar.php');
?>

