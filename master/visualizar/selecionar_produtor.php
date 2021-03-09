<?php

include('../includes/db_valores.php');
session_start();
/*session created*/
$produtor  =  $_SESSION["usuario"];
$login =  $_SESSION["login"];

if ($login == "VALIDO"){
$conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
	

$consulta = "SELECT * FROM Produtor";

$gravacoes = mysqli_query($conexao, $consulta);

$dados = array();

while($linha = mysqli_fetch_assoc($gravacoes))
{
    $dados[] = $linha; 
}

mysqli_close($conexao);
} else {
    header('Location: http://arkun.com.br/apk/login/');
}

?>