<?php
    $assunto = $_GET['assunto'];
    $mensagem = $_GET['mensagem'];
    $destinatario = $_GET['destinatario'];
    $local = $_GET['local'];

    require 'PHPMailer/PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer;
// Set PHPMailer to use the sendmail transport
$mail->isSendmail();
//Set who the message is to be sent from
$mail->setFrom('contato@ingressozapp.com', 'IngressoZapp');
//Set an alternative reply-to address
$mail->addReplyTo('lucascardosoroscoe@gmail.com', 'Lucas Roscoe');
//Set who the message is to be sent to
$mail->addAddress($destinatario, $destinatario);
//Set the subject line
$mail->Subject = $assunto;
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML($mensagem);
//Replace the plain text body with one created manually
$mail->AltBody = $mensagem;
//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
if (!$mail->send()) {
    echo "E-mail de Aviso imortante não enviado!!! <br>";
    echo "Por favor entre em contato com o seu produtor de eventos e de o seguinte aviso: <br>";
    echo "Assunto: ".$assunto;
    echo "Mensagem: ".$mensagem;

} else {
    echo $assunto;
    echo $mensagem;
    echo $destinatario;
    echo "Message sent!";
    echo $local;
    //header('Location: '.$location);
}
    
?>