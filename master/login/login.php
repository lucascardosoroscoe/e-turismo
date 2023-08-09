<form id="dados" action="Dashboard.php" method="post">
<?php

$usuario = $_POST['usuario'];
$senha = $_POST['senha'];


if ($usuario == "Roscoe" && $senha == "1234"){
    session_start();
    $_SESSION["usuario"]=$usuario;
    $_SESSION["login"]= "VALIDO";
    header('Location: https://ingressozapp.com/master');
}else{
    echo  "<h1>Usuário Invalidado, contate nosso suporte (67)99965-4445</h1>";
}
?>