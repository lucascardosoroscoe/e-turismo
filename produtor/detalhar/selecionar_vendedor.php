<?php

include('../includes/db_valores.php');
session_start();
/*session created*/
$produtor  =  $_SESSION["usuario"];
$validade =  $_SESSION["validade"];
$nom = $_GET["usuario"];

if ($validade == "VALIDO"){
$conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
	
$consulta = "SELECT * FROM Vendedor WHERE produtor='$produtor' AND usuario = '$nom'";
$gravacoes = mysqli_query($conexao, $consulta);

$dados = array();

while($linha = mysqli_fetch_assoc($gravacoes))
{
    $dados[] = $linha; 
}
$obj = $dados[0];
mysqli_close($conexao);
} else {
    header('Location: http://arkun.com.br/apk/login/');
}

?>