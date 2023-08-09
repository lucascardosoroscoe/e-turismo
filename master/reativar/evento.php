<?php

include('../includes/db_valores.php');

$conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
	

$cont        = $_GET['nome'];
$consulta = "update Evento set validade = 'VALIDO' where nome = '$cont'";
if(mysqli_query($conexao, $consulta))
{
     echo "successo!";
     header('Location: ../visualizar/evento.php');
}
else
{
     echo "Falha ao validar Evento";
}

mysqli_close($conexao);

?>