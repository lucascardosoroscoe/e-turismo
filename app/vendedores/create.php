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


    
    $email = $_POST['inputEmailAddress'];
    $nome = $_POST['inputName'];
    $telefone = $_POST['inputTelefone'];
    $hash = password_hash("ingressozapp", PASSWORD_DEFAULT);
    $consulta = "SELECT `id` FROM `Vendedor` WHERE (`usuario` = '$email' OR `email` = '$email')";
    $dados = selecionar($consulta);
    $idVendedor = $dados[0]['id'];
    if($idVendedor == ""){
        $data = [
            'code' => $email,
            'discount_type' => 'fixed_cart',
            'amount' => '0.01',
            'individual_use' => true,
        ]; 
        $cupon = $woocommerce->post('coupons', $data);
        $consulta = "INSERT INTO `Vendedor`(`usuario`, `produtor`, `senha`, `nome`, `telefone`, `email`) VALUES ('$email', '$idUsuario', '$hash', '$nome', '$telefone', '$email')";
        $msg = executar($consulta);
        if($msg == "Sucesso!"){
            $consulta = "SELECT `id` FROM `Vendedor` WHERE (`usuario` = '$email' OR `email` = '$email')";
            $dados = selecionar($consulta);
            $idVendedor = $dados[0]['id'];
            $consulta = "INSERT INTO `ProdutorVendedor`(`idProdutor`, `idVendedor`) VALUES ('$idUsuario', '$idVendedor')";
            $msg = executar($consulta);
        }else{
            $msg = "Erro ao criar Vendedor, por favor contate o suporte!!";
        }
    }else{
        $consulta = "INSERT INTO `ProdutorVendedor`(`idProdutor`, `idVendedor`) VALUES ('$idUsuario', '$idVendedor')";
        $msg = executar($consulta);
    }
    $msg = "Olá " . $nome . ", tudo bem? " . "Você acaba de ser cadastrado como promoter do(a) " . $usuario . " no aplicativo IngressoZapp. Caso nunca tenha usado o app, seu primeiro acesso, utilize a senha padrão 'ingressozapp' (minusculo e sem aspas). Para vender ingressos via android acesse e baixe o app em: https://play.google.com/store/apps/details?id=ingressozapp.com.promoteringressozapp . Para vender via IOS, acesse o site: http://ingressozapp.com/app .";
    $txt = urlencode($msg);
    header('Location: https://api.whatsapp.com/send?phone=55'.$telefone.'&text='.$msg);
?>