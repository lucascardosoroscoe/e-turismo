<?php

include('../includes/db_valores.php');
session_start();
/*session created*/
$produtor  =  $_SESSION["usuario"];
$validade =  $_SESSION["validade"];

if ($validade == "VALIDO"){
$conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);

$consulta = "SELECT * FROM Evento WHERE produtor='$produtor'";

$gravacoes = mysqli_query($conexao, $consulta);

$dados = array();

while($linha = mysqli_fetch_assoc($gravacoes))
{
    $dados[] = $linha; 
}

mysqli_close($conexao);
} else {
    header('Location: https://ingressozapp.com/produtor/login/');
}

?>
