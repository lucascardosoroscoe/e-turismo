<?php
    include_once 'includes/header.php';
session_start();
/*session created*/
$promoter  =  $_SESSION["promoter"];
$email  =  $_SESSION["email"];

//echo ($email);
$atividade =  $_SESSION["atividade"];

if ($atividade == "VALIDO"){
    echo ('<div class="row">');
            echo ('<div class="col s12 m6 push-m3 ">');
                echo ('<img src="includes/logo.png"class="logo">');
                echo ('<h3>Emitir Ingresso</h3>');
                echo ('<h6>Promoter: '.$email.'</h6>');
                echo ('<h6>Selecione o Evento: </h6>');
                //echo ($email);
                itemSelect($email);
                echo ('<br><br><br>');
                echo ('<h5><a href="login/index.php">Sair</a></h5>');
        echo ('</div>');
    echo ('</div>');


} else {
    header('Location: https://ingressozapp.com/promoter/login/');
}

function itemSelect($email){
    include('includes/db_valores.php');
    $msg= $_GET["msg"];
    $conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);

    $consulta = "SELECT * FROM Vendedor WHERE email='$email' AND validade='VALIDO'";

    $gravacoes = mysqli_query($conexao, $consulta);
    $dados = array();
    while($linha = mysqli_fetch_assoc($gravacoes)){
        $dados[] = $linha; 
    }

    mysqli_close($conexao);

    $size = sizeof($dados);
    for ($i = 0; $i < $size; $i++){
        $user = $dados[$i];

        $produtor = $user['produtor'];
        //echo $produtor;
        $conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);

        $consulta = "SELECT * FROM Evento WHERE produtor='$produtor' AND validade='VALIDO'";

        $gravacoes = mysqli_query($conexao, $consulta);
        $dadosEvento = array();
        while($linha = mysqli_fetch_assoc($gravacoes)){
        $dadosEvento[] = $linha; 
        }
        mysqli_close($conexao);
        $sizeEventos = sizeof($dadosEvento);
        for ($j = 0; $j < $sizeEventos; $j++){
            $obj = $dadosEvento[$j];

            $act = $obj['nome'];
            $produtor = $obj['produtor'];
            echo ('<h5><a href="lote.php?evento='.$act.'&produtor='.$produtor.'&msg='.$msg.'">'.$act.'</a></h5>');
        }
    }

   
}

include_once 'includes/footer.php';
?>