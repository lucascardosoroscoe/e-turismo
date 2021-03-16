<?php
    //Conexão com o o Banco de dados
    $servidorBanco = '185.201.11.212:3306';
    $senhaBanco ='ingressozapp';
    $usuarioBanco ='u989688937_ingressozapp';
    $bdados ='u989688937_ingressozapp';
    
    
    global $DOCUMENT_ROOT, $HTTP_HOST;
    $DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
    $HTTP_HOST = "http://".$_SERVER['HTTP_HOST']."/app";
    $TOKEN = "BMJ-7V@9-$%ASbZXS#v%!bnmpHI%Cavj";


    //FUNÇÕES BANCO DE DADOS
    function verificar($consulta){
        global $servidorBanco, $usuarioBanco, $senhaBanco, $bdados;
        $conexao = mysqli_connect($servidorBanco, $usuarioBanco, $senhaBanco, $bdados);
        $gravacoes = mysqli_query($conexao, $consulta);
        $dados = array();
        while($linha = mysqli_fetch_assoc($gravacoes)){
            $dados[] = $linha; 
        }
        if (empty ($dados)){
            $msg = "Sucesso!";
        }else{
            $msg = "Já cadastrado!";
        }
        mysqli_close($conexao);
        return $msg;
    }

    function executar($consulta){
        global $servidorBanco, $usuarioBanco, $senhaBanco, $bdados;
        $conexao = mysqli_connect($servidorBanco, $usuarioBanco, $senhaBanco, $bdados);
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