<!DOCTYPE html>
  <html>
    <head>
        <meta charset="utf-8">
      
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

        <link rel="stylesheet" href="style1.css">

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        
    </head>

    <body>
<?php
$servidor = '127.0.0.1:3306';
$senha ='ingressozapp';
$usuario ='u989688937_ingressozapp';
$bdados ='u989688937_ingressozapp';


session_start();
/*session created*/
$validade = $_SESSION["validade"];
$produtor  =  $_SESSION["usuario"];
$nCaixa = $_SESSION["nCaixa"];

if ($validade == "VALIDO"){}else{header('Location: ../../produtor/login/');}

  
function verificar($consulta){
    global $servidor, $usuario, $senha, $bdados;
    $conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
    $gravacoes = mysqli_query($conexao, $consulta);
    $dados = array();
    while($linha = mysqli_fetch_assoc($gravacoes)){
        $dados[] = $linha; 
    }
    $act= $dados[0];
    if (empty ($dados)){
         $msg = "Sucesso!";
    }else{
         $msg = "Já cadastrado!";
    }
    mysqli_close($conexao);
    $json = json_encode($dados); 
    return $msg;
}

function executar($consulta){
    global $servidor, $usuario, $senha, $bdados;
    $conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
    if(mysqli_query($conexao, $consulta))
    {
         $msg = "Sucesso!";
    }
    else
    {
         $msg = "Falha!";
    }
    mysqli_close($conexao);
    return $msg;
}

function selecionar($consulta){
    global $servidor, $usuario, $senha, $bdados;
    //echo $servidor
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
?>
