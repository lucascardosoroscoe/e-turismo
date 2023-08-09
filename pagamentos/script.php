<?php
include_once("configuracoes.php");

//Extraindo os dados recebidos via POST
extract($_POST);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//INÍCIO DOS DADOS DO CLIENTE
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Aqui você pode usar os dados de cadastro do seu cliente puxando do seu banco de dados,
//de uma session ou de cookies, fica a seu critério a melhor forma de trazer os dados.

//Nome
$nome = "Nome completo do seu cliente";
//E-mail do cliente (Para testar na Sandbox é necessário gerar um comprador de testes na sua sandbox pagseguro.)
$email = "email@cliente.com";
//CPF. Apenas números
$cpf = "04737799513";
//Endereço
$endereco = "Rua da luz";
//Número
$numero = "123";
//Complemento (MUITA ATENÇÃO AQUI!!! ESSE CAMPO NÃO PODE ULTRAPASSAR 40 CARACTERES.)
$complemento = "APTO 302";
//Bairro
$bairro = "SANTA HELENA";
//CEP
$cep = "40130030";
//Cidade
$cidade = "SÃO PAULO";
//Estado
$uf = "SP";
//Celular
$ddd = "11";
$celular = "911111111";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//FIM DOS DADOS DO CLIENTE
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//INÍCIO DA TRANSAÇÃO VIA CARTÃO DE CRÉDITO
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($forma_de_pagamento == "Cartão"){

$dados_transacao = [
    'email' => $pagseguro_email, //O e-mail da sua conta no PagSeguro, deixe do jeito que está, mude somente no arquivo configuracoes.php
    'token' => $pagseguro_token, //Token gerado pelo PagSeguro, deixe do jeito que está, mude somente no arquivo configuracoes.php
    'paymentMode' => 'default', //Modo de pagamento Padrão
    'paymentMethod' => 'creditCard', //Forma de pagamento. Nesse caso cartão de crédito.
    'receiverEmail' => $pagseguro_email, //O e-mail da sua conta no PagSeguro, deixe do jeito que está, mude somente no arquivo configuracoes.php
    'currency' => 'BRL', //Moeda da transação
    'extraAmount' => '0.00', //Valor Extra. Por exemplo: Multa, Juros, etc.
    'itemId1' => '1', //Código do item
    'itemDescription1' => $descricao, //Descrição do produto ou serviço.
    'itemAmount1' => $total, //Valor unitário do item ( Não esqueça de formatar o valor corretamente, se for R$ 100,00 deve estar assim 100.00, se for R$ 1.000,00 deve estar assim: 1000.00 ).
    'itemQuantity1' => '1', //Quantidade de itens.
    'notificationURL' => $pagseguro_retorno, //URL de notificação para onde o PagSeguro vai enviar notificações sobre a transação.
    'reference' => $id_transacao, //Essa é a referência da transação dentro do seu sistema. Pode ser o ID do pedido ou ID do seu cliente.
    'senderName' => $nome, //Nome do cliente
    'senderCPF' => $cpf, //CPF do cliente
    'senderAreaCode' => $ddd, //DDD do cliente
    'senderPhone' => $celular, //Celular do cliente
    'senderEmail' => $email, //E-mail do cliente
    'senderHash' => $hash, //Hash gerada pelo PagSeguro para essa transação
    'shippingAddressStreet' => $endereco, //Endereço do cliente
    'shippingAddressNumber' => $numero, //Número do cliente
    'shippingAddressComplement' => $complemento, //Complemento. MUITA ATENÇÃO, NÃO PODE ULTRAPASSAR 40 CARACTERES.
    'shippingAddressDistrict' => $bairro, //Bairro
    'shippingAddressPostalCode' => $cep, //Cep
    'shippingAddressCity' => $cidade, //Cidade
    'shippingAddressState' => $uf, //Estado. Em formato UF. Ex. SP, RJ, BA...
    'shippingAddressCountry' => 'BRA', //País
    'shippingType' => '3', //Tipo de frete (1 PARA Encomenda normal (PAC), 2 PARA SEDEX, 3 PARA Tipo de frete não especificado)
    'shippingCost' => '0.00', //Valor do frete
    'creditCardToken' => $token, //Token gerado para a transação via cartão
    'installmentQuantity' => $parcelas, //Número de parcelas
    'installmentValue' => number_format($valor_parcela,2,'.',''), //Valor total do pagamento
    //'noInterestInstallmentQuantity' => 2, esse parâmetro é obrigatório se informado o maxInstallmentNoInterest nos arquivos javascript das parcelas

    'creditCardHolderName' => $nome_titular, //Nome como está impresso no cartão
    'creditCardHolderCPF' => $cpf_titular, //CPF do titular do cartão
    'creditCardHolderBirthDate' => $data_nascimento_titular, //Data de nascimento do titular do cartão
    'creditCardHolderAreaCode' => $ddd_titular, //DDD Do celular do titular do cartão
    'creditCardHolderPhone' => $celular_titular, //Celular do titular do cartão

    'billingAddressStreet' => $endereco, //Endereço de entrega para o frete
    'billingAddressNumber' => $numero, //Número de entrega para o frete
    'billingAddressComplement' => $complemento, //Complemento de entrega para o frete (Máximo 40 caracteres)
    'billingAddressDistrict' => $bairro, //Bairro de entrega para o frete
    'billingAddressPostalCode' => $cep, //Cep de entrega para o frete
    'billingAddressCity' => $cidade, //Cidade de entrega para o frete
    'billingAddressState' => $uf, //Estado de entrega para o frete. Ex. SP
    'billingAddressCountry' => 'BRA' //País de entrega para o frete
];

$query = http_build_query($dados_transacao);

$curl = curl_init($pagseguro_url);
curl_setopt($curl,CURLOPT_HTTPHEADER, Array('Content-Type: application/x-www-form-urlencoded;charset=UTF-8'));
curl_setopt($curl,CURLOPT_POST,1);
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl,CURLOPT_POSTFIELDS,$query);
$retorno_transaction = curl_exec($curl);
curl_close($curl);

