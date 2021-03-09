<?php

include('../includes/db_valores.php');

$conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
	
$usuario  = $_GET['usuario'];

$consulta = "update Vendedor set validade = 'INVALIDO' where usuario = '$usuario'";

if(mysqli_query($conexao, $consulta))
{
     echo "successo!";
     header('Location: ../visualizar/vendedor.php');
}
else
{
     echo "Falha ao invalidar Vendedor";
}

mysqli_close($conexao);

?>