<?php

include('../includes/db_valores.php');

$conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
	

$id        = $_GET['id'];
$consulta = "UPDATE `Custos` SET `status`= '3' WHERE `id` = '$id'";
echo $consulta;
if(mysqli_query($conexao, $consulta))
{
     echo "successo!";
     header('Location: ../custos/');
}
else
{
     echo "Falha ao invalidar Evento";
}

mysqli_close($conexao);

?>