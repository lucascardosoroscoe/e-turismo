<?php
include('../includes/verificarAcesso.php');
verificarAcesso(2);
require '../../vendor/autoload.php';

use Automattic\WooCommerce\Client;

$woocommerce = new Client(
    'https://ingressozapp.com', 
    'ck_e9ce6160638444022e13079c5d45ce47c18edd28', 
    'cs_f1360a97794e17ef19bc3fc2590787454020e5fa',
    [
        'wp_api' => true,
        'version' => 'wc/v3',
    ]
);


$id = $_POST['inputId'];
$nome = $_POST['inputName'];
$slug = $_POST['slug'];
$imagem = $_FILES["inputImagem"];
$data   = $_POST['inputData'];
$descricao        = $_POST['inputDescricao'];




if($imagem['tmp_name'] != "") { 
    $nomeFinal = time().'.jpg';
    if (move_uploaded_file($imagem['tmp_name'], $nomeFinal)) {
        $tamanhoImg = filesize($nomeFinal); 
    
        $mysqlImg = addslashes(fread(fopen($nomeFinal, "r"), $tamanhoImg)); 
    } $mysqlImg = addslashes(fread(fopen($nomeFinal, "r"), $tamanhoImg)); 
    
    $consulta = "UPDATE `Evento` SET `nome`='$nome',`imagem`='$mysqlImg',`data`='$data',`descricao`='$descricao',`slug`='$slug' WHERE `id` = '$id'";
    $msg = executar($consulta);
}else{
    $consulta = "UPDATE `Evento` SET `nome`='$nome',`data`='$data',`descricao`='$descricao',`slug`='$slug' WHERE `id` = '$id'";
    $msg = executar($consulta);
}
editarEventoWP($nome, $descricao, $id, $slug);
header('Location: index.php?msg='.$msg);

function editarEventoWP($nomeEvento, $descricao, $id, $slug){
    global $woocommerce, $nomeFinal;

    $consulta = "SELECT `idWP` FROM `Evento` WHERE `id` = '$id'";
    $dados = selecionar($consulta);
    $idWP = $dados[0]['idWP'];
    
    $link = 'https://ingressozapp.com/app/eventos/'.$nomeFinal;
    $descricao = $descricao . '

    *Taxa de conveniência de 10% da plataforma.';
    $auxilio = 'Já comprou um ingresso e precisa da segunda via? <a href="https://ingressozapp.com/nao-recebi-ingresso/">Clique aqui</a> 
    Gostaria de Transferir a titularidade do seu ingresso? <a href="https://ingressozapp.com/troca-titularidade/">Clique aqui</a>
    Dúvidas sobre como comprar pelo site? <a href="https://ingressozapp.com/como-comprar/">Clique aqui</a>';
    if($nomeFinal == ""){
        $data = [
            'name' => $nomeEvento,
            'slug' => $slug,
            'description' => $auxilio,
            'short_description' => $descricao,            
        ];
    }else{
        $data = [
            'name' => $nomeEvento,
            'slug' => $slug,
            'description' => $auxilio,
            'short_description' => $descricao,
            'images' => [
                [
                    'src' => $link,
                ],
            ],
        ];
    }
    
    // echo json_encode($data);
    return $woocommerce->put('products/'.$idWP, $data);
}
?>