$xml = simplexml_load_string($retorno_transaction);

//print_r($xml);

$dt = $xml->date;
$dt = strtotime($dt);
$data_hora = date("d/m/Y H:i",$dt);
$codigo = $xml->code;
$status = $xml->status;
switch ($status) {
case 1:
$status = "Aguardando pagamento";
//o comprador iniciou a transação, mas até o momento o PagSeguro não recebeu nenhuma informação sobre o pagamento.
break;
case 2:
$status = "Em análise";
//o comprador optou por pagar com um cartão de crédito e o PagSeguro está analisando o risco da transação.
break;
case 3:
$status = "Paga";
//a transação foi paga pelo comprador e o PagSeguro já recebeu uma confirmação da instituição financeira responsável pelo processamento.
break;
case 4:
$status = "Disponível";
//a transação foi paga e chegou ao final de seu prazo de liberação sem ter sido retornada e sem que haja nenhuma disputa aberta.
break;
case 5:
$status = "Em disputa";
//o comprador, dentro do prazo de liberação da transação, abriu uma disputa.
break;
case 6:
$status = "Devolvida";
//o valor da transação foi devolvido para o comprador.
break;
case 7:
$status = "Cancelada";
//a transação foi cancelada sem ter sido finalizada.
break;
case 8:
$status = "Debitado";
//o valor da transação foi devolvido para o comprador.
break;
case 9:
$status = "Retenção temporária";
//o comprador abriu uma solicitação de chargeback junto à operadora do cartão de crédito.
break;
}
$forma = $xml->paymentMethod->type;
switch ($forma) {
case 1:
$forma = "Cartão de crédito";
//o comprador escolheu pagar a transação com cartão de crédito.
break;
case 2:
$forma = "Boleto";
//o comprador optou por pagar com um boleto bancário.
break;
case 3:
$forma = "Débito online (TEF)";
//o comprador optou por pagar a transação com débito online de algum dos bancos conveniados.
break;
case 4:
$forma = "Saldo PagSeguro";
//o comprador optou por pagar a transação utilizando o saldo de sua conta PagSeguro.
break;
case 5:
$forma = "Oi Paggo";
//o comprador escolheu pagar sua transação através de seu celular Oi.
//Temporariamente indisponível no PagSeguro.
break;
case 7:
$forma = "Depósito em conta";
//o comprador optou por fazer um depósito na conta corrente do PagSeguro. Ele precisará ir até uma agência bancária, fazer o depósito, guardar o comprovante e retornar ao PagSeguro para informar os dados do pagamento. A transação será confirmada somente após a finalização deste processo, que pode levar de 2 a 13 dias úteis.
break;
}
$bruto = (string)$xml->grossAmount;
$bruto = money_format('%n',$bruto);
$taxa = (string)$xml->feeAmount;
$taxa = money_format('%n',$taxa);
$liquido = (string)$xml->netAmount;
$liquido = money_format('%n',$liquido);
$nome = $xml->sender->name;
$primeiro_nome = explode(" ", $nome);
$primeiro_nome = $primeiro_nome[0];

