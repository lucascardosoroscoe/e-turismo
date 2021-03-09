<?php

include('../includes/db_valores.php');

$conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
	
$codigo   = $_GET['codigo'];

$consulta = "update Ingresso set validade = 'VALIDO' where codigo = '$codigo'";
if(mysqli_query($conexao, $consulta))
{
     echo "successo!";
     header('Location: ../visualizar/ingresso.php');
}
else
{
     echo "Falha ao validar ingresso";
}

mysqli_close($conexao);

?>