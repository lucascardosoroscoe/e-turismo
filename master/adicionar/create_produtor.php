<?php
session_start();
/*session created*/
$produtor  =  $_SESSION["usuario"];
$validade =  $_SESSION["validade"];

if ($validade == "VALIDO"){
     include('../includes/db_valores.php');

     $conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
          


     $user  = $_GET['usuario'];
     $pass  = $_GET['senha'];
     $nome  = $_GET['nome'];
     $telefone   = $_GET['telefone'];
     $email  = $_GET['email'];
     $cidade   = $_GET['cidade'];
     $estado  = $_GET['estado'];

     $consulta = "SELECT * FROM Produtor WHERE usuario='$user'";
     $gravacoes = mysqli_query($conexao, $consulta);
     $dados = array();
     while($linha = mysqli_fetch_assoc($gravacoes)){
         $dados[] = $linha; 
     }
     $act= $dados[0];
     if (empty ($dados)){
          $consulta = "insert into Produtor (usuario, senha, nome, telefone, email, cidade, estado ) values ('$user','$pass','$nome','$telefone','$email', '$cidade','$estado' )";
     }else{
          $msg = "Usuário já cadastrado, tente um novo Usuário";
          header('Location: produtor.php?msg='.$msg);
     }

     mysqli_close($conexao);

     $conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
     if(mysqli_query($conexao, $consulta))
     {
          echo "successo!";
          header('Location: ../index.php');
     }
     else
     {
          $msg = "Não é possível cadastrar um usuario que já existe";
          header('Location: vendedor.php?msg='.$msg);
     }

     mysqli_close($conexao);
}else {
     header('Location: https://ingressozapp.com/produtor/login/');
}

?>