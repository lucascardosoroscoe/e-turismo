<?php

include('../includes/db_valores.php');
session_start();
/*session created*/
$produtor  =  $_SESSION["usuario"];
$validade =  $_SESSION["validade"];

if ($validade == "VALIDO"){
$conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);

$consulta = "SELECT * FROM Categorias ORDER BY categoria";

$gravacoes = mysqli_query($conexao, $consulta);

$dados = array();

while($linha = mysqli_fetch_assoc($gravacoes))
{
    $dados[] = $linha; 
}

mysqli_close($conexao);
} else {
    header('Location: https://ingressozapp.com/produtor/login/');
}


function addCategoria($dados){
    $size = sizeof($dados);
    echo ('<option value="">Selecione a Categoria</option>');
    for ($i = 0; $i < $size; $i++){
        $obj = $dados[$i];
        $id = $obj['id'];
        $categoria = $obj['categoria'];
        echo ('<option value="'.$id.'">'.$categoria.'</option>');
    }
    echo('</select>');
    echo('</br>');
   
}
?>
