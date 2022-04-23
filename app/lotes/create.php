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
    
    // Get dados Post 
    $nome = $_POST['inputName'];
    $valor   = $_POST['inputValor'];
    $quantidade        = $_POST['inputQuantidade'];

    // Criar Lote
    $consulta = "INSERT INTO `Lote`(`nome`, `evento`, `valor`, `quantidade`) VALUES ('$nome', '$idEvento', '$valor', '$quantidade')";
    $msg = executar($consulta);
    if($msg == "Sucesso!"){
        // Criar Lote WP 
        criarLoteWP();
        header('Location: index.php?msg='.$msg);
    }else{
        $msg = "Erro ao criar Lote, por favor contate o suporte!!<br>";
        echo $consulta;
    }  

    function criarLoteWP(){
        global $idEvento;
        
        // Get id evento WP 
        $consulta = "SELECT `idWP` FROM `Evento` WHERE `id` = '$idEvento'";
        $dados = selecionar($consulta);
        $idWP = $dados[0]['idWP'];
        
        atualizarAtributo($idWP);
    }

    function atualizarAtributo($idWP){
        global $woocommerce, $idEvento;

        $consulta = "SELECT `nome`, `valor` FROM `Lote` WHERE `evento` = '$idEvento' ORDER BY valor";
        $lotes = selecionar($consulta);
        $options = "";
        foreach ($lotes as $lote) {
            $options = $options . $lote['nome'] . ' - R$' . $lote['valor'] . '|';
        }


        $data = [
            'attributes' => [
                [
                    'name' => 'Lote',
                    'visible' => true,
                    'variation' => true,
                    'options' => [$options]
                ]
            ],
        ];
        
        echo json_encode($woocommerce->put('products/'.$idWP, $data));
    }

    
?>