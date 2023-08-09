<?php
//Esse arquivo RETORNO.PHP recebe de forma automática os retornos do pagseguro relacionados a suas vendas,
//ou seja, se um pagamento é confirmado o pagseguro acionará esse arquivo.
//A partir daí você poderá rodar ações no seu sistema como enviar um e-mail para o comprador
//avisando que o pagamento foi confirmado e/ou mudando o status da transação no seu banco de dados.

include_once("configuracoes.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){

$url = "https://ws".$sandbox.".pagseguro.uol.com.br/v2/transactions/notifications/".$_POST['notificationCode']."?email=".$pagseguro_email."&token=".$pagseguro_token;

//Comunicação com o PagSeguro para trazer os dados da transação.
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$transaction_curl = curl_exec($curl);
curl_close($curl);

$transaction = simplexml_load_string(utf8_encode($transaction_curl));

//Referência que você enviou para o PagSeguro durante a transação. ID do pedido ou ID do cliente. Esse parámetro é enviado junto com o status do pedido. Com esse parâmetro você conseguirá buscar no banco de dados o pedido/cliente em questão e mudar seu status.
$referencia = $transaction->reference;

//Código da transação gerado pelo PagSeguro. Você pode armazenar esse código em uma coluna no da tabela do pedido em seu banco de dados, é interessante para consultas futuras em seu sistema.
$transacao_pagseguro = $transaction->code;

//Caso o status da transação seja 3 (PAGO) realiza uma ação
if($transaction->status == 3){

	//Aqui você pode realizar qualquer ação em seu sistema quando o status da transação for 03 PAGO. Por exemlo: Atualizar o status do pedido no banco de dados e enviar um e-mail para o cliente.

}

//VEJA TODOS OS CÓDIGOS DE STATUS DE TRANSAÇÕES:
// 1 	Aguardando pagamento: o comprador iniciou a transação, mas até o momento o PagSeguro não recebeu nenhuma informação sobre o pagamento.
// 2 	Em análise: o comprador optou por pagar com um cartão de crédito e o PagSeguro está analisando o risco da transação.
// 3 	Paga: a transação foi paga pelo comprador e o PagSeguro já recebeu uma confirmação da instituição financeira responsável pelo processamento.
// 4 	Disponível: a transação foi paga e chegou ao final de seu prazo de liberação sem ter sido retornada e sem que haja nenhuma disputa aberta.
// 5 	Em disputa: o comprador, dentro do prazo de liberação da transação, abriu uma disputa.
// 6 	Devolvida: o valor da transação foi devolvido para o comprador.
// 7 	Cancelada: a transação foi cancelada sem ter sido finalizada.

}
?>
