<?php
    include('../app/includes/verificarAcesso.php');

    $idLote = 7288;
    $idEvento = 221;
    $itemAmount = 1;
    $senderName = $_POST['senderName'];
    $telefone = $_POST['inputTelefone'];
    $senderEmail = $_POST['senderEmail'];
    $promoter = 2;
    $hash = bin2hex(openssl_random_pseudo_bytes(32));

    getLote();
    criarIngresso();
    enviarIngresso($hash, $senderEmail, $senderName, $idEvento, $nomeEvento);
    header('Location: ../index.php');


    // Pega todos os dados do lote do ingresso
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
            return true;
        }
    }

    function criarIngresso(){
        global $idLote, $itemAmount, $senderName, $telefone, $idEvento, $promoter;
        //Se for novo cria o cliente, se ja tiver telefone, atualiza o nome e retorna o id do cliente
        $idCliente = getCliente($senderName, $telefone);
        echo $idCliente."<br>";
        //Retorna um código de 6 dígitos nunca usado
        $codigo = gerarCodigo();
        echo $codigo."<br>";
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
        $consulta = "UPDATE `Lote` SET `vendidos`=`vendidos` + 1 WHERE `id` = '$idLote'";
        $msg = executar($consulta);    
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