<?php
//Esse arquivo SESSAO.PHP inicia uma sessão junto ao pagseguro e traz de lá as configurações
//da sua conta como meios de pagamento habilitados, taxas, etc.

include_once("configuracoes.php");

$url = "https://ws".$sandbox.".pagseguro.uol.com.br/v2/sessions?email=".$pagseguro_email."&token=".$pagseguro_token;
$curl = curl_init($url);
curl_setopt($curl,CURLOPT_POST,1);
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
$retorno_transaction = curl_exec($curl);
curl_close($curl);
$session = simplexml_load_string($retorno_transaction);
echo json_encode($session);
?>
