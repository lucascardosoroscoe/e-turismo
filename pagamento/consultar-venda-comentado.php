<h2>Vendas Realizadas</h2>
Aqui voc� deve passar o $_GET['id'] que � o merchantOrderId que � o c�digo que voc� informou atrav�s do comprar.php que armazena o c�digo da venda.<br>
Observe que ele tr�s dois links:<br>
O que chama o arquivo respons�vel pelo cancelamento: <a href="cancelamento.php?id=<?echo $result['Payments'][$j]['PaymentId']?>&vl=<?echo $cAmount;?>" target="_blank">Cancelar</a>
E o arquivo respons�vel pela consulta da respectiva venda: 	<a href="buscar-informacao-sobre-uma-determinada-venda.php?id=<?echo $result['Payments'][$j]['PaymentId']?>" target="_blank">Clique para abrir</a>
<hr>
<?header("Content-Type: text/html; charset=ISO-8859-1", true);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors', '1');

  
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

    /**
     * Envia a requisi��o para a Cielo
     */



    $MerchantID="86a34811-e49f-4956-b506-069693ccb6d3"; //insira seu id informado pela cielo - leia \arquivo curinga - comece por aqui      
   $MerchantKey="kyCB0j1IcTPK1xNsZfo0TetdSYamswfyIXiu2A6hiEo="; //insira seu key informado pela cielo - leia \arquivo curinga - comece por aqui

    $data_string = json_encode($request, true);
    $cidvenda=$_GET['id'];

    $ch = curl_init("https://apiquerysandbox.cieloecommerce.cielo.com.br/1/sales?merchantOrderId=$cidvenda");

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'MerchantId: 86a34811-e49f-4956-b506-069693ccb6d3',
        'MerchantKey: kyCB0j1IcTPK1xNsZfo0TetdSYamswfyIXiu2A6hiEo=',
        'Content-Length: ' . strlen($data_string))
    );

    $result = curl_exec($ch);
    $result = json_decode($result, true);


//descomente abaixo para visualizar todos os campos do resultado
//        echo "<pre>";
//    echo var_dump($result);
//     echo "</pre>";

/////////////////////////////////////////////////////////////////////////////
//varre todas as vendas realizadas em nome do merchantOrderId = codigo da loja
/////////////////////////////////////////////////////////////////////////////

$total=count($result);
for ($i = 0; $i <= $total; $i++)
{

/////////////////////////////////////////////////////////////////////////////
//captura os pagamentos realizados em nome do merchantOrderId = codigo da loja
/////////////////////////////////////////////////////////////////////////////
 $totalPayments=count($result['Payments']);
 for ($j = 0; $j <= $totalPayments; $j++)
 {
	 echo '<br>Ordem de apresenta��o: '.$j;
     echo '<br><strong>'.$result['Payments'][$j]['PaymentId'].'</strong><br>';
?>	

	<a href="buscar-informacao-sobre-uma-determinada-venda.php?id=<?echo $result['Payments'][$j]['PaymentId']?>" target="_blank">Clique para abrir</a>
	
	
	<br>
<?	
//    echo $result['Payments'][$j]['ReceveidDate'].'-'.$j.'<br>';

/////////////////////////////////////////////////////////////////////////////////
//gravar no banco
    $cPaymentId=$result['Payments'][$j]['PaymentId'];            //gravar no banco
    $cReceveidDate=$result['Payments'][$j]['ReceveidDate'];     //gravar no banco
/////////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////////////
//busca mais dados sobre o id do pagamento $cPaymentId
/////////////////////////////////////////////////////////////////////////////

    $data_string2 = json_encode($request, true);
    $cidpagamento = $cPaymentId;
    $ch2 = curl_init("https://apiquerysandbox.cieloecommerce.cielo.com.br/1/sales/$cidpagamento");

    curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch2, CURLOPT_POSTFIELDS, $data_string2);
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch2, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'MerchantId: ' . $MerchantID,
        'MerchantKey: ' . $MerchantKey,
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
?>
<!--$cAmount - voc� pode colocar o valor parcial que deseja cancela ou total. lembre-se de n�o utilizar ponto(.) para separar decimal
Clicando uma vez ser� feito o cancelamento. Se clicar novamente vai receber a mensagem "Transaction not available to void" significa que o cancelamento foi concretizado e portanto n�o se pode cancelar novamente.
-->
	<a href="cancelamento.php?id=<?echo $result['Payments'][$j]['PaymentId']?>&vl=<?echo $cAmount;?>" target="_blank">Cancelar</a>
	<br>
<?
echo '****************************************************************************<br>';

/////////////////////////////////////////////////////////////////////////////////

//descomento para visualizar outros campos
    //    echo "<pre>";
 //   echo var_dump($result2);
 //    echo "</pre>";


/////////////////////////////////////////////////////////////////////////////
//FIM busca mais dados sobre o id do pagamento
/////////////////////////////////////////////////////////////////////////////

  }
}

?>