<link rel="stylesheet" href="estiloqr.css">
<?php
include('./includes/verificarAcesso.php');
verificarAcesso(3);

$codigo  = $_GET['codigo'];
$hash    = $_GET['hash'];
// Se o Ingresso chega com hash
if($hash != ""){
    selectHash();
    $url = "https://ingressozapp.com/app/ingressos/?hash=".$hash;
// Se o ingresso chega com código
}else if($codigo != ""){
    selectCodigo();
    $url = "https://ingressozapp.com/app/qr.php?codigo=".$codigo;
}

if($email!=''){
    $enviado = enviarIngresso($hash, $email, $cliente, $idEvento, $evento);
}

$msg = "🎉 *".$evento."* 🎉
Olá *".$cliente."* você acaba de adquirir ingressos utilizando o aplicativo *IngressoZapp*!!!
    
Para acessar seu ingresso *salve esse número* e clique no link: 
".$url."
    
Para entrar no evento apresente um print do QR CODE de cada um dos seus ingressos (disponível no link acima) e um documento original com foto.";

//Mensagem personalizada para ingressos do prefeito do futuro;
if($idUsuario == 524){msgPrefeitos();}
if($lote == '100805'){
    msgPatricinhas();
}
// echo $msg;

$aviso = "
🔐 AVISOS 🔐
Lembramos que o QR CODE de verificação só poderá ser usado uma vez, sendo considerado INVÁLIDO numa segunda tentativa de entrada. Por isso, não compartilhe uma imagem do ingresso sem antes tampar completamente o QR CODE.
Saiba mais sobre o aplicativo IngressoZapp e nosso sistema anti-fraude de gerenciamento de eventos em nosso site: www.ingressozapp.com
";
$msg = $msg . $aviso;
$msg =  urlencode ($msg);
// echo $msg;
header("Location: https://api.whatsapp.com/send?phone=55".$telefone."&text=".$msg."");
    

function enviarIngresso($hash, $senderEmail, $senderName, $idEvento, $nomeEvento){
    $assunto = "Seus Ingressos para o evento ".$nomeEvento." estão aqui!!!";
    $msg = "
    <img style='width: 40%; margin-left:30%;' src='https://ingressozapp.com/app/getImagem.php?id=$idEvento'/>
    <h1 style='text-align:center'>🎉 ".$nomeEvento." 🎉</h1><br>
    <h3 style='text-align:center'>Olá ".$senderName." você acaba de adquirir um ingresso, utilizando o aplicativo IngressoZapp!!!</h3><br>
    <br>
    <h2 style='text-align:center' >Para acessar os ingressos salve o número que te enviou essa mensagem e clique no link: <br>
    https://ingressozapp.com/app/ingressos/?hash=".$hash."</h2><br>
    <br>
    ";
    $aviso = "
    🔐 AVISOS 🔐<br>
    Lembramos que o QR CODE de verificação só poderá ser usado uma vez, sendo considerado INVÁLIDO numa segunda tentativa de entrada. Por isso, não compartilhe uma imagem do ingresso sem antes tampar completamente o QR CODE. <br>
    Saiba mais sobre o aplicativo IngressoZapp e nosso sistema anti-fraude de gerenciamento de eventos em nosso site: www.ingressozapp.com <br></h4>
    ";
    $corpo = $msg . $aviso;
    // return enviaEmail($senderEmail, $senderName, $assunto, $corpo);
}

function selectCodigo(){
    global $codigo, $telefone, $cliente, $evento, $vendedor, $email, $idEvento, $lote;
    $consulta = "SELECT Ingresso.valor, Ingresso.validade, Ingresso.data, Ingresso.lote,
    Evento.nome as evento, Evento.id as idEvento, Vendedor.nome as vendedor, 
    Cliente.nome as cliente, Cliente.email as email, Cliente.telefone, Lote.nome as lote
    FROM Ingresso 
    JOIN Evento ON Evento.id = Ingresso.evento
    JOIN Vendedor ON Vendedor.id = Ingresso.vendedor
    JOIN Cliente ON Cliente.id = Ingresso.idCliente
    JOIN Lote ON Lote.id = Ingresso.lote
    WHERE Ingresso.codigo = $codigo";
    $ingresso = selecionar($consulta);
    
    $telefone = $ingresso[0]['telefone'];
    $email = $ingresso[0]['email'];
    $lote = $ingresso[0]['lote'];
    $cliente = $ingresso[0]['cliente'];
    $evento = $ingresso[0]['evento'];
    $idEvento = $ingresso[0]['idEvento'];
    $vendedor = $ingresso[0]['vendedor'];
}
function selectHash(){
    global $hash, $telefone, $cliente, $evento, $vendedor, $email, $idEvento, $lote;
    $consulta = "SELECT Ingresso.valor, Ingresso.validade, Ingresso.data, Ingresso.lote,
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
    $lote = $ingresso[0]['lote'];
    $cliente = $ingresso[0]['cliente'];
    $evento = $ingresso[0]['evento'];
    $idEvento = $ingresso[0]['idEvento'];
    $vendedor = $ingresso[0]['vendedor'];
}

function msgPrefeitos(){
    global $msg, $cliente, $url;
        $msg = "🎉 Prefeitos do Futuro 2023 🎉  
Olá ".$cliente." você está recebendo nesta mensagem o Qr Code de acesso ao evento Prefeitos do Futuro 2023, que acontece de 24 a 26 de maio, no Hotel Royal Tulip Alvorada Localização: https://goo.gl/maps/vS6u9kMbGU4TPSjx9
O evento começa às 8h e termina às 18h todos os dias Para acessar seu passaporte salve esse número e clique no link: 
".$url."
No dia 25/05, quinta-feira, teremos um coquetel de confraternização com um som especial das 18:10 às 20:10 no mesmo local do evento. Para entrar no evento apresente seu ingresso e um documento original com foto no credenciamento na entrada do Hotel Royal Tulip, teremos balcões de atendimento separados por: PREFEITOS, SECRETÁRIOS E ASSESSORES, CONVIDADOS E PALESTRANTES. 

Para evitar filas, você poderá retirar seu kit e fazer o seu credenciamento com este Qr Code já no dia 23/05, terça-feira, das 15h às 19h na recepção do Hotel Royal Tulip.
";
}

function msgVegas(){
    global $msg, $cliente, $url;
        $msg = "🎉 After do Vegas 🎉  
Olá ".$cliente." você foi no Vegas dia 05/05 na Loop e *HOJE* vamos fazer um After oficial do evento com uma line foda!!! 
COMO VOCÊ FOI NO EVENTO SUA ENTRADA É GRÁTIS
O evento começa às 22h e seu ingresso está disponível no link: 
".$url;
}

function msgPatricinhas(){
    global $msg, $cliente, $url;
        $msg = "🎉 Funk das Patricinhas 🎉  
Olá ".$cliente.", você ganhou um ingresso + cerveja para o Funk das Patricinhas dia 09/06, te espero lá em!!! 
O evento começa às 22h e seu ingresso está disponível no link: 
".$url;
}


?>