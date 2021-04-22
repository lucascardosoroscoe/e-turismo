<?php

include('../includes/db_valores.php');

$conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
	


$usuario      = $_GET['usuario'];
$nome   = $_GET['nome'];
$telefone     = $_GET['telefone'];
$email     = $_GET['email'];

$consulta = "update Vendedor set nome = '$nome', telefone = '$telefone', email = '$email' where usuario = '$usuario'";

if(mysqli_query($conexao, $consulta))
{
     echo "successo!";
     header('Location: ../index.php');
}
else
{
     echo "Falha ao editar Produto";
}

mysqli_close($conexao);

?>