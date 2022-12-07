<link rel="stylesheet" href="estiloqr.css">
<?php
include('includes/verificarAcesso.php');
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
    global $codigo, $telefone, $cliente, $evento, $vendedor, $email, $idEvento;
    $consulta = "SELECT Ingresso.valor, Ingresso.validade, Ingresso.data,
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
    $cliente = $ingresso[0]['cliente'];
    $evento = $ingresso[0]['evento'];
    $idEvento = $ingresso[0]['idEvento'];
    $vendedor = $ingresso[0]['vendedor'];
}
function selectHash(){
    global $hash, $telefone, $cliente, $evento, $vendedor, $email, $idEvento;
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
}

function msgPrefeitos(){
    global $msg, $cliente, $url;
        $msg = "🎉 Prefeitos do Futuro 2022 🎉
        
    Olá ".$cliente." você está recebendo nesta mensagem o Qr Code de acesso ao evento Prefeitos do Futuro 2022, que acontece de 18 a 20 de maio, no Centro de Convenções Brasil 21
    Localização: https://goo.gl/maps/isgpwtyZoLRULzbS8
    O evento começa às 08h e termina às 18h todos os dias
            
    Para acessar seu passaporte salve esse número e clique no link: 
    ".$url."
            
    Nos dias 18 e 19, quarta e quinta, teremos coquetéis de confraternização com shows especiais das 18:15 às 20:15 no mesmo local do evento.
            
    Para entrar no evento apresente seu ingresso e um documento original com foto no credenciamento na entrada do Centro de Convenções Brasil 21, teremos balcões de atendimento separados por: PREFEITOS, SECRETÁRIOS E ASSESSORES, CONVIDADOS E PALESTRANTES.
            
    Para evitar filas, você poderá retirar seu kit e fazer o seu credenciamento com este Qr Code já no dia 17/05, terça-feira, das 15h às 19h no próprio Centro de Convenções Brasil 21.";
}


?>