<?php

include('../includes/db_valores.php');

$conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
	

$nome        = $_POST['nome'];
$produtor    = $_POST['produtor'];
$imagem     = $_FILES['imagem'];
$data  = $_POST['data'];
$descricao        = $_POST['descricao'];

if($imagem != NULL) { 
     $nomeFinal = time().'.jpg';
     if (move_uploaded_file($imagem['tmp_name'], $nomeFinal)) {
         $tamanhoImg = filesize($nomeFinal); 
  
         $mysqlImg = addslashes(fread(fopen($nomeFinal, "r"), $tamanhoImg)); 
     }
     $consulta = "update Evento set imagem = '$mysqlImg', data = '$data', descricao = '$descricao' where nome = '$nome'";
}else{
     $consulta = "update Evento set data = '$data', descricao = '$descricao' where nome = '$nome'";
}


if(mysqli_query($conexao, $consulta))
{
     echo "successo!";
     header('Location: ../index.php');
}
else
{
     echo "Falha ao editar Pedido";
     header('Location: ../index.php');
}

mysqli_close($conexao);

?>