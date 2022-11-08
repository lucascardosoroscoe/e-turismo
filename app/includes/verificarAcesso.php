<?php
include('bancoDados.php');

$usuario = $_SESSION["usuario"];
$idUsuario = $_SESSION["idUsuario"];
$tipoUsuario = $_SESSION["tipoUsuario"];
$idEvento = $_SESSION["idEvento"];
$nomeEvento = $_SESSION["nomeEvento"];
$idVendedor = $_SESSION["idVendedor"];
$nomeVendedor = $_SESSION["nomeVendedor"];
$idLote = $_SESSION["idLote"];
$nCaixa = $_SESSION["nCaixa"];
$msg = $_SESSION["msg"];

function verificarAcesso($nivelAcesso){
    global $tipoUsuario;
    if($nivelAcesso < $tipoUsuario || $tipoUsuario == ""){
        $msg= "O usuário não possúi permissões de acesso à página que tentou acessar";
        if($tipoUsuario == 1 || $tipoUsuario == 2 || $tipoUsuario == 3 || $tipoUsuario == ""){
          header('Location: https://ingressozapp.com/app/index.php?msg='.$msg);
        }
    }
}

setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
function formatarData($data){
  return ucfirst(strftime("%d de %B de %Y", strtotime($data) ) );
}
function UsToBr($valor){ 
  $valor = floatval($valor);
  return number_format($valor,2,",",".");
} 
function BrToUs($valor){ 
  $valor = str_replace(".","",$valor);
  $valor = str_replace(",",".",$valor);
  return number_format($valor,2,".",",");
} 
function UsToHodo($valor){ 
  $valor = str_replace(",","",$valor);
  $valor = str_replace(".",",",$valor);
  return number_format($valor,0,",",".");
} 
?>