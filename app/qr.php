<link rel="stylesheet" href="css/estiloqr.css">
<?php
include('includes/bancoDados.php');

$codigo    = $_GET['codigo'];
$consulta = "SELECT Ingresso.valor, Ingresso.validade, Ingresso.data, Ingresso.validade,
Evento.nome as evento, Evento.descricao as descricaoEvento,
Vendedor.nome as vendedor, Cliente.nome as cliente, Cliente.telefone, Lote.nome as lote
FROM Ingresso 
JOIN Evento ON Evento.id = Ingresso.evento
JOIN Vendedor ON Vendedor.id = Ingresso.vendedor
JOIN Cliente ON Cliente.id = Ingresso.idCliente
JOIN Lote ON Lote.id = Ingresso.lote
WHERE Ingresso.codigo = $codigo";
echo $consulta;

$ingresso = selecionar($consulta);
$ingresso = $ingresso[0];
$evento = $ingresso['evento'];
$cliente = $ingresso['cliente'];
$descricaoEvento = $ingresso['descricaoEvento'];
$evento = $ingresso['evento'];
$aux = 'promoter/qr_img0.50j/php/qr_img.php?';
$aux .= 'd='.$codigo.'&';
$aux .= 'e=H&';
$aux .= 's=4&';
$aux .= 't=P';


echo ("<img class='imgEvento' src='getImagem.php?codigo=$codigo'/>");
echo ('<img class="qr" src="'.$aux.'" alt="" width="50%">');
echo ('<h5>'.$evento.'</h5>');
echo ('<p>Ingresso individual</p>');
echo ('<p>'.$cliente.'</p>');
echo ('<p>'.$descricaoEvento.'</p>');

?>
<script>
</script>