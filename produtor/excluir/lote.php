<?php

include('../includes/db_valores.php');

$conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
	

$nome        = $_GET['nome'];
$evento        = $_GET['evento'];
$consulta = "delete from Lote  where nome = '$nome' AND evento = '$evento' ";
if(mysqli_query($conexao, $consulta))
{
     echo "successo!";
     header('Location: ../lote/visualizar.php?evento='.$evento);
}
else
{
     echo "Falha ao invalidar Evento";
}

mysqli_close($conexao);

?>