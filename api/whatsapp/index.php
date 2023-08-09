<?php

// Require the Composer autoloader
include('../../app/includes/verificarAcesso.php');
require '../../vendor/autoload.php';

use Netflie\WhatsAppCloudApi\WebHook;

$log = file_get_contents('php://input');
$get = json_decode($log, true);
    
$pedido = json_encode($get, true);
$msg = salvarLog($get, $pedido, 1, "ingressozapp.com");

// Instantiate the Webhook super class.
$webhook = new WebHook();
// $webhook->verify($_GET, "Baba@123258x");
$txt = $webhook->read($log);
$msg = salvarLog($txt, "TXT", 2, $pedido);

function salvarLog($log, $server, $numeroPedido, $payment_url){
    $consulta = "INSERT INTO `LogApi`( `log`,`server`,`pedido`,`url`) VALUES ('$log', '$server', '$numeroPedido', '$payment_url')";
    $msg = executar($consulta);
    return $msg;
}