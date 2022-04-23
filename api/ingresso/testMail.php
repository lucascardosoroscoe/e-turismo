<?php
    include('../../app/includes/verificarAcesso.php');
    
    enviaEmail("lucascardosoroscoe@gmail.com", "Lucas", "Teste", "Teste");
    function enviaEmail($email, $nome, $assunto, $corpo){
        require ("../../app/mail/PHPMailerAutoload.php");
        $mail = new PHPMailer();
        $mail->IsSMTP();

        $mail->SMTPDebug = 2;
        $mail->Host = 'smtp.hostinger.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;


        $mail->Username = 'ingresso@ingressozapp.com';
        $mail->Password = '@Baba123258';


        $mail->setFrom('ingresso@ingressozapp.com', 'IngressoZapp');
        $mail->addReplyTo('ingresso@ingressozapp.com', 'IngressoZapp');
        $mail->AddAddress($email, $nome);


        $mail->Subject = 'Testing PHPMailer';
        $mail->Subject = $assunto;
        $mail->msgHTML(file_get_contents('message.html'), __DIR__);
        $mail->IsHTML(true);
        $mail->Body = $corpo;
        //$mail->addAttachment('test.txt');
        if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'The email message was sent.';
        }
        $mail->ClearAllRecipients();
        $mail->ClearAttachments();
        $mail->SMTPDebug = true;
    }
?>