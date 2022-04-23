<?php
    //Verifica se Possui acesso à página
    include('../includes/verificarAcesso.php');
    verificarAcesso(2);

    //Exibe os erros de PHP 
    error_reporting(E_ALL);
    ini_set('display_errors', '1'); 

    // Recupera via composer o modulo de integração com o Woocomerce
    require '../../vendor/autoload.php';
    use Automattic\WooCommerce\Client;

    // Credências de acesso/conexão com o Woocomerce
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

    // Verifica se o Lote já existe
    $consulta = "SELECT * FROM Lote WHERE evento = '$idEvento' AND nome = '$nome'";
    $dados = selecionar($consulta);
    if($dados[0]['id'] == ""){
        // Criar Lote
        $consulta = "INSERT INTO `Lote`(`nome`, `evento`, `valor`, `quantidade`) VALUES ('$nome', '$idEvento', '$valor', '$quantidade')";
        $msg = executar($consulta);
        if($msg == "Sucesso!"){
            // Criar Lote WP 
            try {
                criarLoteWP();
                header('Location: index.php?msg='.$msg);
            } catch (\Throwable $th) {
                header('Location: https://api.whatsapp.com/send?phone=5567999854042&text=Oi%2C%20tudo%20bem%3F%20Estava%20criando%20um%20lote%20para%20meu%20evento%20no%20App%2C%20mas%20deu%20um%20erro%2C%20poderia%20me%20ajudar%3F');
            }
            
        }else{
            header('Location: https://api.whatsapp.com/send?phone=5567999854042&text=Oi%2C%20tudo%20bem%3F%20Estava%20criando%20um%20lote%20para%20meu%20evento%20no%20App%2C%20mas%20deu%20um%20erro%2C%20poderia%20me%20ajudar%3F');
        }  
    }else{
        $msg = "Já existe um lote cadastrado na plataforma com esse nome, por favor utilize um nome diferente";
        header('Location: ./adicionar.php?msg='.$msg);
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
        
        $result =  json_encode($woocommerce->put('products/'.$idWP, $data));
    }

    
?>