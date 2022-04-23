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
    

    $id = $_GET['id'];
    $consulta = "UPDATE `Lote` SET `validade`='ESGOTADO' WHERE `id` = '$id'";
    $msg = executar($consulta);

    $consulta = "SELECT * FROM `Lote` WHERE `id` = '$id'";
    $dados = selecionar($consulta);
    $idVariacao = $dados[0]['idVariacao'];
    $link = 'products/' . $idEvento . '/variations' .'/'.$idVariacao;
    try {
        echo json_encode($woocommerce->delete( $link , ['force' => true]));
    } catch (Throwable $th) {
        //throw $th;
    }

    header('Location: index.php?msg='.$msg);
?>