<?php
include('../includes/db_valores.php');

session_start();
/*session created*/
$produtor  =  $_SESSION["usuario"];
$validade =  $_SESSION["validade"];

if ($validade == "VALIDO"){

     $nome        = $_POST['nome'];
     $nome = str_replace(" ", "_", $nome);
     $produtor    = $_POST['produtor'];
     $imagem      = $_FILES["imagem"];
     $descricao   = $_POST['descricao'];
     $data        = $_POST['data'];
     if($imagem != NULL) { 
          $nomeFinal = time().'.jpg';
          if (move_uploaded_file($imagem['tmp_name'], $nomeFinal)) {
              $tamanhoImg = filesize($nomeFinal); 
       
              $mysqlImg = addslashes(fread(fopen($nomeFinal, "r"), $tamanhoImg)); 
          }
     }

     $conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
          

     

     $consulta = "insert into Evento (nome, produtor, imagem, data, descricao) values ('$nome', '$produtor', '$mysqlImg', '$data', '$descricao')";
     //echo "insert into Evento (nome, produtor, imagem, data, descricao) values ('$nome', '$produtor', '$mysqlImg', '$data', '$descricao')";
     if(mysqli_query($conexao, $consulta)){
          echo "successo!";
          header('Location: ../lote/visualizar.php?evento='.$nome);
     }
     else
     {
          echo "erro";
          header('Location: ../lote/visualizar.php?evento='.$nome);

     }

     mysqli_close($conexao);
}else{
     header('Location: https://ingressozapp.com/produtor/login/');
}

?>