if($status == "Aguardando pagamento" OR $status == "Em análise" OR $status == "Paga" ){
$msgm = "<p>Obrigado, <strong>".$primeiro_nome."</strong>!</p> <p>O status atual do seu pagamento via <strong>".$forma."</strong> é <strong>".$status."</strong> e o código da transação junto ao PagSeguro é <strong>".$codigo."</strong>.</p> <p>O valor total é de <strong>".$bruto."</strong>, do qual <strong>".$liquido."</strong> receberemos e <strong>".$taxa."</strong> será pago ao PagSeguro como taxa pela intermediação da transação.</p>";
print '{ "estatus" : "sucesso", "estatusTexto" : "'.$msgm.'" }';
}else{
foreach( $xml as $error ){$erro = $error->message;}
print '{ "estatus" : "erro", "estatusTexto" : "Ocorreu um erro ao tentar pagar com cartão: '.$erro.'" }';
exit();
}

}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//FIM DA TRANSAÇÃO VIA CARTÃO DE CRÉDITO
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//INÍCIO DA TRANSAÇÃO VIA BOLETO
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($forma_de_pagamento == "Boleto"){

$dados_transacao = [
    'email' => $pagseguro_email, //O e-mail da sua conta no PagSeguro, deixe do jeito que está, mude somente no arquivo configuracoes.php
    'token' => $pagseguro_token, //Token gerado pelo PagSeguro, deixe do jeito que está, mude somente no arquivo configuracoes.php
    'paymentMode' => 'default', //Modo de pagamento Padrão
    'paymentMethod' => 'boleto', //Forma de pagamento. Nesse caso boleto bancário.
    'receiverEmail' => $pagseguro_email, //O e-mail da sua conta no PagSeguro, deixe do jeito que está, mude somente no arquivo configuracoes.php
    'currency' => 'BRL', //Moeda da transação
    'extraAmount' => '0.00', //Valor Extra. Por exemplo: Multa, Juros, etc.
    'itemId1' => '1', //Código do item
    'itemDescription1' => $descricao, //Descrição do produto ou serviço.
    'itemAmount1' => $total, //Valor unitário do item ( Não esqueça de formatar o valor corretamente, se for R$ 100,00 deve estar assim 100.00, se for R$ 1.000,00 deve estar assim: 1000.00 ).
    'itemQuantity1' => '1', //Quantidade de itens.
    'notificationURL' => $pagseguro_retorno, //URL de notificação para onde o PagSeguro vai enviar notificações sobre a transação.
    'reference' => $id_transacao, //Essa é a referência da transação dentro do seu sistema. Pode ser o ID do pedido ou ID do seu cliente.
    'senderName' => $nome, //Nome do cliente
    'senderCPF' => $cpf, //CPF do cliente
    'senderAreaCode' => $ddd, //DDD do cliente
    'senderPhone' => $celular, //Celular do cliente
    'senderEmail' => $email, //E-mail do cliente
    'senderHash' => $hash, //Hash gerada pelo PagSeguro para essa transação
    'shippingAddressStreet' => $endereco, //Endereço do cliente
    'shippingAddressNumber' => $numero, //Número do cliente
    'shippingAddressComplement' => $complemento, //Complemento. MUITA ATENÇÃO, NÃO PODE ULTRAPASSAR 40 CARACTERES.
    'shippingAddressDistrict' => $bairro, //Bairro
    'shippingAddressPostalCode' => $cep, //Cep
    'shippingAddressCity' => $cidade, //Cidade
    'shippingAddressState' => $uf, //Estado. Em formato UF. Ex. SP, RJ, BA...
    'shippingAddressCountry' => 'BRA', //País
    'shippingType' => '3', //Tipo de frete (1 PARA Encomenda normal (PAC), 2 PARA SEDEX, 3 PARA Tipo de frete não especificado)
    'shippingCost' => '0.00' //Valor do frete
];

$query = http_build_query($dados_transacao);

$curl = curl_init($pagseguro_url);
curl_setopt($curl,CURLOPT_HTTPHEADER, Array('Content-Type: application/x-www-form-urlencoded;charset=UTF-8'));
curl_setopt($curl,CURLOPT_POST,1);
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl,CURLOPT_POSTFIELDS,$query);
$retorno_transaction = curl_exec($curl);
curl_close($curl);

