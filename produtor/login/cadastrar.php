<?php

     include('../includes/db_valores.php');

     $conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);

     $user  = $_POST['usuario'];
     $pass  = $_POST['senha'];
     $nome  = $_POST['nome'];
     $telefone   = $_POST['telefone'];
     $email  = $_POST['email'];
     $cidade   = $_POST['cidade'];
     $estado  = $_POST['estado'];
    
     $consulta = "SELECT * FROM Produtor WHERE usuario='$user'";
     $gravacoes = mysqli_query($conexao, $consulta);
     $dados = array();
     while($linha = mysqli_fetch_assoc($gravacoes)){
         $dados[] = $linha; 
     }
     mysqli_close($conexao);
     echo json_encode($dados);
     $act= $dados[0];

     if (empty ($act)){
          echo "Usuário novo <br>";
          $conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
          $consulta = "insert into Produtor (usuario, senha, nome, telefone, email, cidade, estado, quantidade, pagos ) values ('$user','$pass','$nome','$telefone','$email', '$cidade','$estado', 0, 1 )";
          echo $consulta;
          if(mysqli_query($conexao, $consulta)){
            $validade = "VALIDO";
            echo "successo!";
            session_start();
            $_SESSION["usuario"]=$usuario;
            $_SESSION["validade"]=$validade;
            header('Location: https://ingressozapp.com/produtor');
          }else{
            $msg = "Erro ao cadastrar usuário";
            header('Location: cadastro.php?msg='.$msg);
          }
          mysqli_close($conexao);     
     }else{
         $msg = "Usuário já cadastrado, tente um novo Usuário";
         header('Location: cadastro.php?msg='.$msg);
     }

     
?>