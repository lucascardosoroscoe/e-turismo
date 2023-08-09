<?php

    $itemName = $_POST['item'];
    $amount = intval($_POST['amount']);
    $value = intval($_POST['value']);
    $name = $_POST['name'];
    $cpf = $_POST['cpf'];
    $phone_number = $_POST['phone_number'];

    $ccname = $_POST['cc-name'];
    
    $name = $_POST['name'];
    $ccmes = $_POST['cc-mes'];
    $ccano = $_POST['cc-ano'];
    $cccvv = $_POST['cc-cvv'];
    $cccep = $_POST['cc-cep'];
    $ccnumber = $_POST['cc-number'];
    $ccnumero = $_POST['cc-numero'];
    $cccidade = $_POST['cc-cidade'];
    $ccestado = $_POST['cc-estado'];
    $ccendereco = $_POST['cc-endereco'];
    echo $ccendereco;

    require './vendor/autoload.php';
    require 'config.php';
    
    use Gerencianet\Exception\GerencianetException;
    use Gerencianet\Gerencianet;
    
    $params = ['id' => 0];
    
    $paymentToken = 'Insira_aqui_seu_paymentToken';
    
    $customer = [
        'name' => 'Gorbadoc Oldbuck',
        'cpf' => '04267484171',
        'phone_number' => '5144916523',
        'email' => 'oldbuck@gerencianet.com.br',
        'birth' => '1990-01-15'
    ];
    
    $billingAddress = [
        'street' => 'Av JK',
        'number' => 909,
        'neighborhood' => 'Bauxita',
        'zipcode' => '35400000',
        'city' => 'Ouro Preto',
        'state' => 'MG',
    ];
    
    $body = [
        'payment' => [
            'credit_card' => [
                'installments' => 1,
                'billing_address' => $billingAddress,
                'payment_token' => $paymentToken,
                'customer' => $customer
            ]
        ]
    ];
    
    try {
        $api = new Gerencianet($options);
        $response = $api->payCharge($params, $body);
    
        echo '<pre>' . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</pre>';
    } catch (GerencianetException $e) {
        print_r($e->code);
        print_r($e->error);
        print_r($e->errorDescription);
    } catch (Exception $e) {
        print_r($e->getMessage());
    }