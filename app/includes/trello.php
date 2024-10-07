
<?php
$idBoard = "611d63899b1e5c82e071badb";
$urlBoard = "https://trello.com/b/8ox3Kj9b";

$idListaLeads = "611d6c879c7dca2067a0d686";
$idListaProdutorCriado = "611d6399bdf8f432a521f75e";
$idListaEventoCadastrado = "611d63bf4245542b506fc74f";
$idListaEventoAguardandoPagamento = '615e130619761e5f9db64b1a';
$idListaEventoConcluido = '611d63cbbc04d95031d63325';


// getLista($idListaLeads);
function criarCard($name, $desc, $data, $idList){
    global $token, $key;
    $pos = 'top';
    $due = date('Y-m-d', strtotime($data));
    $url = 'https://api.trello.com/1/cards?key=' . $key . '&token=' . $token;
    $idLabels = ['orange'];
    $fields = 'name=' . $name . '&desc=' . $desc . '&idList=' . $idList . '&pos=' . $pos . '&due=' . $due . '&dueComplete=0&idLabels=611d6389ec7b9d8da4297ae9';
    echo $fields;

    $json = callCurlPost($url, $fields);
    echo $json;
}
function getLista($idLista){
    global $token, $key;
    $url = 'https://api.trello.com/1/lists/' .$idLista.'/cards?key=' . $key . '&token=' . $token ;
    echo $url;
    $json = callCurlGet($url);
    echo $json;
}
function callCurlGet($url){
    // Inicia
    $curl = curl_init();

    // Configura
    curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL =>  $url
    ]);

    // Envio e armazenamento da resposta
    $response = curl_exec($curl);

    // Fecha e limpa recursos
    curl_close($curl);

    return $response;
}
function callCurlPost($url, $fields){
    // Inicia
    $curl = curl_init();

    // Configura
    curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $url,
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => $fields,
    ]);
    // Envio e armazenamento da resposta
    $response = curl_exec($curl);

    // Fecha e limpa recursos
    curl_close($curl);
    return $response;

}
?>
