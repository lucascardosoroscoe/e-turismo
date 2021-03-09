
<?php

$promoter = $_GET["promoter"];
echo $evento;
session_start();
$_SESSION["promoter"] = $promoter;
header('Location: index.php');
?>

