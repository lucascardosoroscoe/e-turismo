<?php
    include('../includes/verificarAcesso.php');
    verificarAcesso(2);
    error_reporting(E_ALL);
    ini_set('display_errors', '1'); 
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
    

    $id = $_GET['id'];
    $consulta = "UPDATE `Lote` SET `validade`='DISPONÍVEL' WHERE `id` = '$id'";
    $msg = executar($consulta);

    $consulta = "SELECT * FROM `Lote` WHERE `id` = '$id'";
    $dados = selecionar($consulta);
    $nome = $dados[0]['nome'];
    $idEvento = $dados[0]['evento'];
    $valor = $dados[0]['valor'];
    $quantidade = $dados[0]['quantidade'];
    if(intval($valor) != 0){
        ativarLoteWP();
    }
    
    header('Location: index.php?msg='.$msg);

    function ativarLoteWP(){
        global $id, $nome, $valor, $quantidade,$idEvento, $woocommerce;

        // Get id evento WP 
        $consulta = "SELECT `idWP` FROM `Evento` WHERE `id` = '$idEvento'";
        $dados = selecionar($consulta);
        $idWP = $dados[0]['idWP'];
        $nome = rtrim($nome, " ");
        $valorFinal = $valor * 1.1;
        $data = [
            'regular_price' => strval($valorFinal),
            'sku' => strval($id),
            'virtual' => true,
            'manage_stock' => true,
            'stock_quantity' => strval($quantidade),
            'attributes' => [
                [
                    'id' => strval(0),
                    'name' => 'Lote',
                    'option' => $nome .' - R$' . $valor,
                ]
            ]
        ];
        $variacao = $woocommerce->post('products/'.$idWP.'/variations', $data);    
        $idVariacao = $variacao->id;
        $consulta  = "UPDATE `Lote` SET `idVariacao`= '$idVariacao' WHERE `id` = '$id'";
        $msg = executar($consulta);
    }
?>