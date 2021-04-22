<?php

include('../includes/db_valores.php');

$conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
	
     $nomeanterior        = $_GET['nomeanterior'];
     $evento    = $_GET['evento'];
     $nome        = $_GET['nome'];
     $sexo   = $_GET['sexo'];
     $valor        = $_GET['valor'];
     $quantidade        = $_GET['quantidade'];
     
$consulta = "update Lote set nome = '$nome', sexo = '$sexo', valor = '$valor', quantidade = '$quantidade' where nome = '$nomeanterior' and evento = '$evento'";
if(mysqli_query($conexao, $consulta))
{
     echo "successo!";
     header('Location: ../lote/visualizar.php?evento='.$evento);
}
else
{
     echo "Falha ao editar Pedido";
}

mysqli_close($conexao);

?>