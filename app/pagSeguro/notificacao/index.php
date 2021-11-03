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

    if ($status == '3'){
        //Paga: 3 
        getDadosTransacao($reference);
        if($statusAnterior == 1 || $statusAnterior == 2){
            for ($i=1; $i <= $itemQuantity; $i++) { 
                criarIngresso();
            }
        }
    }
    atualizarStatusBD($reference, $status);
    
    function atualizarStatusBD($reference, $status){
        $data = date('Y-m-d h:i:s');
        $consulta = "UPDATE `PedidoPagSeguro` SET `updateAt`='$data',`status`='$status' WHERE `id` = '$reference'";
        $msg = executar($consulta);
        return $msg;
    }

    function getDadosTransacao($reference){
        global $idLote, $itemAmount, $itemQuantity, $senderName, $telefone, $senderEmail, $statusAnterior, $evento;
        $consulta = "SELECT PedidoPagSeguro.idLote, PedidoPagSeguro.itemAmount,  PedidoPagSeguro.itemQuantity,  
        PedidoPagSeguro.senderName,  PedidoPagSeguro.senderAreaCode,  PedidoPagSeguro.senderPhone,  PedidoPagSeguro.senderEmail,
        PedidoPagSeguro.status, Lote.evento
        FROM PedidoPagSeguro 
        JOIN Lote ON Lote.id = PedidoPagSeguro.idLote 
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
        $evento = $dados[0]['evento'];
    }

    function criarIngresso(){
        global $idLote, $itemAmount, $senderName, $telefone, $senderEmail, $evento;
        $idCliente = getCliente($senderName, $telefone);
        $codigo = gerarCodigo();
        gerarIngresso($codigo, $evento, $idCliente, $itemAmount, $idLote);
        $return = enviarIngresso($codigo, $senderEmail); 
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

    function gerarIngresso($codigo, $evento, $idCliente, $valor, $idLote){
        $consulta = "INSERT INTO Ingresso (codigo, evento, vendedor, idCliente, valor, lote) VALUES ('$codigo', '$evento', 1, '$idCliente', '$valor', '$idLote')";
        // echo $consulta;
        $msg = executar($consulta);
        if($msg == "Sucesso!"){
            atualizarVendidosLote(); 
            // echo "Ingresso gerado.";
            return true;
        }else{
            echo "Erro ao gerar Ingresso";
            return false;
        }
        
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
    

    function enviarIngresso($codigo, $senderEmail){
        echo "oi";
    }
?>