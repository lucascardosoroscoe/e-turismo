<?php
session_start();
/*Verificar Login*/
$usuario = $_SESSION["usuario"];
$idUsuario = $_SESSION["idUsuario"];
$tipoUsuario = $_SESSION["tipoUsuario"];
$idEvento = $_SESSION["idEvento"];
$validade = $_SESSION["validade"];
$produtor  =  $_SESSION["usuario"];
$nCaixa = $_SESSION["nCaixa"];
$tipoUsuario = $_SESSION["tipoUsuario"];
$idUsuario = $_SESSION["idUsuario"];
$tipoUsuario = 1;
$nomeEvento = $_SESSION["nomeEvento"];
$idEvento = $_SESSION["idEvento"];
$produtor = "Roscoe";

if($tipoUsuario != 1 && $tipoUsuario != 2 && $tipoUsuario != 3&& $tipoUsuario != 4){
  // header('Location: http://139.59.210.161/login/index.php?msg='.$msg);
}
function verificarAcesso($nivelAcesso){
    global $tipoUsuario;
    // if($nivelAcesso < $tipoUsuario){
    //     $msg= "O usuário não possúi acesso a esta página";
    //     if($tipoUsuario == 1 || $tipoUsuario == 2 || $tipoUsuario == 3){
    //       header('Location: http://139.59.210.161/index.php?msg='.$msg);
    //     }else if($tipoUsuario = 4){
    //       $msg = $_GET['msg'];
    //       header('Location: http://139.59.210.161/appMotorista/index.php?msg=' . $msg);
    //     }
    // }
}

?>