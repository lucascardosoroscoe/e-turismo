<h2>Informa��es sobre a venda: <?echo $_GET['id']?>
Aqui voc� deve passar o $_GET['id'] que � o PaymentId.
</h2>
<hr>
<?header("Content-Type: text/html; charset=ISO-8859-1", true);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors', '1');

   
   $MerchantID="86a34811-e49f-4956-b506-069693ccb6d3"; //insira seu id informado pela cielo - leia \arquivo curinga - comece por aqui      
   $MerchantKey="kyCB0j1IcTPK1xNsZfo0TetdSYamswfyIXiu2A6hiEo="; //insira seu key informado pela cielo - leia \arquivo curinga - comece por aqui

   /**
     * Monta o Array de requisi��o
     */
    $request = array(
        "MerchantOrderId" => $MerchantOrderId,  //Numero de identifica��o do Pedido.
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


/////////////////////////////////////////////////////////////////////////////
//faz cacelamento do id do pagamento $cPaymentId
/////////////////////////////////////////////////////////////////////////////

    $data_string2 = json_encode($request, true);
	$cPaymentId = $_GET['id'];
  
    $ch2 = curl_init("https://apiquerysandbox.cieloecommerce.cielo.com.br/1/sales/$cPaymentId");

    curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "GET");
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

   $cCardNumber=$result2['Payment']['CreditCard']['CardNumber'];
    $cTid=$result2['Payment']['Tid'];
    $cAmount=$result2['Payment']['Amount'];
    $cTid=$result2['Payment']['Tid'];
    $cBrand=$result2['Payment']['CreditCard']['Brand'];;
    $cAuthorizationCode=$result2['Payment']['AuthorizationCode'];
    $cReceivedDate=$result2['Payment']['ReceivedDate'];

/////////////////////////////////////////////////////////////////////////////////
//gravar no banco
echo '****************************************************************************<br>';
    echo 'Cart�o: '.$cCardNumber.' - '.$cBrand.'<br>';
    echo 'Id: '.$cTid.'<br>';
    echo 'C�d. de autoriza��o: '.$cAuthorizationCode.'<br>';
    echo 'Valor: '.$cAmount.'<br>';
    echo 'Data do pagamento: '.$cReceivedDate.'<br>';
echo '****************************************************************************<br>';
/////////////////////////////////////////////////////////////////////////////////


//descomente para visualizar mais campos
    echo "<pre>";
    echo var_dump($result2);
    echo "</pre>";


?>