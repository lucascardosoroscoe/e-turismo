<link rel="stylesheet" href="css/estiloqr.css">
<?php
include('includes/db_valores.php');
$conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);

$codigo    = $_GET['codigo'];
$evento    = $_GET['evento'];
$produtor  = $_GET['produtor'];

$consulta = "SELECT descricao FROM Evento WHERE nome='$evento'";

$gravacoes = mysqli_query($conexao, $consulta);

$dados = array();

while($linha = mysqli_fetch_assoc($gravacoes))
{
    $dados[] = $linha; 
}
$desc= $dados[0];
$descricao = $desc['descricao'];
mysqli_close($conexao); 

$conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);

$consulta = "SELECT cliente FROM Ingresso WHERE codigo='$codigo'";

$gravacoes = mysqli_query($conexao, $consulta);

$dados = array();

while($linha = mysqli_fetch_assoc($gravacoes))
{
    $dados[] = $linha; 
}
$obj= $dados[0];
$cliente = $obj['cliente'];
mysqli_close($conexao); 

$aux = 'promoter/qr_img0.50j/php/qr_img.php?';
$aux .= 'd='.$codigo.'&';
$aux .= 'e=H&';
$aux .= 's=4&';
$aux .= 't=P';


echo ("<img class='imgEvento' src='getImagem.php?nome=$evento&produtor=$produtor'/>");
echo ('<img class="qr" src="'.$aux.'" alt="" width="50%">');
echo ('<h5>'.$evento.'</h5>');
echo ('<p>Ingresso individual</p>');
echo ('<p>'.$cliente.'</p>');
echo ('<p>'.$descricao.'</p>');

?>
<script>
</script>