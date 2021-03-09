<?php
include('../includes/db_valores.php');

session_start();
/*session created*/
$promoter  =  $_SESSION["promoter"];
$evento =  $_SESSION["evento"];
$validade =  $_SESSION["validade"];

if ($validade == "VALIDO"){

     $valor   = $_POST['valor'];
     $data = date('d/m/Y');

     $conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
     $consulta = "INSERT INTO `Recebidos`(`vendedor`, `evento`, `valor`, `data`) VALUES ('$promoter', '$evento', '$valor', '$data')";
     //echo "insert into Evento (nome, produtor, imagem, data, descricao) values ('$nome', '$produtor', '$mysqlImg', '$data', '$descricao')";
     if(mysqli_query($conexao, $consulta)){
          echo "successo!";
          header('Location: index.php');
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