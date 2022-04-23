<?php
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

    echo json_encode($woocommerce->get('products'));

    function criarEventoWP($nomeEvento, $descrição, $idEvento){
        global $woocommerce;
        $textoDesc = 'Descrição Curta';
        echo 'https://ingressozapp.com/app/getImagem.php?id='. $idEvento;
        $data = [
            'name' => $nomeEvento,
            'type' => 'variable',
            'regular_price' => '',
            'status' => 'publish',
            'short_description' => $textoDesc,
            'virtual' => true,
            'description' => $descrição,
            'categories' => [
                [
                    'id' => 39
                ]
            ],
            'images' => [
                [
                    'src' => 'ingressozapp.com/app/getImagem.php?id='. $idEvento
                ],
            ],
            'attributes' => [
                [
                    'id' => 0,
                    'name' => 'LOTES',
                    'position' => 0,
                    'visible' => true,
                    'variation' => true,
                    'options' => [
                        'LOTE 1',
                        'LOTE 2',
                        'LOTE 3',
                        'LOTE 4',
                        'LOTE 5',
                        'LOTE 6',
                        'LOTE 7',
                        'LOTE 8',
                        'LOTE 9',
                        'LOTE 10',
                        'LOTE 11',
                        'LOTE 12',
                    ]
                ]
            ],
        ]; 
        return $woocommerce->post('products', $data);
    }
    
    // $produto = criarEventoWP('Baile do Helipa0', 'Proibida a entrada de menores de 18 anos', 2);
    // echo json_encode($produto);

    // $data = [
    //     'regular_price' => '9.00',
    //     'sku' => '112142',
    //     'virtual' => true,
    //     'manage_stock' => true,
    //     'stock_quantity' => 12,
    //     "menu_order"=> 0,
    //     'attributes' => [
    //         [
    //             'id' => 0,
    //             'name' => 'LOTES',
    //             'option' => 'LOTE 1',
    //         ]
    //     ]
    // ];
    
    // print_r($woocommerce->post('products/'.$produto->id.'/variations', $data));

    // $data = [
    //     'regular_price' => '10.00',
    //     'sku' => '112439',
    //     'virtual' => true,
    //     'manage_stock' => true,
    //     'stock_quantity' => 12,
    //     'attributes' => [
    //         [
    //             'id' => 0,
    //             'name' => 'LOTES',
    //             'option' => 'LOTE 2',
    //         ]
    //     ],
    //     "menu_order"=> 1,
    // ];
    
    // print_r($woocommerce->post('products/'.$produto->id.'/variations', $data));

    // // echo json_encode($woocommerce->get('products'));
    // // echo json_encode($woocommerce->get('products/3224/variations'));

?>