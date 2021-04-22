<?php

include('../includes/db_valores.php');

$conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
	

$nome        = $_GET['nome'];
$evento        = $_GET['evento'];
$consulta = "update Lote set validade = 'DISPONÍVEL' where nome = '$nome' AND evento = '$evento'";
//echo $consulta;
if(mysqli_query($conexao, $consulta))
{
     echo "successo!";
     header('Location: ../lote/visualizar.php?evento='.$evento);
}
else
{
     echo "Falha ao validar Evento";
}

mysqli_close($conexao);

?>
