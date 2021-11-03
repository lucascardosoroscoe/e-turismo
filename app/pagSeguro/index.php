<?php
    include('../includes/verificarAcesso.php');
    $email = "ingressozapp@gmail.com";
    $access_token = "0aec9415-f791-4876-a53b-118e007a7069102be8bb4222b8075142ac82ffa3aa9ed3bf-824d-4710-a323-028af0311dab";
    $url_base = "https://ws.pagseguro.uol.com.br/v2/";
    $codeExemplo = "3914D599AFAF6DAFF4D21FB59E7A4413";

    //Dados do Ingresso via POST
    $itemId1 = $idLote; //Id do Lote
    $itemQuantity1 = $_POST['inputQuantidade']; //Quantidade

    //Pega dados necessários do Banco sobre o evento e lote;
    $consulta = "SELECT Lote.nome as nomeLote, Lote.valor as valorLote, Lote.quantidade as quantidadeLote, 
    Evento.nome as evento
    FROM Lote 
    JOIN Evento ON Evento.id = Lote.evento
    WHERE Lote.id = '$itemId1'";
    echo $consulta . "<br>";
    $dados = selecionar($consulta);
    echo json_encode($dados) . "<br>";
    $nomeLote = $dados[0]['nomeLote'];
    $valorLote = $dados[0]['valorLote'];
    $quantidadeLote = $dados[0]['quantidadeLote'];
    $evento = $dados[0]['evento'];


    //Descrição do Ingresso
    $itemDescription1 = "Ingresso ". $evento . "( ". $nomeLote . " )";
    //Valor do Lote
    $itemAmount1 = $valorLote . ".00";
    
    $reference = $_POST['$idIngresso'];

    //Dados do Comprador via POST
    $senderName = $_POST['senderName'];
    $inputTelefone = $_POST['inputTelefone'];
    $senderEmail = $_POST['senderEmail'];

    //Formatar Telefone
    $senderAreaCode = 67;
    $senderPhone = 999654445;
    formatarTelefone($inputTelefone);
    
    //URL ENCODE
    $itemId1 = myUrl($itemId1);
    $itemDescription1 = myUrl($itemDescription1);
    $itemAmount1 = myUrl($itemAmount1);
    $itemQuantity1 = myUrl($itemQuantity1);
    $reference = '23905834535346';
    $reference = myUrl($reference);
    $senderName = myUrl($senderName);
    $senderEmail = myUrl($senderEmail);

    $d = "&currency=BRL&itemId1=".$itemId1."&itemDescription1=".$itemDescription1."&itemAmount1=".$itemAmount1."&itemQuantity1=".$itemQuantity1."&reference=".$reference."&senderName=".$senderName."&senderAreaCode=".$senderAreaCode."&senderPhone=".$senderPhone."&senderEmail=".$senderEmail."&shippingAddressRequired=false&extraAmount=0.00";
    echo $d . "<br>";
    $response = callCurlPost("checkout", $d);
    $xml = simplexml_load_string($response);
    $json = json_encode($xml);
    $array = json_decode($json,TRUE);
    $link = "https://pagseguro.uol.com.br/v2/checkout/payment.html?code=". $array['code'];


    function callCurlPost($endpoint, $fields){
        global $url_base, $email, $access_token;
        $url = $url_base . $endpoint ."?email=".$email."&token=".$access_token;
        echo $url . "<br>";
        // Inicia
        $curl = curl_init();
        
        // Configura
        curl_setopt_array($curl, [
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $url,
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => $fields,
        CURLOPT_HTTPHEADER => array('Content-Type: application/x-www-form-urlencoded'),
        ]);
        // Envio e armazenamento da resposta
        $response = curl_exec($curl);
    
        // Fecha e limpa recursos
        curl_close($curl);
        return $response;
    
    }

    function myUrl($string) {
        return str_replace(' ', '%20', $string);
    }

    function formatarTelefone($telefone){
        global $senderAreaCode, $senderPhone;
        $telefone = str_replace(" ", "", $telefone);
        $telefone = str_replace("(", "", $telefone);
        $telefone = str_replace(")", "", $telefone);
        $telefone = str_replace("-", "", $telefone);
        $telefone = str_replace("+55", "", $telefone);
        $prim = substr($telefone,0,1);
        if($prim == 0){
            $telefone = substr($telefone,1,11);
        }
        $senderAreaCode = substr($telefone,0,2);
        $senderPhone = substr($telefone,2,9);
    }
   
    // header('Location: '.$link);
    echo $link;
    
       
    
?>