<?php
$servidor = '127.0.0.1:3306';
$senha ='ingressozapp';
$usuario ='u989688937_WtNbV';
$bdados ='u989688937_WtNbV';

$idLote    = $_POST['selecionarLote'];
$quantidade    = $_POST['selecionarQuantidade'];

$consulta = "SELECT * FROM `Lote` WHERE `id` = '$idLote'";
echo $consulta;
$lote = selecionar($consulta);
$lote = $lote[0];
$descricao = $lote['nome'];
$valor = $lote['valor'];


$rand = rand(1, 999999);

session_start();
$_SESSION['ordem'] = $rand;

$consulta = "INSERT INTO `Ordem`(`id`) VALUES ('$rand')";
echo $consulta;
adicionar($consulta);

$consulta = "INSERT INTO `Item`(`referencia`, `ordem`, `tipo`, `quantidade`) VALUES ('$idLote', '$rand', '1', '$quantidade')";
adicionar($consulta);


function selecionar($consulta){
global $servidor, $usuario, $senha, $bdados;

$conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);

$gravacoes = mysqli_query($conexao, $consulta);

$dados = array();

while($linha = mysqli_fetch_assoc($gravacoes))
{
    $dados[] = $linha; 
}
return $dados;
}

function adicionar($consulta){
    global $servidor, $usuario, $senha, $bdados;
    $conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
    
    //echo "insert into Evento (nome, produtor, imagem, data, descricao) values ('$nome', '$produtor', '$mysqlImg', '$data', '$descricao')";
    if(mysqli_query($conexao, $consulta)){
    }
    else
    {
         echo $consulta;
    }

    mysqli_close($conexao);
}

header('Location: ../pagamento/comprar.php?id='.$rand);
?>