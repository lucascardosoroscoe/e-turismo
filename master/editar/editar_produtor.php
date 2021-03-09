<?php

include('../includes/db_valores.php');

$conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
	

$usuarioa      = $_GET['usuarioa'];
$usuario      = $_GET['usuario'];
$pass      = $_GET['senha'];
$nome   = $_GET['nome'];
$telefone     = $_GET['telefone'];
$email     = $_GET['email'];
$cidade     = $_GET['cidade'];
$estado     = $_GET['estado'];

$consulta = "update Produtor set usuario = '$usuario', senha = '$pass',nome = '$nome', telefone = '$telefone', email = '$email',cidade = '$cidade', estado = '$estado' where usuario = '$usuarioa'";

if(mysqli_query($conexao, $consulta))
{
     echo "successo!";
     header('Location: ../index.php');
}
else
{
     echo "Falha ao editar Produtor";
}

mysqli_close($conexao);

?>