<?php
session_start();
/*Verificar Login*/
$usuario = $_SESSION["usuario"];
$idUsuario = $_SESSION["idUsuario"];
$tipoUsuario = $_SESSION["tipoUsuario"];

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