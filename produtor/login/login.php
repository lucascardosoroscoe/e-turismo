<form id="dados" action="Dashboard.php" method="post">
<?php

include('../includes/db_valores.php');

$conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);

$usuario = $_POST['usuario'];
$senha = $_POST['senha'];

$consulta = "select validade from Produtor where usuario='$usuario' and senha='$senha' ";

$gravacoes = mysqli_query($conexao, $consulta);

$dados = array();

while($linha = mysqli_fetch_assoc($gravacoes))
{
    $dados[] = $linha; 
}
//echo json_encode ($dados);
$first = $dados[0];
$validade = $first['validade'];


if ($validade == "VALIDO"){
    session_start();
    $_SESSION["usuario"]=$usuario;
    $_SESSION["validade"]=$validade;0
    echo $usuario;
    //header('Location: ../index.php');
} elseif ($validade == "INVALIDO") {
    echo  "<h1>Usuário Invalidado, contate nosso suporte (67)99965-4445</h1>";
} else {
    //header('Location: ../login/');
}

mysqli_close($conexao);

?>