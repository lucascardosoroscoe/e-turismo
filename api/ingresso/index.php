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
 
    //Dados da integração
    $promoter = 1;
    // conferir o Secret para dar mais segurança
    $secret = 'ingressozapp258mudancastatus';


    $log =  file_get_contents('php://input');
    
    // salvar Log 
    $server = json_encode($_SERVER, true);
    
    $pedido = json_decode($log, true);
    $servidor = json_decode($server, true);
    $numeroPedido = $pedido['id'];
    $payment_url = $servidor['HTTP_X_WC_WEBHOOK_SOURCE'];
    $msg = salvarLog($log, $server, $numeroPedido, $payment_url);
    // Se Log foi salvo corretamente 
    if($msg == "Sucesso!"){
        if($payment_url == "https://ingressozapp.com/"){
            //Verifica se já foi gerado ingresso para esse pedido e garante que o ingresso não foi gerado novamente
            if(verificarPedido($numeroPedido)){
                // Pagamento Realizado - Processando entrega do Pedido
                if($pedido['status'] == "processing"){
                    // Emitir Ingresso
                    //Gerar Hash Identificados dos ingressos
                    $hash = bin2hex(openssl_random_pseudo_bytes(32));

                    // Pegar dados do pedido e do comprador
                    $idPedido = $pedido['id'];
                    getDadosComprador();
                    $itens = $pedido['line_items'];
                    $coupon = $pedido['coupon_lines'][0]['code'];
                    if($coupon != ""){
                        if($coupon == "PANTANAL10"||$coupon == "PANTA10"){
                            $desconto = "1";
                        }else{
                            getVendedor($coupon);
                        }
                    }
                    if(gerarIngressos()){
                        enviarIngresso($hash, $senderEmail, $senderName, $idEvento, $nomeEvento);
                        statusCompleted();
                    }else{
                        $msg = 'Erro ao gerar ingressos. <br>'.
                        'URL de Origem: ' . $payment_url . '<br>' .
                        'Pedido: ' . $numeroPedido;
                        alerta($msg, $numeroPedido, '1', $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                    };
                } 
            }
        }else if($payment_url == "https://prefeitosdofuturo.com.br/"){
            $promoter = 956;
            // Pagamento Realizado - Processando entrega do Pedido
            if($pedido['status'] == "processing"){
                // Emitir Ingresso
                $hash = bin2hex(openssl_random_pseudo_bytes(32));
                $idPedido = $pedido['id'];
                getDadosCompradorCorreto();
                $itens = $pedido['line_items'];
                $coupon = $pedido['coupon_lines'][0]['code'];
                gerarIngressos();
                enviarIngresso($hash, $senderEmail, $senderName, $idEvento, $nomeEvento);
            } 
        }else{
            $msg = 'Tentativa de gerar ingresso de domínio não autorizado. <br>'.
            'URL de Origem: ' . $payment_url . '<br>' .
            'Pedido: ' . $numeroPedido;
            alerta($msg, $numeroPedido, '1', $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
        }
        
        
    }else{
        $msg = 'Erro ao registrar log. <br>'.
        'URL de Origem: ' . $payment_url . '<br>' .
        'Pedido: ' . $numeroPedido;
        
        alerta($msg, $numeroPedido, '1', $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    }

    function getVendedor($coupon){
        global $idVendedor;
        $consulta = "SELECT id FROM `Vendedor` WHERE `email` = '$coupon'";
        $dados = selecionar($consulta);
        $idVendedor = $dados[0]['id'];
    }

    function verificarPedido($numeroPedido){
        $consulta = "SELECT `codigo` FROM `Ingresso` WHERE `pedido` = '$numeroPedido'";
        $dados = selecionar($consulta);
        if($dados[0]['codigo'] == ""){
            return 1;
        }else{
            return 0;
        }
    }
    function criarIngresso(){
        global $idLote, $valor, $senderName, $senderEmail, $telefone, $idEvento, $promoter;
        // Se for novo cria o cliente, se ja tiver telefone, atualiza o nome e retorna o id do cliente
        $idCliente = getCliente($senderName, $telefone, $senderEmail);
        //Retorna um código de 6 dígitos nunca usado
        $codigo = gerarCodigo();
        //Gera o Ingresso
        $msg  = gerarIngresso($codigo, $idEvento, $idCliente, $valor, $idLote, $promoter);
    }

    function gerarIngressos(){
        global $idLote, $itemAmount, $itemQuantity, $valor, $numeroPedido, $payment_url, $idEvento, $itens;
        // Para cada Item do carrinho acessa os dados 
        foreach ($itens as $item) { 
            $itemQuantity = $item['quantity'];
            $itemAmount = $item['price'];
            $idLote = $item['sku'];
            if(getLote()){
                if($valor<$itemAmount){
                    // Para cada quantidade solicitada pelo cliente cria um ingresso.
                    // $msg = salvarLog("Valor CORRETO", $valor);
                    for ($i=1; $i <= $itemQuantity; $i++) { 
                        criarIngresso();
                    }
                    $x = true;
                }else if($idEvento == '632'||$idEvento == '744'){
                    for ($i=1; $i <= $itemQuantity; $i++) { 
                        criarIngresso();
                    }
                    $x = true;
                }else{
                    $msg = salvarLog("Valor do lote SKU abaixo do permitido para gerar ingresso.", $valor, $numeroPedido, $payment_url);
                    $msg = 'Valor do lote SKU abaixo do permitido para gerar ingresso. Atualize o valor do lote no wp-admin para que fique pelo menos no valor do ingresso no app.<br>'.
                    'SKU: ' . $idLote . '<br>' .
                    'Quantidade de ingressos: ' . $itemQuantity . '<br>' .
                    'Valor no Site: ' . $itemAmount . '<br>' .
                    'Valor no app: ' . $valor . '<br>' .
                    'URL de Origem: ' . $payment_url . '<br>' .
                    'Pedido: ' . $numeroPedido;
                    alerta($msg, $numeroPedido, '1', $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                    $x = false;
                }
            }else{
                $x = false;
            }
            
        }
        return $x;  
        
    }

    function getDadosComprador(){
        global $pedido, $senderName, $telefone, $senderEmail;
        $comprador = $pedido['billing'];
        $senderName = $comprador['first_name'];
        $telefone = $comprador['last_name'];
        $senderEmail = $comprador['email'];
    }
    function getDadosCompradorCorreto(){
        global $pedido, $senderName, $telefone, $senderEmail;
        $comprador = $pedido['billing'];
        $senderName = $comprador['first_name'];
        $senderName = $senderName . " " . $comprador['last_name'];
        $telefone = $comprador['phone'];
        $senderEmail = $comprador['email'];
    }
    function salvarLog($log, $server, $numeroPedido, $payment_url){
        $consulta = "INSERT INTO `LogApi`( `log`,`server`,`pedido`,`url`) VALUES ('$log', '$server', '$numeroPedido', '$payment_url')";
        $msg = executar($consulta);
        return $msg;
    }

    // Pega todos os dados do lote do ingresso
    function getLote(){
        global $idLote, $valor, $sexo, $quantidade, $vendidos, $idEvento, $nomeEvento, $payment_url, $numeroPedido;
        $consulta = "SELECT Lote.id, Lote.nome, Lote.valor, Lote.quantidade, Lote.validade, Lote.vendidos, Evento.id as idEvento, Evento.nome as nomeEvento FROM Lote JOIN Evento ON Lote.evento = Evento.id WHERE Lote.id='$idLote'";
        $obj = selecionar($consulta);
        $lote = $obj[0];
        $valor     =  $lote['valor'];
        $sexo      =  $lote['sexo'];
        $quantidade=  $lote['quantidade'];
        $vendidos  =  $lote['vendidos'];
        $idEvento=  $lote['idEvento'];
        $nomeEvento  =  $lote['nomeEvento'];
        $validade  =  $lote['validade'];
        if($valor == "" || $quantidade == ""){
            $msg = 'Erro ao pegar dados do Lote. Não foi encontrado nenhum lote disponível no app com o SKU informado no WP-admin<br>'.
                'SKU: ' . $idLote . '<br>' .
                'Valor no app: ' . $valor . '<br>' .
                'quantidade: ' . $quantidade . '<br>' .
                'vendidos: ' . $vendidos . '<br>' .
                'idEvento: ' . $idEvento . '<br>' .
                'nomeEvento: ' . $nomeEvento . '<br>' .
                'URL de Origem: ' . $payment_url . '<br>' .
                'Pedido: ' . $numeroPedido;
            alerta($msg, $numeroPedido, '1', $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            
            return false;
        }else{
            if($validade!= 'DISPONÍVEL'){
                $msg = 'Ingresso vendido pelo site para um lote que não está mais válido no app. favor verificar o lote no wp-admin e no app. Caso esteja realmente desativado no app. Desative imediatamente no wo-admin. <br>'.
                'SKU: ' . $idLote . '<br>' .
                'Valor no app: ' . $valor . '<br>' .
                'quantidade: ' . $quantidade . '<br>' .
                'vendidos: ' . $vendidos . '<br>' .
                'idEvento: ' . $idEvento . '<br>' .
                'nomeEvento: ' . $nomeEvento . '<br>' .
                'URL de Origem: ' . $payment_url . '<br>' .
                'Pedido: ' . $numeroPedido;
            alerta($msg, $numeroPedido, '1', $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            }
            return true;
        }
    }

    function getCliente($nomeCliente, $telefone, $senderEmail){
        
        $consulta = "SELECT `id` FROM `Cliente` WHERE `telefone` = '$telefone'";
        $dados = selecionar($consulta);
        if($dados[0]['id'] == ""){
            $consulta = "INSERT INTO `Cliente`(`nome`, `telefone`, `email`) VALUES ('$nomeCliente', '$telefone', '$senderEmail')";
            echo "Criando Cliente: <br>Nome: ".$nomeCliente."<br>Telefone: ".$telefone."<br>";
            $msg = executar($consulta);
            if($msg == "Sucesso!"){
                $consulta = "SELECT `id` FROM `Cliente` WHERE `nome` = '$nomeCliente' AND `telefone` = '$telefone'";
                $dados = selecionar($consulta);
                $idCliente = $dados[0]['id'];
                // echo "Cliente Criado com Sucesso: <br>Id: ".$idCliente."<br>";
            }else{
                echo "Erro ao criar Cliente!!!<br>";
                echo $consulta . "<br>";
            }
        }else{
            // echo "Cliente já existe no sistema.<br>";
            $idCliente = $dados[0]['id'];
            $consulta = "UPDATE `Cliente` SET `nome`='$nomeCliente',  `email`='$senderEmail' WHERE `id` = '$idCliente'";
            $msg = executar($consulta);
            if($msg == "Sucesso!"){
                // echo "Nome do Cliente atualizado com sucesso.<br>";
            }else{
                echo "Erro ao atualizar nome do Cliente.<br>";
            }
        }
        return $idCliente;
    }   

    function gerarCodigo(){
        $codigo = 0;
        while ($codigo == 0) {
            $codigo    =  rand ( 100000 , 999999 );
            $consulta = "SELECT * FROM `Ingresso` WHERE `codigo` = '$codigo'";
            $dados = selecionar($consulta);
            if($dados[0] != ""){
                echo "Código ". $codigo ." já existe, gerando novo código.";
                $codigo = 0;
            }
        }
        return $codigo; 
    }

    function gerarIngresso($codigo, $idEvento, $idCliente, $valor, $idLote, $promoter){
        global $hash, $numeroPedido, $idVendedor, $vendidos;
        if($idVendedor == ''){
            $promoter = '1';
        }else{
            $promoter = $idVendedor;
        }
        $vendidos ++;
        $consulta = "INSERT INTO Ingresso (codigo, evento, vendedor, idCliente, pedido, valor, lote, origem, hash) VALUES ('$codigo', '$idEvento', '$promoter', '$idCliente', '$numeroPedido', '$valor', '$idLote', 2, '$hash')";
        $msg = executar($consulta);
        if($msg == "Sucesso!"){
            echo "Ingresso Gerado com Sucesso!<br>";
            if(atualizarVendidosLote($idLote)){
                echo "Quantidade de ingressos Vendidos atualizada com Sucesso!<br>";
                return true;
            }else{
                return false;
            }
            
        }else{
            echo "Erro ao gerar Ingresso";
            return false;
        }
        
    }
    function atualizarVendidosLote($idLote){
        global $vendidos, $idLote, $quantidade;
        if($quantidade <= $vendidos){
            $consulta = "UPDATE Lote SET validade = 'ESGOTADO' WHERE id = $idLote ";
            $msg = executar($consulta);
            if($msg == 'Sucesso!'){
                emailVirada();
            }else{
                echo "Falha ao invalidar Lote!!!<br>";
            }
            esgotarWP(); 
        }
        $consulta = "UPDATE `Lote` SET `vendidos`=(SELECT COUNT(Ingresso.codigo) FROM Ingresso WHERE Ingresso.lote = '$idLote') WHERE Lote.id = '$idLote'";
        $msg = executar($consulta);   
        
        if($msg == "Sucesso!"){
            return true;
        }else{
            return false;
        }
    }

    function esgotarWP(){
        global $idLote, $woocommerce, $idEvento;
        
        $consulta = "SELECT * FROM `Lote` WHERE `id` = '$idLote'";
        $dados = selecionar($consulta);
        $idVariacao = $dados[0]['idVariacao'];
        $link = 'products/' . $idEvento . '/variations' .'/'.$idVariacao;
        try {
            echo json_encode($woocommerce->delete( $link , ['force' => true]));
        } catch (Throwable $th) {}
    }

    function statusCompleted(){
        global $woocommerce, $pedido;
        $idPedido =  $pedido['id'];
        $data = [
            'status' => 'completed'
        ];
        $string = 'orders/'. $idPedido;
        $woocommerce->put($string, $data);
    }

    function enviarIngresso($hash, $senderEmail, $senderName, $idEvento, $nomeEvento){
        $assunto = "Seus Ingressos para o evento ".$nomeEvento." estão aqui!!!";
        $msg = "
        <img style='width: 40%; margin-left:30%;' src='https://ingressozapp.com/app/getImagem.php?id=$idEvento'/>
        <h1 style='text-align:center'>🎉 ".$nomeEvento." 🎉</h1><br>
        <h3 style='text-align:center'>Olá ".$senderName." você acaba de adquirir um ingresso, utilizando o aplicativo IngressoZapp!!!</h3><br>
        <br>
        <h2 style='text-align:center' >Para acessar os ingressos clique no Botão: <br></h2>
        <a href='https://ingressozapp.com/app/ingressos/?hash=".$hash."' style='color: #fff;background-color: #000000;padding: 20px 50px;margin-top: 20px !important;border-radius: 24px;font-size: large; text-decoration: none;display: block;'>Visualizar Ingresso</a><br>
        <br>
        ";
        enviaEmail($senderEmail, $senderName, $assunto, $msg);
    }

    


?>