<?php
include('bancoDados.php');

$usuario = $_SESSION["usuario"];
$idUsuario = $_SESSION["idUsuario"];
$tipoUsuario = $_SESSION["tipoUsuario"];
$idEvento = $_SESSION["idEvento"];
$idLote = $_SESSION["idLote"];
$nCaixa = $_SESSION["nCaixa"];


function verificarAcesso($nivelAcesso){
    global $tipoUsuario;
    if($nivelAcesso < $tipoUsuario){
        $msg= "O usuário não possúi permissões de acesso à página que tentou acessar";
        if($tipoUsuario == 1 || $tipoUsuario == 2 || $tipoUsuario == 3){
          header('Location: http://ingressozapp.com/app/index.php?msg='.$msg);
        }
    }
}

?>