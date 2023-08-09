<?php
    session_start();
    //Conexão com o o Banco de dados
    $servidorBanco = '185.212.71.102:3306';
    $senhaBanco ='vjdC7p5XBy';
    $usuarioBanco ='u989688937_IHLyR';
    $bdados ='u989688937_WtNbV';
    
    
    global $DOCUMENT_ROOT, $HTTP_HOST;
    $DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
    $HTTP_HOST = "http://". $_SERVER['HTTP_HOST'];
    $TOKEN = "BMJ-7V@9-$%ASbZXS#v%!bnmpHI%Cavj";

    $consulta = "SELECT * FROM `Ingresso` WHERE `created_at` >= '2023-03-01 20:20:57';";
    $dados = selecionar($consulta);
    var_dump($dados);
    function selecionar($consulta){
        global $servidorBanco, $usuarioBanco, $senhaBanco, $bdados;
        $conexao = mysqli_connect($servidorBanco, $usuarioBanco, $senhaBanco, $bdados);

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