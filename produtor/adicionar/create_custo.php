<?php
include('../includes/db_valores.php');

session_start();
/*session created*/
$produtor  =  $_SESSION["usuario"];
$validade =  $_SESSION["validade"];
$evento =  $_SESSION["evento"];

if ($validade == "VALIDO"){

     $categoria   = $_POST['categoria'];
     echo $categoria;
     $produtor    = $_POST['produtor'];
     $descricao   = $_POST['descricao'];
     $valor        = $_POST['valor'];
     $status        = $_POST['status'];

     $conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
     $consulta = "INSERT INTO `Custos`(`evento`, `categoria`, `descricao`, `valor`, `status`) VALUES ('$evento', '$categoria', '$descricao', '$valor', '$status')";
     //echo "insert into Evento (nome, produtor, imagem, data, descricao) values ('$nome', '$produtor', '$mysqlImg', '$data', '$descricao')";
     if(mysqli_query($conexao, $consulta)){
          echo "successo!";
          header('Location: ../custos/');
     }
     else
     {
          echo $consulta;
     }

     mysqli_close($conexao);
}else{
     header('Location: https://ingressozapp.com/produtor/login/');
}

?>