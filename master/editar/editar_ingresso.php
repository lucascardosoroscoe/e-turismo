<?php

include('../includes/db_valores.php');

$conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
	
     $codigo        = $_GET['codigo'];
     $evento        = $_GET['evento'];
     $vendedor        = $_GET['vendedor'];
     $cliente        = $_GET['cliente'];
     $telefone        = $_GET['telefone'];
     $valor        = $_GET['valor'];
     $lote        = $_GET['lote'];
     $sexo        = $_GET['sexo'];

$consulta = "update Ingresso set evento = '$evento', vendedor = '$vendedor', cliente = '$cliente', telefone = '$telefone', valor = '$valor', lote = '$lote', sexo = '$sexo' where codigo = '$codigo'";

if(mysqli_query($conexao, $consulta))
{
     echo "successo!";
     header('Location: ../index.php');
}
else
{
     echo "Falha ao editar produtor";
}

mysqli_close($conexao);

?>