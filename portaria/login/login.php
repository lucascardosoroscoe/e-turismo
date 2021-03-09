<form id="dados" action="Dashboard.php" method="post">
<?php

include('../../produtor/includes/db_valores.php');
$user = $_GET['usuario'];
$pass = $_GET['senha'];
$codigo = $_GET['codigo'];


$conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
$consulta = "select validade from Produtor where usuario='$user' and senha='$pass' ";

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
    header('Location: https://ingressozapp.com/portaria?codigo='.$codigo);
} else{
    echo  "<h1>Usuário Invalidado, faça login novamente! Caso o problema percista contate nosso suporte (67)99965-4445</h1>";
}

mysqli_close($conexao);

?>