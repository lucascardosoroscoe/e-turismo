<?php

include('../includes/db_valores.php');

$conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
	
$usuario  = $_GET['usuario'];

$consulta = "update Produtor set validade = 'VALIDO' where usuario = '$usuario'";

if(mysqli_query($conexao, $consulta))
{
     echo "successo!";
     header('Location: ../visualizar/produtor.php');
}
else
{
     echo "Falha ao validar produtor";
}

mysqli_close($conexao);

?>