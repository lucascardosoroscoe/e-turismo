
<?php
$token = "efab47abf4333963554860b6eee5eff90f58eb6087e4c4501a275a442321b26e";
$key = "8226e942b340c452308dbfb0c21914f2";
$idBoard = "611d63899b1e5c82e071badb";
$urlBoard = "https://trello.com/b/8ox3Kj9b";

$idListaLeads = "611d6c879c7dca2067a0d686";
$idListaProdutorCriado = "611d6399bdf8f432a521f75e";
$idListaEventoCadastrado = "611d63bf4245542b506fc74f";
$idListaEventoAguardandoPagamento = '615e130619761e5f9db64b1a';
$idListaEventoConcluido = '611d63cbbc04d95031d63325';

// criarCard('Teste 01', 'Descrição do Teste', '2022/03/18', $idListaEventoCadastrado);
// getLista($idListaLeads);
// getLabel($id);
getBoard($idBoard);

function criarCard($name, $desc, $data, $idList){
    global $token, $key;
    $pos = 'top';
    $due = date('Y-m-d', strtotime($data));
    $url = 'https://api.trello.com/1/cards?key=' . $key . '&token=' . $token;
    $fields = 'name=' . $name . '&desc=' . $desc . '&idList=' . $idList . '&pos=' . $pos . '&due=' . $due . '&dueComplete=0';
    echo $fields;

    $json = callCurlPost($url, $fields);
    echo $json;
}
function getLista($idLista){
    global $token, $key;
    $url = 'https://api.trello.com/1/lists/' .$idLista.'/cards?key=' . $key . '&token=' . $token ;
    $json = callCurlGet($url);
    echo $json;
}
function getBoard($id){
    global $token, $key;
    $url = 'https://api.trello.com/1/board/'.$id.'?key=' . $key . '&token=' . $token ;
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