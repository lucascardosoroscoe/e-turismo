<?php
include('../includes/db_valores.php');

$conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);

$user = $_POST['usuario'];
$senha = $_POST['senha'];
$password = $_POST['senhav'];

$consulta = "UPDATE Vendedor SET senha = '$senha' WHERE  (`usuario` = '$user' AND `senha` = '$password') OR (`email` = '$user' AND `senha` = '$password')";

if(mysqli_query($conexao, $consulta))
{
     echo "successo!";
     header('Location: index.php?msg=Senha%20alterada%20com%20sucesso!!!');
}
else
{
     echo "Falha ao editar Produto";
}

mysqli_close($conexao);

?>