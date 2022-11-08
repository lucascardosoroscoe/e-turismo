<?php
    include('../app/includes/verificarAcesso.php');

    $senderEmail = $_POST['email'];
    $senderName = $_POST['senderName'];
    $telefone = $_POST['inputTelefone'];
    $hash = bin2hex(openssl_random_pseudo_bytes(32));

    $idLote = 7243;
    $itemAmount = 0.00;
    $idEvento = 214;
    $nomeEvento = "VINTAGE CULTURE - 11/03";
    $promoter = 2;

    $consulta = "SELECT * FROM `STBTransferencia` WHERE `email` = '$senderEmail'";
    $dados = selecionar($consulta);
    $trasferencia = $dados[0];
    if($trasferencia == ""){
        header('Location: ./inesistente/');
    }else{
        foreach ($dados as $trasferencia) {
            $status = $trasferencia['status'];
            if($status == 0){
                $quantidade = $trasferencia['quantidade'];
                for ($i=1; $i <= $quantidade; $i++) { 
                    criarIngresso();
                }
                $msg = enviarIngresso($hash, $senderEmail, $senderName, $idEvento, $nomeEvento); 
                trocarStatus();
                header('Location: ./sucesso/');
            }else{
                echo "<h1> Seus ingressos registrados nesse e-mail já foram transferidos para o evento do Vintage Culture dia 11/03/2022. Você recebeu um e-mail de ingressozapp@gmail.com com o ingresso</h1>";
                header('Location: ./transferidos/');
            }
        }
        
    }

    function trocarStatus(){
        global $senderEmail;
        $consulta = "UPDATE `STBTransferencia` SET `status`= 1 WHERE `email` = '$senderEmail'";
        $msg = executar($consulta);
    }


    function criarIngresso(){
        global $idLote, $itemAmount, $senderName, $telefone, $idEvento, $promoter;
        //Se for novo cria o cliente, se ja tiver telefone, atualiza o nome e retorna o id do cliente
        $idCliente = getCliente($senderName, $telefone);
        //Retorna um código de 6 dígitos nunca usado
        $codigo = gerarCodigo();
        //Gera o Ingresso
        $msg  = gerarIngresso($codigo, $idEvento, $idCliente, $itemAmount, $idLote, $promoter);
    }


    function getCliente($nomeCliente, $telefone){
        
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
        global $hash;
        if($promoter == ''){
            $promoter = '1';
        }
        $consulta = "INSERT INTO Ingresso (codigo, evento, vendedor, idCliente, valor, lote, origem, hash) VALUES ('$codigo', '$idEvento', '$promoter', '$idCliente', '$valor', '$idLote', 2, '$hash')";
        $msg = executar($consulta);
        return true;
        
    }


    
    function enviarIngresso($hash, $senderEmail, $senderName, $idEvento, $nomeEvento){
        $assunto = "Seus Ingressos para o evento ".$nomeEvento." estão aqui!!!";
        $msg = "
        <img style='width: 40%; margin-left:30%;' src='https://ingressozapp.com/app/getImagem.php?id=$idEvento'/>
        <h1 style='text-align:center'>🎉 ".$nomeEvento." 🎉</h1><br>
        <h3 style='text-align:center'>Olá ".$senderName." você acaba de trocar seu ingresso, do evento Só Track Boa Campo Grande 2020 para o eventos Vintage Culture em Campo grande dia 11/03, utilizando o aplicativo IngressoZapp!!!</h3><br>
        <br>
        <h2 style='text-align:center' >Para acessar os ingressos clique no link: <br>
        https://ingressozapp.com/app/ingressos/?hash=".$hash."</h2><br>
        <br>
        ";
        $aviso = "
        🔐 AVISOS 🔐<br>
        TIRE UM PRINT DO QR CODE PARA AGILIZAR NA PORTARIA <br>Lembramos que o QR CODE de verificação só poderá ser usado uma vez, sendo considerado INVÁLIDO numa segunda tentativa de entrada. Por isso, não compartilhe uma imagem do ingresso sem antes tampar completamente o QR CODE. <br>
        Saiba mais sobre o aplicativo IngressoZapp e nosso sistema anti-fraude de gerenciamento de eventos em nosso site: www.ingressozapp.com <br></h4>
        ";
        $corpo = $msg . $aviso;
        return enviaEmail($senderEmail, $senderName, $assunto, $corpo);
    }

    
    function enviaEmail($email, $nome, $assunto, $corpo){
        require ("../app/mail/PHPMailerAutoload.php");
        $mail = new PHPMailer();
        $mail->IsSMTP();
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