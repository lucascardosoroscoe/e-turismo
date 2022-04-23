<?php
    include('../includes/verificarAcesso.php');
    $selectTipo = $_POST['selectTipo'];
    $email = $_POST['inputEmailAddress'];
    if($selectTipo == 2){
        verificarProdutor($email);
    }else if($selectTipo == 3){
        verificarPromoter($email);
    }else if($selectTipo == 4){
        verificarCliente($email);
    }


    function verificarProdutor($email){
        $consulta = "SELECT * FROM `Produtor` WHERE `email` = '$email'";
        $dados = selecionar($consulta);
        if($dados[0] == ""){
            $msg = "Usuário de produtor não encontrado no sistema, crie seu cadastro.";
            header('Location: ../produtores/adicionar.php?msg='.$msg.'&email='.$email);
        }else{
            enviarRedefinicao();
        }
    }

    function verificarPromoter($email){
        $consulta = "SELECT * FROM `Vendedor` WHERE `email` = '$email'";
        $dados = selecionar($consulta);
        if($dados[0] == ""){
            $msg = "Usuário de promoter não encontrado no sistema, peça para que o produtor do evento faça seu cadastro.";
            header('Location: ./index.php?msg='.$msg);
        }else{
            enviarRedefinicao();
        }
    }

    function verificarCliente($email){
        $consulta = "SELECT * FROM `Cliente` WHERE `email` = '$email'";
        $dados = selecionar($consulta);
        if($dados[0] == ""){
            $msg = "Usuário de cliente não encontrado no sistema, crie seu cadastro.";
            header('Location: ./register.php?msg='.$msg.'&email='.$email);
        }else{
            enviarRedefinicao();
        }
    }

    function enviarRedefinicao(){
        global $email, $selectTipo;
        $consulta = "UPDATE `RedifinirSenha` SET `status`= 3 WHERE `email` = '$email'";
        $msg = executar($consulta);
        $hash = bin2hex(random_bytes(36));
        $consulta = "INSERT INTO `RedifinirSenha`(`hash`, `email`, `tipoUsuario`) VALUES ('$hash', '$email', '$selectTipo')";
        $msg = executar($consulta);
        if($msg == "Sucesso!"){
            $assunto = "Redefinição de senha IngressoZapp";
            $nome = "usuário";
            $corpo = "
            <h4 style='text-align:center;'>Clique no link abaixo para redefinir sua senha:<h4><br>
            <a style='text-align:center;' href='www.ingressozapp.com/app/login/recover.php?hash=".$hash."'>www.ingressozapp.com/login/recover.php</a>
            ";
            if(enviaEmail($email, $nome, $assunto, $corpo)){
                $msg = "E-mail de redefinição de senha enviado com sucesso!";
                header('Location: ./index.php?msg='.$msg);
            }else{
                $msg = "Falha ao enviar e-mail de redefinição de senha";
                header('Location: ./index.php?msg='.$msg);
            };
        }
    }

    function enviaEmail($email, $nome, $assunto, $corpo){
        require ("../mail/PHPMailerAutoload.php");
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