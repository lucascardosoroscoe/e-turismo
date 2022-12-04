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
  return number_format(floatval($valor),2,',','.');
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

function alerta($alerta, $pedido, $usuario, $url){
  $consulta = "INSERT INTO `Alertas`(`alerta`, `pedido`, `usuario`, `url`) VALUES ('$alerta', '$pedido', '$usuario', '$url')";
  $msg =  executar($consulta);
  enviaEmail('lucascardosoroscoe@gmail.com', 'Lucas Roscoe', 'Alerta de possivel erro no IngressoZapp', $alerta);
}

function enviaEmail($email, $nome, $assunto, $corpo){
  require ("../../app/mail/PHPMailerAutoload.php");
  $mail = new PHPMailer();
  $mail->IsSMTP();


  $mail->SMTPDebug = 2;
  $mail->Host = 'smtp.hostinger.com';
  $mail->Port = 587;
  $mail->SMTPAuth = true;


  $mail->Username = 'ingresso@ingressozapp.com';
  $mail->Password = '@Baba123258';


  $mail->setFrom('ingresso@ingressozapp.com', 'IngressoZapp');
  $mail->addReplyTo('ingresso@ingressozapp.com', 'IngressoZapp');
  $mail->AddAddress($email, $nome);
  $mail->AddAddress('ingressozapp@gmail.com', 'Ingressozapp');

  $mail->Subject = $assunto;
  $mail->msgHTML(file_get_contents('message.html'), __DIR__);
  $mail->IsHTML(true);
  $mail->Body = $corpo;
  //$mail->addAttachment('test.txt');
  if (!$mail->send()) {
      echo 'Mailer Error: ' . $mail->ErrorInfo;
  } else {
      echo 'The email message was sent.';
  }
  $mail->ClearAllRecipients();
  $mail->ClearAttachments();
  $mail->SMTPDebug = true;
}
?>