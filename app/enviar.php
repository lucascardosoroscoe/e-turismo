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
echo $consulta . '<br>';
$ingresso = selecionar($consulta);
$telefone = $ingresso[0]['telefone'];
$cliente = $ingresso[0]['cliente'];
$evento = $ingresso[0]['evento'];
$vendedor = $ingresso[0]['vendedor'];
echo $telefone;
header("Location: https://api.whatsapp.com/send?phone=55".$telefone."&text=Ol%C3%A1%20".$cliente."%2C%20voc%C3%AA%20acaba%20de%20adquirir%20um%20ingresso%20do%20evento%20".$evento."%2C%20com%20o%20promoter%20".$vendedor."%2C%20utilizando%20o%20aplicativo%20IngressoZapp!!!%20Para%20acessar%20seu%20ingresso%20salve%20o%20contato%20que%20enviou%20essa%20mensagem%20e%20clique%20no%20link%3A%20http%3A%2F%2Fingressozapp.com%2Fapp%2Fqr.php%3Fcodigo%3D".$codigo."%20%20%20%20%20%20Para%20entrar%20no%20evento%20apresente%20seu%20ingresso%20(CODIGO%3A%20".$codigo.")%20e%20um%20documento%20original%20com%20foto.%20%20%20%20%20Lembramos%20que%20o%20QR%20CODE%20de%20verifica%C3%A7%C3%A3o%20s%C3%B3%20poder%C3%A1%20ser%20usado%20uma%20vez%2C%20sendo%20considerado%20INV%C3%81LIDO%20numa%20segunda%20tentativa%20de%20entrar%2C%20por%20isso%20n%C3%A3o%20conpartilhe%20uma%20imagem%20do%20ingresso%20sem%20antes%20tampar%20parcialmente%20o%20QR%20CODE.%20%20%20%20%20Saiba%20mais%20sobre%20o%20aplicativo%20IngressoZapp%20e%20nosso%20sistema%20anti-fraude%20de%20gerenciamento%20de%20Ingressos%20para%20eventos%20no%20nosso%20site%3A%20www.ingressozapp.com%20");
    

?>