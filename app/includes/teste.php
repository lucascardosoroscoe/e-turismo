<?php 
include('bancoDados.php');
echo "a";
echo $servidorBanco;
$banco = $servidorBanco;
$usuario = $usuarioBanco;
$senha = $senhaBanco;
$host = $bdados;
$conn = mysql_connect($host,$usuario,$senha);
mysql_select_db($banco) or die("Não foi possível conectar ao banco MySQL");
if (!$conn) {

    echo "Não foi possível conectar ao banco MySQL"; exit;

}

else {

    echo "O banco de dados MySQL está conectando";

}
mysql_close();
var_dump($conexao);
// $dados = selecionar("SELECT * FROM Ingresso WHERE codigo = 100010");
// var_dump($dados);

?> 
