<h2>Cancelamento Total ou Parcial</h2>
<hr>
O cancelamento é a operação responsável pela cancelamento total ou parcial de um valor autorizado ou capturado.<br>

Basta realizar um POST enviando o valor a ser cancelado.<br>

<br>Aqui você deve passar 2 GETs: $_GET['id'] e $_GET['vl'].
<br>
$_GET['id']=PaymentId;
$_GET['vl']=valor que deseja cancelar;


Atenção: Cancelamento parcial é disponível apenas para transações *CAPTURADAS*<br>
Atenção: O retorno da API soma o total de cancelamentos Parciais, ou seja, se 3 cancelamentos de R$10,00 forem realizados, a API apresentará em seu retorno um total de R$30,00 cancelados
<hr>

<?header("Content-Type: text/html; charset=ISO-8859-1", true);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors', '1');

    $MerchantID="86a34811-e49f-4956-b506-069693ccb6d3"; //insira seu id informado pela cielo - leia \arquivo curinga - comece por aqui      
   $MerchantKey="kyCB0j1IcTPK1xNsZfo0TetdSYamswfyIXiu2A6hiEo=
   "; //insira seu key informado pela cielo - leia \arquivo curinga - comece por aqui
  


   $MerchantOrderId=1; // insera o código que informou em comprar.php

/////////////////////////////////////////////////////////////////////////////
//faz cacelamento do id do pagamento $cPaymentId
/////////////////////////////////////////////////////////////////////////////

   /**
     * Monta o Array de requisição
     */
    $request = array(
        "MerchantOrderId" => $MerchantOrderId,  //Numero de identificação do Pedido.
        "Customer" => array(
            "Name" => $firstname . " " . $lastname
           // "Identity" => $ccpf
        ),
        "Payment" => array(
            "Type" => "CreditCard",
            "Amount" => $amount,
            "Installments" => $parcelas,
            "SoftDescriptor" => substr(str_replace('w','',str_replace('.','',$_SERVER['SERVER_NAME'])),0,12),
            "CreditCard" => array(
                "CardNumber" => $cardNumber,
                "ExpirationDate" => $cardExpiry,
                "SecurityCode" => $cardCvv,
                "Brand" => $bandeira
            )
        )
    );


    $data_string2 = json_encode($request, true);
	$cPaymentId = $_GET['id'];
    $cvalor = $_GET['vl'];
	//https://developercielo.github.io/manual/'?json#consulta-captura-cancelamento
    //"https://apisandbox.cieloecommerce.cielo.com.br/1/sales/{PaymentId}/void?amount=XXX"

	$ch2 = curl_init("https://apisandbox.cieloecommerce.cielo.com.br/1/sales/$cPaymentId/void?amount=$cvalor");

    curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch2, CURLOPT_POSTFIELDS, $data_string2);
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch2, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'MerchantId: 86a34811-e49f-4956-b506-069693ccb6d3',
        'MerchantKey: kyCB0j1IcTPK1xNsZfo0TetdSYamswfyIXiu2A6hiEo=',
        'Content-Length: ' . strlen($data_string2))
    );


    $result2 = curl_exec($ch2);
    $result2 = json_decode($result2, true);


    echo "<pre>";
    echo var_dump($result2);
    echo "</pre>";


?>