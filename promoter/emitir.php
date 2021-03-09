<?php
include('includes/db_valores.php');
session_start();
$conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
$codigo    =  rand ( 100000 , 999999 );
$produtor  =  $_GET["produtor"];
$evento    =  $_GET['evento'];
$promoter  =  $_SESSION["promoter"];
$cliente   =  $_GET['cliente'];
$telefone  =  $_GET['telefone'];
$telefone = str_replace(" ", "", $telefone);
$telefone = str_replace("(", "", $telefone);
$telefone = str_replace(")", "", $telefone);
$telefone = str_replace("-", "", $telefone);
$prim = substr($telefone,0,1);
if($prim == 0){
    $telefone = substr($telefone,1,11);
}
$lote      =  $_GET['lote'];
$local='https://ingressozapp.com/promoter/enviar.php?codigo='.$codigo.'&evento='.$evento.'&produtor='.$produtor.'&nome='.$cliente.'&telefone='.$telefone;
$consulta = "SELECT * FROM Lote WHERE evento='$evento' AND nome='$lote'";
    $gravacoes = mysqli_query($conexao, $consulta);
    $dados = array();
    while($linha = mysqli_fetch_assoc($gravacoes)){
        $dados[] = $linha; 
    }

mysqli_close($conexao);

    $obj = $dados[0];
    $valor     =  $obj['valor'];
    $sexo      =  $obj['sexo'];
    $quantidade     =  $obj['quantidade'];
    $vendidos      =  $obj['vendidos'];
    $vendidos      =  $vendidos + 1 ;
   
$conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
    $consulta = "UPDATE `Lote` SET `vendidos`='$vendidos' WHERE `nome` = '$lote' AND `evento` = '$evento'";
    if(mysqli_query($conexao, $consulta)){echo "<br>";}else{echo "erro";}    
mysqli_close($conexao);

//Confere se Já foi gerado um ingresso do mesmo vendedor, com o mesmo nome, pro mesmo evento.
$conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
    $consulta = "SELECT * from Ingresso WHERE produtor= '$produtor' AND evento= '$evento' AND vendedor= '$promoter' AND cliente= '$cliente'";
    $gravacoes = mysqli_query($conexao, $consulta);

    $dados = array();

    while($linha = mysqli_fetch_assoc($gravacoes))
    {
        $dados[] = $linha; 
    }
mysqli_close($conexao);
//echo json_encode($dados);
if(empty($dados[0])){
    $conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
        $consulta = "insert into Ingresso (codigo, produtor, evento, vendedor, cliente, telefone, valor, lote, sexo) values ('$codigo', '$produtor', '$evento', '$promoter', '$cliente', '$telefone', '$valor', '$lote', '$sexo')";
        echo $consulta;
        if(mysqli_query($conexao, $consulta)){
            $sucesso = 1;
        }else{echo "erro";}

    mysqli_close($conexao);
    if($sucesso == 1){
        
        if($quantidade == $vendidos){
            //Invalida o Lote
            $conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
            $consulta = "update Lote set validade = 'ESGOTADO' where 'nome' = '$lote' AND 'evento ' = '$evento' ";
            if(mysqli_query($conexao, $consulta)){echo "<br>";}else{echo "Falha ao invalidar Evento";}
            mysqli_close($conexao);        
            //Dispara o e-mail de lote acabado para o Produtor 
        }else if ($quantidade - $vendidos == 5)
        {
            //Verifica e-mail do produtor
            $conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
            $consulta = "SELECT * FROM Produtor WHERE usuario='$produtor'";
            $gravacoes = mysqli_query($conexao, $consulta);
            $dados = array();
            while($linha = mysqli_fetch_assoc($gravacoes)){
                $dados[] = $linha; 
            }
            $obj = $dados[0];    
            mysqli_close($conexao);
            //Dispara o e-mail de lote acabando para o Produtor 
            echo "Lote acabando";
            $assunto = 'Lote "'.$lote.'" Encerrando';
            $mensagem = 'O lote "'.$lote.'" está se encerrando. Entre agora mesmo no aplicativo "Painel IngressoZapp" e verifique se o próximo lote já está a venda.';
            $destinatario = $obj['email'];
            header('Location: https://ingressozapp.com/enviar_email.php?assunto='.$assunto.'&mensagem='.$mensagem.'&destinatario='.$destinatario.'&local='.$local);
        }


        //Verificando se é ou não um ingresso Rápido
        $msg = $_GET["msg"];
        if (empty($msg)){
            header('Location: '.$local);
        }else{
            $conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
            $consulta = "update Ingresso set validade = 'INVALIDO' where codigo = '$codigo'";

            if(mysqli_query($conexao, $consulta)){}else{echo "<h5>Falha ao invalidar ingresso</h5>";}
            mysqli_close($conexao);
            echo("<h1>Ingresso gerado com sucesso, permitir entrada!!!!</h1>");
        }
    }
}else{
    echo("<h3>Você já gerou um ingresso com essse mesmo nome de cliente para o evento $evento. Caso esteja gerando um novo ingresso, para outro cliente, por favor volte e coloque um nome mais completo.<br><br>Caso esteja tentantando reenviar o ingresso pois errou o número do Whatsapp ao gerar o ingresso <a href='$local'>Clique aqui</a> </h3>");
}


?>