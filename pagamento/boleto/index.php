<?php
 
require '../vendor/autoload.php'; // caminho relacionado a SDK
require '../config.php';
 
use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

$charge_id = $_GET['transacao'];
 
// $charge_id refere-se ao ID da transação gerada anteriormente
$params = [
  'id' => $charge_id
];
 
$customer = [
  'name' => 'Lucas Roscoe', // nome do cliente
  'cpf' => '104027639639' , // cpf válido do cliente
  'phone_number' => '67999654445' // telefone do cliente
];
 
$bankingBillet = [
  'expire_at' => '2022-01-23', // data de vencimento do boleto (formato: YYYY-MM-DD)
  'customer' => $customer
];
 
$payment = [
  'banking_billet' => $bankingBillet // forma de pagamento (banking_billet = boleto)
];
 
$body = [
  'payment' => $payment
];
 
try {
    $api = new Gerencianet($options);
    $charge = $api->payCharge($params, $body);
 
    print_r($charge);
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}