<link rel="stylesheet" href="estiloqr.css">
<?php
include('includes/verificarAcesso.php');
verificarAcesso(3);


session_start();
/*session created*/
$codigo    = $_GET['codigo'];

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

$msg = "🎉 ".$evento." 🎉
Olá ".$cliente." você acaba de adquirir um ingresso, com o promoter ".$vendedor.", utilizando o aplicativo IngressoZapp!!!

Para acessar seu ingresso salve o contato do promoter que te enviou esta mensagem e e clique no link: 
https://ingressozapp.com/app/qr.php?codigo=".$codigo."

Para entrar o evento apresente seu ingresso (CODIGO: ".$codigo.") e um documento original com foto.

";
$bar = "
🍻 BAR INGRESSOZAPP 🍻
Você pode garantir 5% de desconto para todas as compras no bar do evento via PIX e ainda ganhar tempo para aproveitar a experiência, evitando filas.
Basta acessar o link abaixo para adicionar um crédito antecipado:
https://ingressozapp.com/produtos/credito-no-bar-ingressozapp/
";
$aviso = "
🔐 AVISOS 🔐
Lembramos que o QR CODE de verificação só poderá ser usado uma vez, sendo considerado INVÁLIDO numa segunda tentativa de entrada. Por isso, não compartilhe uma imagem do ingresso sem antes tampar completamente o QR CODE.
Saiba mais sobre o aplicativo IngressoZapp e nosso sistema anti-fraude de gerenciamento de eventos em nosso site: www.ingressozapp.com";

// $msg = $msg . $bar . $aviso;
$msg = $msg . $aviso;
$msg =  urlencode ($msg);
header("Location: https://api.whatsapp.com/send?phone=55".$telefone."&text=".$msg."");
    

?>