<?php
    include('../../includes/verificarAcesso.php');

    //Credenciais de acesso PagSeguro
    $email = 'ingressozapp@gmail.com';
    $token = '0aec9415-f791-4876-a53b-118e007a7069102be8bb4222b8075142ac82ffa3aa9ed3bf-824d-4710-a323-028af0311dab';

    //Recebe o código da notificação e junta ele na URL Pag Seguro para conferir conteúdo da notificação #Medida de segurança para garantir integridade da notificação
    $code = $_POST['notificationCode'];
    $url = 'https://ws.pagseguro.uol.com.br/v3/transactions/notifications/' . $code . '?email=' . $email . '&token=' . $token;
        
    //Chamada GET verificação da notificação
    $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $transaction= curl_exec($curl);
    curl_close($curl);

    //Conversão XML/JSON/ARRAY
    $xml = simplexml_load_string($transaction);
    $json = json_encode($xml);
    $array = json_decode($json,TRUE);

    //Pega Status e referência para os dados
    $status = $array['status'];
    $reference =  $array['reference'];

    //Insere LOG de transação no BD
    $consulta = "INSERT INTO `PagSeguroRetornoLog`(`code`, `log`, `status`) VALUES ('$code' , '$json', '$status')";
    $msg = executar($consulta);

    if ($status == '3' || $status == '4'){
        //Paga: 3 
        //Cancelado: 7 (teste)
        getDadosTransacao($reference);
        if($statusAnterior == 1 || $statusAnterior == 2){
            for ($i=1; $i <= $itemQuantity; $i++) { 
                criarIngresso();
            }
        }
    }

    //Atualiza Status da Transação no banco de dados
    atualizarStatusBD($reference, $status);
    function atualizarStatusBD($reference, $status){
        $data = date('Y-m-d h:i:s');
        $consulta = "UPDATE `PedidoPagSeguro` SET `updateAt`='$data',`status`='$status' WHERE `id` = '$reference'";
        $msg = executar($consulta);
        return $msg;
    }

    function getDadosTransacao($reference){
        global $idLote, $itemAmount, $itemQuantity, $senderName, $telefone, $senderEmail, $statusAnterior, $idEvento, $nomeEvento, $promoter, $emailProdutor;
        $consulta = "SELECT PedidoPagSeguro.idLote, PedidoPagSeguro.itemAmount,  PedidoPagSeguro.itemQuantity,  
        PedidoPagSeguro.senderName,  PedidoPagSeguro.senderAreaCode,  PedidoPagSeguro.senderPhone,  PedidoPagSeguro.senderEmail,
        PedidoPagSeguro.status,PedidoPagSeguro.promoter, Lote.evento as idEvento, Evento.nome as nomeEvento,
        Produtor.email as emailProdutor
        FROM PedidoPagSeguro 
        JOIN Lote ON Lote.id = PedidoPagSeguro.idLote 
        JOIN Evento ON Lote.evento = Evento.id
        JOIN Produtor ON Evento.produtor = Produtor.id
        WHERE PedidoPagSeguro.id = '$reference'";
        $dados = selecionar($consulta);
        $idLote = $dados[0]['idLote'];
        $itemAmount = $dados[0]['itemAmount'];
        $itemQuantity = $dados[0]['itemQuantity'];
        $senderName = $dados[0]['senderName'];
        $senderAreaCode = $dados[0]['senderAreaCode'];
        $senderPhone = $dados[0]['senderPhone'];
        $telefone = $senderAreaCode . $senderPhone;
        $senderEmail = $dados[0]['senderEmail'];
        $statusAnterior = $dados[0]['status'];
        $idEvento = $dados[0]['idEvento'];
        $nomeEvento = $dados[0]['nomeEvento'];
        $promoter = $dados[0]['promoter'];
        $emailProdutor = $dados[0]['emailProdutor'];
        getLote();
    }

    function getLote(){
        global $idLote, $valor, $sexo, $quantidade, $vendidos;
        $consulta = "SELECT * FROM Lote WHERE id='$idLote'";
        $obj = selecionar($consulta);
        $lote = $obj[0];
        $valor     =  $lote['valor'];
        $sexo      =  $lote['sexo'];
        $quantidade=  $lote['quantidade'];
        $vendidos  =  $lote['vendidos'];
        $vendidos  =  $vendidos + 1 ;
        if($valor == "" || $quantidade == ""){
            echo "Dados insuficientes sobre o lote.";
            return false;
        }else{
            // echo "Lote carregado com sucesso!";
            return true;
        }
    }

    function criarIngresso(){
        global $idLote, $itemAmount, $senderName, $telefone, $senderEmail, $idEvento, $nomeEvento, $promoter, $emailProdutor;
        //Se for novo cria o cliente, se ja tiver telefone, atualiza o nome e retorna o id do cliente
        $idCliente = getCliente($senderName, $telefone);
        //Retorna um código de 6 dígitos nunca usado
        $codigo = gerarCodigo();
        //Gera o Ingresso
        gerarIngresso($codigo, $idEvento, $idCliente, $itemAmount, $idLote, $promoter);
        //Envia o ingresso Gerado
        $return = enviarIngresso($codigo, $senderEmail, $senderName, $idEvento, $nomeEvento); 
        // $return = emailProdutor($emailProdutor, $senderEmail, $senderName, $idEvento, $nomeEvento); 
    }

    function getCliente($nomeCliente, $telefone){
        $nomeCliente = str_replace('%20', ' ', $nomeCliente);
        $consulta = "SELECT `id` FROM `Cliente` WHERE `telefone` = '$telefone'";
        $dados = selecionar($consulta);
        if($dados[0]['id'] == ""){
            $consulta = "INSERT INTO `Cliente`(`nome`, `telefone`) VALUES ('$nomeCliente', '$telefone')";
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
            $consulta = "UPDATE `Cliente` SET `nome`='$nomeCliente' WHERE `id` = '$idCliente'";
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
        if($promoter == ''){
            $promoter = '1';
        }
        $consulta = "INSERT INTO Ingresso (codigo, evento, vendedor, idCliente, valor, lote, origem) VALUES ('$codigo', '$idEvento', '$promoter', '$idCliente', '$valor', '$idLote', 2)";
        $msg = executar($consulta);
        if($msg == "Sucesso!"){
            atualizarVendidosLote($idLote); 
            return true;
        }else{
            echo "Erro ao gerar Ingresso";
            return false;
        }
        
    }
    
    function atualizarVendidosLote($idLote){
        global $vendidos, $idLote, $quantidade;
        if($quantidade == $vendidos){
            $consulta = "UPDATE Lote SET validade = 'ESGOTADO' WHERE id = $idLote ";
            $msg = executar($consulta);
            if($msg == 'Sucesso!'){
                emailVirada();
            }else{
                echo "Falha ao invalidar Lote!!!<br>";
            }
        }
        $consulta = "UPDATE `Lote` SET `vendidos`='$vendidos' WHERE `id` = '$idLote'";
        $msg = executar($consulta);    
    }

    function enviarIngresso($codigo, $senderEmail, $senderName, $idEvento, $nomeEvento){
        $assunto = "Seu Ingresso para o evento ".$nomeEvento." está aqui!!!";
        $msg = "
        <img style='width: 40%; margin-left:30%;' src='https://ingressozapp.com/app/getImagem.php?id=$idEvento'/>
        <h1 style='text-align:center'>🎉 ".$nomeEvento." 🎉</h1><br>
        <h3 style='text-align:center'>Olá ".$senderName." você acaba de adquirir um ingresso, utilizando o aplicativo IngressoZapp!!!</h3><br>
        <br>
        <h2 style='text-align:center' >Para acessar seu ingresso clique no link: <br>
        https://ingressozapp.com/app/qr.php?codigo=".$codigo." </h2><br>
        <br>
        <h4 style='text-align:center'>Para entrar no evento apresente seu ingresso <b>(CODIGO: ".$codigo.")</b> e um documento original com foto.  <br>
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
    function emailProdutor($emailProdutor, $senderName, $idEvento, $nomeEvento){
        $assunto = "Nova venda pelo site - ".$nomeEvento."!!!";
        $msg = "
        <img style='width: 40%; margin-left:30%;' src='https://ingressozapp.com/app/getImagem.php?id=$idEvento'/>
        <h1 style='text-align:center'>🎉 ".$nomeEvento." 🎉</h1><br>
        <h3 style='text-align:center'>Olá ".$senderName." você acaba de vender um ingresso, utilizando o aplicativo IngressoZapp!!!</h3><br>
        <br>
        <h3Cliente: ".$senderName."</h3><br>
        <br>";
        return enviaEmail($emailProdutor, $senderName, $assunto, $msg);
    }

    function enviaEmail($email, $nome, $assunto, $corpo){
        require ("../../mail/PHPMailerAutoload.php");
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = '587';
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;

        $mail->Username = "ingressozapp@gmail.com";
        $mail->Password = "awzivqyjobvxpvjk";
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