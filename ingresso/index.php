<?php
    include('../app/includes/verificarAcesso.php');
    require ("../app/mail/PHPMailerAutoload.php");
    $mail = new PHPMailer();
    $mail->IsSMTP();

    $promoter = 1;
    $secret = 'ingressozapp258mudancastatus';
    $log =  file_get_contents('php://input');
    
    $server = json_encode($_SERVER, true);
    $msg = salvarLog($log, $server);
    
    if($msg == "Sucesso!"){
        $pedido = json_decode($log, true);
        $numeroPedido = $pedido['id'];
        if(verificarPedido($numeroPedido)){
            // Pagamento Realizado - Processando entrega do Pedido
            if($pedido['status'] == "processing"){
                // Emitir Ingresso
                $hash = bin2hex(openssl_random_pseudo_bytes(32));
                $idPedido = $pedido['id'];
                getDadosComprador();
                $itens = $pedido['line_items'];
                gerarIngressos();
                enviarIngresso($hash, $senderEmail, $senderName, $idEvento, $nomeEvento);
            }
        }else{

        }
        
    }else{
        $msg = "Erro ao registrar log";
        echo $msg;
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
        echo "Id do Cliente:". $idCliente . "<br>";
        //Retorna um código de 6 dígitos nunca usado
        $codigo = gerarCodigo();
        echo "Código do Ingresso Gerado: ". $codigo . "<br>";
        //Gera o Ingresso
        $msg  = gerarIngresso($codigo, $idEvento, $idCliente, $valor, $idLote, $promoter);
    }

    function gerarIngressos(){
        global $idLote, $itemAmount, $itemQuantity, $senderName, $telefone, $senderEmail, $idEvento, $itens, $nomeEvento;
        // Para cada Item do carrinho acessa os dados 
        foreach ($itens as $item) { 
            $itemQuantity = $item['quantity'];
            $idLote = $item['sku'];
            if(getLote()){
                // Para cada quantidade solicitada pelo cliente cria um ingresso.
                for ($i=1; $i <= $itemQuantity; $i++) { 
                    criarIngresso();
                }
            }else{
                echo "<h1>Erro ao pegar dados do Lote</h1>";
            }
        }
        
    }

    function getDadosComprador(){
        global $pedido, $senderName, $telefone, $senderEmail;
        $comprador = $pedido['billing'];
        $senderName = $comprador['first_name'];
        $telefone = $comprador['last_name'];
        $senderEmail = $comprador['email'];
    }
    function salvarLog($log, $server){
        $consulta = "INSERT INTO `LogApi`( `log`,`server`) VALUES ('$log', '$server')";
        $msg = executar($consulta);
        return $msg;
    }

    // Pega todos os dados do lote do ingresso
    function getLote(){
        global $idLote, $valor, $sexo, $quantidade, $vendidos, $idEvento, $nomeEvento;
        $consulta = "SELECT Lote.id, Lote.nome, Lote.valor, Lote.quantidade, Lote.vendidos, Evento.id as idEvento, Evento.nome as nomeEvento FROM Lote JOIN Evento ON Lote.evento = Evento.id WHERE Lote.id='$idLote'";
        $obj = selecionar($consulta);
        $lote = $obj[0];
        $valor     =  $lote['valor'];
        $sexo      =  $lote['sexo'];
        $quantidade=  $lote['quantidade'];
        $vendidos  =  $lote['vendidos'];
        $idEvento=  $lote['idEvento'];
        $nomeEvento  =  $lote['nomeEvento'];
        if($valor == "" || $quantidade == ""){
            echo "Dados insuficientes sobre o lote.";
            return false;
        }else{
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
        global $hash;
        if($promoter == ''){
            $promoter = '1';
        }
        $consulta = "INSERT INTO Ingresso (codigo, evento, vendedor, idCliente, valor, lote, origem, hash) VALUES ('$codigo', '$idEvento', '$promoter', '$idCliente', '$valor', '$idLote', 2, '$hash')";
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
        if($quantidade < $vendidos){
            $consulta = "UPDATE Lote SET validade = 'ESGOTADO' WHERE id = $idLote ";
            $msg = executar($consulta);
            if($msg == 'Sucesso!'){
                emailVirada();
            }else{
                echo "Falha ao invalidar Lote!!!<br>"; 
            }
        }
        $consulta = "UPDATE `Lote` SET `vendidos`=(SELECT COUNT(Ingresso.codigo) FROM Ingresso WHERE Ingresso.lote = '$idLote') WHERE Lote.id = '$idLote'";
        $msg = executar($consulta);    
        if($msg == "Sucesso!"){
            return true;
        }else{
            return false;
        }
    }

    function enviarIngresso($hash, $senderEmail, $senderName, $idEvento, $nomeEvento){
        $assunto = "Seus Ingressos para o evento ".$nomeEvento." estão aqui!!!";
        $msg = "
        <img style='width: 40%; margin-left:30%;' src='http://ingressozapp.com/app/getImagem.php?id=$idEvento'/>
        <h1 style='text-align:center'>🎉 ".$nomeEvento." 🎉</h1><br>
        <h3 style='text-align:center'>Olá ".$senderName." você acaba de adquirir um ingresso, utilizando o aplicativo IngressoZapp!!!</h3><br>
        <br>
        <h2 style='text-align:center' >Para acessar os ingressos clique no link: <br>
        http://ingressozapp.com/app/ingressos/?hash=".$hash."</h2><br>
        <br>
        ";
        $aviso = "
        🔐 AVISOS 🔐<br>
        Lembramos que o QR CODE de verificação só poderá ser usado uma vez, sendo considerado INVÁLIDO numa segunda tentativa de entrada. Por isso, não compartilhe uma imagem do ingresso sem antes tampar completamente o QR CODE. <br>
        Saiba mais sobre o aplicativo IngressoZapp e nosso sistema anti-fraude de gerenciamento de eventos em nosso site: www.ingressozapp.com <br></h4>
        ";
        $corpo = $msg . $aviso;
        return enviaEmail($senderEmail, $senderName, $assunto, $corpo);
    }

    function enviaEmail($email, $nome, $assunto, $corpo){
        global $mail;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = '587';
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;

        $mail->Username = "ingressozapp@gmail.com";
        $mail->Password = "ymgbfpnftoewiipd";
        $mail->From = 'ingressozapp@gmail.com';
        $mail->Sender = 'ingressozapp@gmail.com';
        $mail->FromName = 'IngressoZapp';

        $mail->AddAddress($email, $nome);

        $mail->IsHTML(true);
        $mail->CharSet = 'utf-8';
        $mail->Subject = $assunto;
        $mail->Body = $corpo;
        $mail->AltBody = 'Para ler este e-mail Ã© necessÃ¡rio um leitor de e-mail que suporte mensagens em HTML.';
        $enviado = $mail->Send();
        $mail->ClearAllRecipients();
        $mail->ClearAttachments();
        $mail->SMTPDebug = true;
        return $enviado;
    }


?>