$xml = simplexml_load_string($retorno_transaction);

$url_boleto = $xml->paymentLink;
$dt = $xml->date;
$dt = strtotime($dt);
$data_hora = date("d/m/Y H:i",$dt);
$codigo = $xml->code;
$status = $xml->status;
switch ($status) {
case 1:
$status = "Aguardando pagamento";
//o comprador iniciou a transação, mas até o momento o PagSeguro não recebeu nenhuma informação sobre o pagamento.
break;
case 2:
$status = "Em análise";
//o comprador optou por pagar com um cartão de crédito e o PagSeguro está analisando o risco da transação.
break;
case 3:
$status = "Paga";
//a transação foi paga pelo comprador e o PagSeguro já recebeu uma confirmação da instituição financeira responsável pelo processamento.
break;
case 4:
$status = "Disponível";
//a transação foi paga e chegou ao final de seu prazo de liberação sem ter sido retornada e sem que haja nenhuma disputa aberta.
break;
case 5:
$status = "Em disputa";
//o comprador, dentro do prazo de liberação da transação, abriu uma disputa.
break;
case 6:
$status = "Devolvida";
//o valor da transação foi devolvido para o comprador.
break;
case 7:
$status = "Cancelada";
//a transação foi cancelada sem ter sido finalizada.
break;
case 8:
$status = "Debitado";
//o valor da transação foi devolvido para o comprador.
break;
case 9:
$status = "Retenção temporária";
//o comprador abriu uma solicitação de chargeback junto à operadora do cartão de crédito.
break;
}
$forma = $xml->paymentMethod->type;
switch ($forma) {
case 1:
$forma = "Cartão de crédito";
//o comprador escolheu pagar a transação com cartão de crédito.
break;
case 2:
$forma = "Boleto";
//o comprador optou por pagar com um boleto bancário.
break;
case 3:
$forma = "Débito online (TEF)";
//o comprador optou por pagar a transação com débito online de algum dos bancos conveniados.
break;
case 4:
$forma = "Saldo PagSeguro";
//o comprador optou por pagar a transação utilizando o saldo de sua conta PagSeguro.
break;
case 5:
$forma = "Oi Paggo";
//o comprador escolheu pagar sua transação através de seu celular Oi.
//Temporariamente indisponível no PagSeguro.
break;
case 7:
$forma = "Depósito em conta";
//o comprador optou por fazer um depósito na conta corrente do PagSeguro. Ele precisará ir até uma agência bancária, fazer o depósito, guardar o comprovante e retornar ao PagSeguro para informar os dados do pagamento. A transação será confirmada somente após a finalização deste processo, que pode levar de 2 a 13 dias úteis.
break;
}
$bruto = (string)$xml->grossAmount;
$bruto = money_format('%n',$bruto);
$taxa = (string)$xml->feeAmount;
$taxa = money_format('%n',$taxa);
$liquido = (string)$xml->netAmount;
$liquido = money_format('%n',$liquido);
$nome = $xml->sender->name;
$primeiro_nome = explode(" ", $nome);
$primeiro_nome = $primeiro_nome[0];

