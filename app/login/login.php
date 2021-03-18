<?php


$email = $_POST['inputEmailAddress'];
$inputPassword = $_POST['inputPassword'];

verificarAdm();


function verificarAdm(){
    global $email, $inputPassword;
    if($email == "lucascardosoroscoe@gmail.com"){
        $hash = "$2y$10$/w4QXcFCIY2mMkzWJu2v5.SXXWrzGfckF2aU9PgRLL/jjC9mBz7VO";
        // $hash = password_hash($inputPassword, PASSWORD_DEFAULT);
        $valid = password_verify($inputPassword, $hash);
        if ($valid == 1){
            $id = 0;
            $nome = "Roscoe";
            $type = 1;
            login($id, $nome, $type, $email);
        }else{
            loginIncorreto();
        }
    }else{
        verificarProdutor();
    }
}

function verificarProdutor(){
    global $email, $inputPassword;
    $consulta = "SELECT `id`, `nome`, `senha` FROM `Produtor` WHERE `email` = '$email'";
    echo $consulta;
    $dados = selecionar($consulta);
    $hash = $dados[0]['senha'];
    $valid = password_verify($inputPassword, $hash);
    if ($valid == 1){
        $id = $dados[0]['id'];
        $nome = $dados[0]['nome'];
        $type = 2;
        login($id, $nome, $type, $email);
    }else{
        verificarVendedor();
    }
}

function verificarVendedor(){
    global $email, $inputPassword;
    $consulta = "SELECT `id`, `nome`, `senha` FROM `Vendedor` WHERE `email` = '$email'";
    echo $consulta;
    $dados = selecionar($consulta);
    $hash = $dados[0]['senha'];
    $valid = password_verify($inputPassword, $hash);
    if ($valid == 1){
        $id = $dados[0]['id'];
        $nome = $dados[0]['nome'];
        $type = 3;
        login($id, $nome, $type, $email);
    }else{
        loginIncorreto();
    }
}

function loginIncorreto(){
    $msg = "Login ou Senha Incorretos";
    echo $msg;
    // header('Location: index.php?msg='.$msg);
}

function login($id, $nome, $type, $email){
    $msg = "Sucesso!";
    session_start();
    /*session created*/
    $_SESSION["idUsuario"] = $id;
    $_SESSION["usuario"] = $nome;
    $_SESSION["tipoUsuario"] = $type;
    $_SESSION["emailUsuario"] = $email;
    header('Location: ../index.php?msg='.$msg);
}
?>