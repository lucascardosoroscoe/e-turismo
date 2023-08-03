<?php
    include('../../app/includes/verificarAcesso.php');
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

    $consulta = "SELECT * FROM `Vendedor` WHERE `coupon` = 0";
    $vendedores = selecionar($consulta);
    foreach ($vendedores as $vendedor) {
        $data = [
            'code' => $vendedor['email'],
            'discount_type' => 'fixed_cart',
            'amount' => '0.01',
            'individual_use' => true,
        ];
        $cupon = $woocommerce->post('coupons', $data);
        $idVendedor = $vendedor['id'];
        $consulta = "UPDATE `Vendedor` SET `coupon`= 1 WHERE `id` = '$idVendedor'";
        $msg = executar($consulta);
        echo $msg;
    }
    

    // require ("../../vendor/autoload.php");
    echo json_encode($woocommerce->get('coupons')); 
    // echo "Teste";
?>