if(!$url_boleto){
	foreach( $xml as $error ){$erro = $error->message;}
  print '{ "estatus" : "erro", "estatusTexto" : "Ocorreu um erro ao tentar gerar o boleto: '.$erro.'" }';
  exit();
}else{
  $msgm = "<p>Obrigado, <strong>".$primeiro_nome."</strong>!</p> <p>O status atual do seu pagamento via <strong>".$forma."</strong> é <strong>".$status."</strong> e o código da transação junto ao PagSeguro é <strong>".$codigo."</strong>.</p> <p>O valor total é de <strong>".$bruto."</strong>, do qual <strong>".$liquido."</strong> receberemos e <strong>".$taxa."</strong> será pago ao PagSeguro como taxa pela intermediação da transação. <a target='new' href=$url_boleto>Clique aqui</a> para imprimir o boleto.</p>";
	print '{ "estatus" : "sucesso", "estatusTexto" : "'.$msgm.'" }';
}

}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//FIM DA TRANSAÇÃO VIA BOLETO
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//INÍCIO DA TRANSAÇÃO VIA DÉBITO EM CONTA
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($forma_de_pagamento == "Débito"){

$dados_transacao = [
    'email' => $pagseguro_email, //O e-mail da sua conta no PagSeguro, deixe do jeito que está, mude somente no arquivo configuracoes.php
    'token' => $pagseguro_token, //Token gerado pelo PagSeguro, deixe do jeito que está, mude somente no arquivo configuracoes.php
    'paymentMode' => 'default', //Modo de pagamento Padrão
    'paymentMethod' => 'eft', //Forma de pagamento. Nesse caso EFT que significa débito em conta.
    'bankName' => $banco, //Banco selecionado pelo cliente na tela do checkout.
    'receiverEmail' => $pagseguro_email, //O e-mail da sua conta no PagSeguro, deixe do jeito que está, mude somente no arquivo configuracoes.php
    'currency' => 'BRL', //Moeda da transação
    'extraAmount' => '0.00', //Valor Extra. Por exemplo: Multa, Juros, etc.
    'itemId1' => '1', //Código do item
    'itemDescription1' => $descricao, //Descrição do produto ou serviço.
    'itemAmount1' => $total, //Valor unitário do item ( Não esqueça de formatar o valor corretamente, se for R$ 100,00 deve estar assim 100.00, se for R$ 1.000,00 deve estar assim: 1000.00 ).
    'itemQuantity1' => '1', //Quantidade de itens.
    'notificationURL' => $pagseguro_retorno, //URL de notificação para onde o PagSeguro vai enviar notificações sobre a transação.
    'reference' => $id_transacao, //Essa é a referência da transação dentro do seu sistema. Pode ser o ID do pedido ou ID do seu cliente.
    'senderName' => $nome, //Nome do cliente
    'senderCPF' => $cpf, //CPF do cliente
    'senderAreaCode' => $ddd, //DDD do cliente
    'senderPhone' => $celular, //Celular do cliente
    'senderEmail' => $email, //E-mail do cliente
    'senderHash' => $hash, //Hash gerada pelo PagSeguro para essa transação
    'shippingAddressStreet' => $endereco, //Endereço do cliente
    'shippingAddressNumber' => $numero, //Número do cliente
    'shippingAddressComplement' => $complemento, //Complemento. MUITA ATENÇÃO, NÃO PODE ULTRAPASSAR 40 CARACTERES.
    'shippingAddressDistrict' => $bairro, //Bairro
    'shippingAddressPostalCode' => $cep, //Cep
    'shippingAddressCity' => $cidade, //Cidade
    'shippingAddressState' => $uf, //Estado. Em formato UF. Ex. SP, RJ, BA...
    'shippingAddressCountry' => 'BRA', //País
    'shippingType' => '3', //Tipo de frete (1 PARA Encomenda normal (PAC), 2 PARA SEDEX, 3 PARA Tipo de frete não especificado)
    'shippingCost' => '0.00' //Valor do frete
];

$query = http_build_query($dados_transacao);
$curl = curl_init($pagseguro_url);
curl_setopt($curl,CURLOPT_HTTPHEADER, Array('Content-Type: application/x-www-form-urlencoded;charset=UTF-8'));
curl_setopt($curl,CURLOPT_POST,1);
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl,CURLOPT_POSTFIELDS,$query);
$retorno_transaction = curl_exec($curl);
curl_close($curl);

