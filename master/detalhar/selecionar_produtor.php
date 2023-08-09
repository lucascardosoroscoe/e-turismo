<?php

include('../includes/db_valores.php');
session_start();
/*session created*/
$validade =  $_SESSION["login"];
$user = $_GET["usuario"];

if ($validade == "VALIDO"){
$conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
	
$consulta = "SELECT * FROM Produtor WHERE  usuario = '$user'";
$gravacoes = mysqli_query($conexao, $consulta);

$dados = array();

while($linha = mysqli_fetch_assoc($gravacoes))
{
    $dados[] = $linha; 
}
$obj = $dados[0];
mysqli_close($conexao);
} else {
    header('Location: https://ingressozapp.com/master/login/');
}

?>