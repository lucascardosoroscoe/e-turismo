<?php

include('../includes/db_valores.php');
session_start();
/*session created*/
$produtor  =  $_SESSION["usuario"];
$validade =  $_SESSION["validade"];

if ($validade == "VALIDO"){

} else {
    header('Location: https://ingressozapp.com/produtor/login/');
}
function selecionar($consulta){
    global $servidor, $usuario, $senha, $bdados;
    $conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
    $gravacoes = mysqli_query($conexao, $consulta);
    $dados = array();

    while($linha = mysqli_fetch_assoc($gravacoes))
    {
        $dados[] = $linha; 
    }

    mysqli_close($conexao);

    return $dados;
}


function addEvento($evento){
    global $produtor;
    $consulta = "SELECT * FROM Evento WHERE produtor='$produtor'";

    $dados = selecionar($consulta);
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
