<?php
include('../includes/verificarAcesso.php');
verificarAcesso(1);

$id = $_GET['id'];
$nome = $_GET['nome'];
$type = 2;
$email = $_GET['email'];
login($id, $nome, $type, $email);

function login($id, $nome, $type, $email){
    $msg = "Sucesso!";

    $_SESSION["idUsuario"] = $id;
    $_SESSION["usuario"] = $nome;
    $_SESSION["tipoUsuario"] = $type;
    $_SESSION["emailUsuario"] = $email;
    echo $_SESSION["tipoUsuario"];
    header('Location: ../index.php?msg='.$msg);
}

?>