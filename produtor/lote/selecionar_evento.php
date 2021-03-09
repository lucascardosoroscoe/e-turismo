<?php

include('../includes/db_valores.php');
session_start();
/*session created*/
$produtor  =  $_SESSION["usuario"];
$validade =  $_SESSION["validade"];

if ($validade == "VALIDO"){
$conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);

$consulta = "SELECT * FROM Evento WHERE produtor='$produtor'";

$gravacoes = mysqli_query($conexao, $consulta);

$dados2 = array();

while($linha = mysqli_fetch_assoc($gravacoes))
{
    $dados2[] = $linha; 
}

mysqli_close($conexao);
} else {
    header('Location: https://ingressozapp.com/produtor/login/');
}

function addEvento($dados, $evento){
    $size = sizeof($dados);
    for ($i = 0; $i < $size; $i++){
        $obj = $dados[$i];
        //echo json_encode($primeiro);
        //echo "<br>";
        $nome = $obj['nome'];
        if ($nome == $evento){
            echo ('<option value="'.$nome.'" selected>'.$nome.'</option>');
        }else{
            echo ('<option value="'.$nome.'">'.$nome.'</option>');
        }
    }
}
?>
