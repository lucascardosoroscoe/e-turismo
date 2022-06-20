<?php
include('../includes/verificarAcesso.php');
$email = $_POST['inputEmailAddress'];
$inputPassword = $_POST['inputPassword'];

verificarAdm();


function verificarAdm(){
    global $email, $inputPassword;
    if($email == "lucascardosoroscoe@gmail.com"){
        $hash = '$2y$10$fJzrtQP./2u2A1xRzxCEq.XblBrIxunrQtM4GCLS01xR9XBy.YM12';
        $valid = password_verify($inputPassword, $hash);
        if ($valid == 1){
            $id = 0;
            $nome = "Roscoe";
            $type = '1';
            login($id, $nome, $type, $email, "adm");
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
        if($id == "675"){
            $id = '674';
        }
        $nome = $dados[0]['nome'];
        $type = 2;
        login($id, $nome, $type, $email, 'prod');
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
        if($inputPassword == 'ingressozapp'){
            login($id, $nome, $type, $email, 'redefinir');
        }else{
            login($id, $nome, $type, $email, 'vend');
        }
        
    }else{
        loginIncorreto();
    }
}

function loginIncorreto(){
    $msg = "Login ou Senha Incorretos";
    echo $msg;
    header('Location: index.php?msg='.$msg);
}

function login($id, $nome, $type, $email, $extra){
    $msg = "Sucesso!";

    $_SESSION["idUsuario"] = $id;
    $_SESSION["usuario"] = $nome;
    $_SESSION["tipoUsuario"] = $type;
    $_SESSION["emailUsuario"] = $email;
    $_SESSION["idLote"] = "0";
    $_SESSION["nCaixa"] = "0";
    $_SESSION["msg"] = "0";
    echo $_SESSION["tipoUsuario"];
    echo $_SESSION["usuario"];

        header('Location: ../index.php?msg='.$msg);
    
}
    
?>