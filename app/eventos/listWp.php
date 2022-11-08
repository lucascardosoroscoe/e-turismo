<?php
include('../includes/verificarAcesso.php');
verificarAcesso(1);
$msg = $_GET['msg'];

// Composer + Conexão com o Woocommerce
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
$data = [
    'per_page' => '100'
];
foreach ($woocommerce->get('products', $data) as $produto) {
    echo $produto->id . ' - ' . $produto->name . '<br>';
}
?>