<?php
session_start();
/*Verificar Login*/
$usuario = $_SESSION["usuario"];
$idUsuario = $_SESSION["idUsuario"];
$tipoUsuario = $_SESSION["tipoUsuario"];
$idEvento = $_SESSION["idEvento"];
$nomeEvento = $_SESSION["nomeEvento"];

$nCaixa = $_SESSION["nCaixa"];

if($tipoUsuario == 2){
  $produtor = $idUsuario;
}

if($tipoUsuario != 1 && $tipoUsuario != 2 && $tipoUsuario != 3 && $tipoUsuario != 4){
  header('Location: http://ingressozapp.com/app/login/index.php?msg='.$msg);
}
function verificarAcesso($nivelAcesso){
    global $tipoUsuario;
    if($nivelAcesso < $tipoUsuario){
        $msg= "O usuário não possúi permissões de acesso à página que tentou acessar";
        if($tipoUsuario == 1 || $tipoUsuario == 2 || $tipoUsuario == 3){
          header('Location: http://ingressozapp.com/app/index.php?msg='.$msg);
        }
        // else if($tipoUsuario = 4){
        //   $msg = $_GET['msg'];
        //   header('Location: http://ingressozapp.com/app/appMotorista/index.php?msg=' . $msg);
        // }
    }
}

?>