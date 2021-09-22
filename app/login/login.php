<?php
include('../includes/verificarAcesso.php');
$email = $_POST['inputEmailAddress'];
$inputPassword = $_POST['inputPassword'];

verificarAdm();


function verificarAdm(){
    global $email, $inputPassword;
    if($email == "lucascardosoroscoe@gmail.com"){
        $hash = '$2y$10$Df68pM6BYOt0ZFD1hg/4vOywrJs1FSmQjSl/ogUI56c542Pbd6SjK';
        $valid = password_verify($inputPassword, $hash);
        if ($valid == 1){
            $id = 0;
            $nome = "Roscoe";
            $type = '1';
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
    echo json_encode($dados);
    $hash = $dados[0]['senha'];
    echo $hash;
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
    $dados = selecionar($consulta);
    $hash = $dados[0]['senha'];
    echo $hash;
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
    header('Location: index.php?msg='.$msg);
}

function login($id, $nome, $type, $email){
    $msg = "Sucesso!";

    $_SESSION["idUsuario"] = $id;
    $_SESSION["usuario"] = $nome;
    $_SESSION["tipoUsuario"] = $type;
    $_SESSION["emailUsuario"] = $email;
    $_SESSION["idLote"] = "0";
    $_SESSION["nCaixa"] = "0";
    $_SESSION["msg"] = "0";
    echo $_SESSION["tipoUsuario"];
    header('Location: ../index.php?msg='.$msg);
}
    
?>