$xml = simplexml_load_string($retorno_transaction);

$url_banco = $xml->paymentLink;
$dt = $xml->date;
$dt = strtotime($dt);
$data_hora = date("d/m/Y H:i",$dt);
$codigo = $xml->code;
$status = $xml->status;
switch ($status) {
case 1:
$status = "Aguardando pagamento";
//o comprador iniciou a transação, mas até o momento o PagSeguro não recebeu nenhuma informação sobre o pagamento.
break;
case 2:
$status = "Em análise";
//o comprador optou por pagar com um cartão de crédito e o PagSeguro está analisando o risco da transação.
break;
case 3:
$status = "Paga";
//a transação foi paga pelo comprador e o PagSeguro já recebeu uma confirmação da instituição financeira responsável pelo processamento.
break;
case 4:
$status = "Disponível";
//a transação foi paga e chegou ao final de seu prazo de liberação sem ter sido retornada e sem que haja nenhuma disputa aberta.
break;
case 5:
$status = "Em disputa";
//o comprador, dentro do prazo de liberação da transação, abriu uma disputa.
break;
case 6:
$status = "Devolvida";
//o valor da transação foi devolvido para o comprador.
break;
case 7:
$status = "Cancelada";
//a transação foi cancelada sem ter sido finalizada.
break;
case 8:
$status = "Debitado";
//o valor da transação foi devolvido para o comprador.
break;
case 9:
$status = "Retenção temporária";
//o comprador abriu uma solicitação de chargeback junto à operadora do cartão de crédito.
break;
}
$forma = $xml->paymentMethod->type;
switch ($forma) {
case 1:
$forma = "Cartão de crédito";
//o comprador escolheu pagar a transação com cartão de crédito.
break;
case 2:
$forma = "Boleto";
//o comprador optou por pagar com um boleto bancário.
break;
case 3:
$forma = "Débito online (TEF)";
//o comprador optou por pagar a transação com débito online de algum dos bancos conveniados.
break;
case 4:
$forma = "Saldo PagSeguro";
//o comprador optou por pagar a transação utilizando o saldo de sua conta PagSeguro.
break;
case 5:
$forma = "Oi Paggo";
//o comprador escolheu pagar sua transação através de seu celular Oi.
//Temporariamente indisponível no PagSeguro.
break;
case 7:
$forma = "Depósito em conta";
//o comprador optou por fazer um depósito na conta corrente do PagSeguro. Ele precisará ir até uma agência bancária, fazer o depósito, guardar o comprovante e retornar ao PagSeguro para informar os dados do pagamento. A transação será confirmada somente após a finalização deste processo, que pode levar de 2 a 13 dias úteis.
break;
}
$bruto = (string)$xml->grossAmount;
$bruto = money_format('%n',$bruto);
$taxa = (string)$xml->feeAmount;
$taxa = money_format('%n',$taxa);
$liquido = (string)$xml->netAmount;
$liquido = money_format('%n',$liquido);
$nome = $xml->sender->name;
$primeiro_nome = explode(" ", $nome);
$primeiro_nome = $primeiro_nome[0];

if(!$url_banco){
  foreach( $xml as $error ){$erro = $error->message;}
  print '{ "estatus" : "erro", "estatusTexto" : "Ocorreu um erro ao tentar pagar via débito on-line: '.$erro.'" }';
  exit();
}else{
	$msgm = "<p>Obrigado, <strong>".$primeiro_nome."</strong>!</p> <p>O status atual do seu pagamento via <strong>".$forma."</strong> é <strong>".$status."</strong> e o código da transação junto ao PagSeguro é <strong>".$codigo."</strong>.</p> <p>O valor total é de <strong>".$bruto."</strong>, do qual <strong>".$liquido."</strong> receberemos e <strong>".$taxa."</strong> será pago ao PagSeguro como taxa pela intermediação da transação. <a target='new' href=$url_banco>Clique aqui</a> para concluir o pagamento na página do seu banco.</p>";
	print '{ "estatus" : "sucesso", "estatusTexto" : "'.$msgm.'" }';
}

}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//FIM DA TRANSAÇÃO VIA DÉBITO EM CONTA
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>
