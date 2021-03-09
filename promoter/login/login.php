<!DOCTYPE html>
<html>
    
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login IngressoZapp</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="css/bulma.min.css" />
    <link rel="stylesheet" type="text/css" href="css/login.css">
</head>

<body>
<?php
include('../includes/db_valores.php');

$conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);

$us = $_GET['usuario'];
$msg =  $_GET['msg'];
if (empty($us)){
    $user = $_POST['usuario'];
    $password = $_POST['senha'];
}else{
    $user = $_GET['usuario'];
    $password = $_GET['senha'];
}

$consulta = " SELECT * FROM `Vendedor` WHERE (`usuario` = '$user' AND `senha` = '$password') OR (`email` = '$user' AND `senha` = '$password') ";


$gravacoes = mysqli_query($conexao, $consulta);

$dados = array();

while($linha = mysqli_fetch_assoc($gravacoes))
{
    $dados[] = $linha; 
}
//echo json_encode ($dados);
$first = $dados[0];
$email = $first['email'];
$emailt = $first['email'];
echo ($email);
$usuario = $first['usuario'];


    if (empty($emailt)){
        header('Location: https://ingressozapp.com/promoter/login/index.php?msg=Usuário%20ou%20senha%20incorretos!!!');
        //echo "<h1>Usuário ou senha Invalidado, contate o seu produtor de Eventos</h1>";
    } else {
        if ($password == "ingressozapp"){
            mudarSenha($user, $password);
        }else{
        session_start();
        $validade = "VALIDO";
        $_SESSION["promoter"]=$usuario;
        $_SESSION["email"]=$email;
        $_SESSION["atividade"]=$validade;
        if (session_status() !== PHP_SESSION_ACTIVE) {
            //Definindo o prazo para a cache expirar em 60 minutos.
            session_cache_expire(2880);
            session_start();
        }
        header('Location: https://ingressozapp.com/promoter/index.php?msg='.$msg.'');
        }
    }



function mudarSenha($usuario, $senha){
    echo ('
    <section class="hero is-success is-fullheight">
        <div class="hero-body">
            <div class="container has-text-centered">
                <div class="column is-4 is-offset-4">
                    <img src="../includes/logo.jpeg" alt="">
                    <div class="box">
                        <h1>Você Acessou com a senha padrão</h1>
                        <h1>Modifique sua senha para continuar</h1>
                        <form action="mudarSenha.php" method="POST">
                            <div class="field">
                                <div class="control">
                                    <p>Sua Nova Senha:</p>
                                    <input name="senha" class="input is-large" type="password" placeholder="Sua senha">
                                </div>
                            </div>
                            <input name="senhav" type="hidden" value="'.$senha.'">
                            <input name="usuario" type="hidden" value="'.$usuario.'">
                            <div class="field">
                                <div class="control">
                                    <p>Repita a Senha:</p>
                                    <input name="senha" class="input is-large" type="password" placeholder="Sua senha">
                                </div>
                            </div>
                            <button type="submit" class="button is-block is-link is-large is-fullwidth">Mudar Senha</button>
                        </form>
                        
                    </div>
                </div>
            </div>
        </section>
    ');
}

?>
</body>

</html>