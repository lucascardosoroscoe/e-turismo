<?php

include('../includes/db_valores.php');

$conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
	

$nome        = $_GET['nome'];
$consulta = "update Evento set validade = 'INVALIDO' where nome = '$nome'";
if(mysqli_query($conexao, $consulta))
{
     echo "successo!";
     header('Location: ../visualizar/evento.php');
}
else
{
     echo "Falha ao invalidar Evento";
}

mysqli_close($conexao);

?>