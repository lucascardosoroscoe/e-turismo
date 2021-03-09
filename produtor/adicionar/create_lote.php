<?php
include('../includes/db_valores.php');

session_start();
/*session created*/
$produtor  =  $_SESSION["usuario"];
$validade =  $_SESSION["validade"];

if ($validade == "VALIDO"){



     
          

     $nome        = $_GET['nome'];
     $evento    = $_GET['evento'];
     $sexo   = $_GET['sexo'];
     $valor        = $_GET['valor'];
     $quantidade        = $_GET['quantidade'];
     $int = 0;

     $conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);

    $consulta = "SELECT * FROM Lote WHERE evento='$evento'";
    $gravacoes = mysqli_query($conexao, $consulta);

    $dados = array();

    while($linha = mysqli_fetch_assoc($gravacoes))
    {
        $dados[] = $linha; 
    }
    $size = sizeof($dados);

    for ($i = 0; $i < $size; $i++){
        $obj = $dados[$i];
        $name = $obj['nome'];
        echo ($nome);
        echo ($name);
        if ($nome == $name){
          $msg = "O lote não foi criado, já existe um lote com esse nome!!!";
          $int = 1;
          header('Location: ../lote/visualizar.php?evento='.$evento.'&msg='.$msg);
        }
    }

    mysqli_close($conexao);
    if ($int == 0){

    
     $conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);

     $consulta = "insert into Lote (nome, produtor, evento, sexo, valor, validade, quantidade) values ('$nome', '$produtor', '$evento','$sexo', '$valor', 'EM BREVE', '$quantidade')";
     if(mysqli_query($conexao, $consulta))
     {
          echo "successo!";
          header('Location: ../lote/visualizar.php?evento='.$evento);
     }
     else
     {
          echo "Erro ao Inserir Ingresso";
     }

     mysqli_close($conexao);
    }
}else{
     header('Location: https://ingressozapp.com/produtor/login/');
}

?>