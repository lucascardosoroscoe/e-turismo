<link rel="stylesheet" href="estiloqr.css">
<?php
include('includes/verificarAcesso.php');
verificarAcesso(3);


session_start();
/*session created*/
$codigo    = $_GET['codigo'];
if($codigo == ""){
    $hash    = $_GET['hash'];

    $consulta = "SELECT Ingresso.valor, Ingresso.validade, Ingresso.data,
    Evento.nome as evento, Evento.id as idEvento, Vendedor.nome as vendedor, 
    Cliente.nome as cliente, Cliente.email as email, Cliente.telefone, Lote.nome as lote
    FROM Ingresso 
    JOIN Evento ON Evento.id = Ingresso.evento
    JOIN Vendedor ON Vendedor.id = Ingresso.vendedor
    JOIN Cliente ON Cliente.id = Ingresso.idCliente
    JOIN Lote ON Lote.id = Ingresso.lote
    WHERE Ingresso.hash = '$hash'";
    $ingresso = selecionar($consulta);

    $telefone = $ingresso[0]['telefone'];
    $email = $ingresso[0]['email'];
    $cliente = $ingresso[0]['cliente'];
    $evento = $ingresso[0]['evento'];
    $idEvento = $ingresso[0]['idEvento'];
    $vendedor = $ingresso[0]['vendedor'];
    
    $enviado = enviarIngresso($hash, $email, $cliente, $idEvento, $evento);
    $msg = "🎉 *".$evento."* 🎉
Olá *".$cliente."* você acaba de adquirir ingressos utilizando o aplicativo *IngressoZapp*!!!
    
Para acessar seus ingressos  clique no link: 
http://ingressozapp.com/app/ingressos/?hash=".$hash."
    
Para entrar no evento apresente um print do QR CODE de cada um dos seus ingressos (disponível no link acima) e um documento original com foto.
    
    ";
}else{
    $consulta = "SELECT Ingresso.valor, Ingresso.validade, Ingresso.data,
    Evento.nome as evento, Vendedor.nome as vendedor, Cliente.nome as cliente, Cliente.telefone, Lote.nome as lote
    FROM Ingresso 
    JOIN Evento ON Evento.id = Ingresso.evento
    JOIN Vendedor ON Vendedor.id = Ingresso.vendedor
    JOIN Cliente ON Cliente.id = Ingresso.idCliente
    JOIN Lote ON Lote.id = Ingresso.lote
    WHERE Ingresso.codigo = $codigo";
    $ingresso = selecionar($consulta);
    
    $telefone = $ingresso[0]['telefone'];
    $cliente = $ingresso[0]['cliente'];
    $evento = $ingresso[0]['evento'];
    $vendedor = $ingresso[0]['vendedor'];
    
    $msg = "🎉 *".$evento."* 🎉
Olá *".$cliente."* você acaba de adquirir um ingresso, utilizando o aplicativo *IngressoZapp*!!!
    
Para acessar seu ingresso *salve esse número* e clique no link: 
http://ingressozapp.com/app/qr.php?codigo=".$codigo."
    
Para entrar no evento apresente seu ingresso (*CODIGO: ".$codigo."*) e um documento original com foto.
    
    ";
}

$bar = "
🍻 BAR INGRESSOZAPP 🍻
Você pode garantir 5% de desconto para todas as compras no bar do evento via PIX e ainda ganhar tempo para aproveitar a experiência, evitando filas.
Basta acessar o link abaixo para adicionar um crédito antecipado:
http://ingressozapp.com/produtos/credito-no-bar-ingressozapp/
";
$aviso = "
🔐 AVISOS 🔐
Lembramos que o QR CODE de verificação só poderá ser usado uma vez, sendo considerado INVÁLIDO numa segunda tentativa de entrada. Por isso, não compartilhe uma imagem do ingresso sem antes tampar completamente o QR CODE.
Saiba mais sobre o aplicativo IngressoZapp e nosso sistema anti-fraude de gerenciamento de eventos em nosso site: www.ingressozapp.com
";

$covid = "
⚠️ PANDEMIA ⚠️
O IngressoZapp trabalha para uma retomada dos eventos segura. Sendo assim, caso você apresente sintomas e/ou teste positivo para COVID 19 após a sua participação em um evento, preencha o formulário abaixo para que possamos alertar os demais participantes, como uma estratégia de redução de riscos.
http://ingressoZapp.com/app/covid";
// $msg = $msg . $bar . $aviso;
$msg = $msg . $aviso;
$msg =  urlencode ($msg);
// echo $msg;
header("Location: https://api.whatsapp.com/send?phone=55".$telefone."&text=".$msg."");
    

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
    require ("./mail/PHPMailerAutoload.php");
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