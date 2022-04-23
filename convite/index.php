<link rel="stylesheet" href="estilo.css">
<?php
include_once '../promoter/includes/header.php';
include('../promoter/includes/db_valores.php');
$conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);

$id    = $_GET['id'];

$consulta = "SELECT * FROM `Convite` JOIN Evento ON Evento.nome = Convite.evento WHERE `id` = '$id'";

$gravacoes = mysqli_query($conexao, $consulta);

$dados = array();

while($linha = mysqli_fetch_assoc($gravacoes))
{
    $dados[] = $linha; 
}
$desc= $dados[0];
$descricao = $desc['descricao'];
$evento = $desc['evento'];
$produtor = $desc['produtor'];
session_start();
$_SESSION['evento'] = $evento;



echo ('<div class="row">');
echo ('<div class="col s12 m6 push-m3 ">');
echo ("<img class='imgEvento' src='../getImagem.php?nome=$evento&produtor=$produtor'/>");
echo ('<p style="text-align: center; font-size: 1em;">CODIGO: '.$descricao.'</p>');
echo ('<h1 style="text-align: center; font-size: 2em;">'.$evento.'</h1>');
echo ('<p style="text-align: center; font-size: 1em;">'.$descricao.'</p>');

echo ('<div id="divpicpay">');
    echo ('<h2 style="font-size: 1em;">Garanta seu Ingresso:</h2>');

    echo ('<form action="enviar.php" id="enviar" method="POST">');
        echo ('<select id="selecionarLote" name="selecionarLote">');
        $stringLotes = carregarLotes();
        echo ('</select><br>');

        echo ('<select id="selecionarQuantidade" name="selecionarQuantidade">');
        echo ('<option value="1">1</option>');
        echo ('<option value="2">2</option>');
        echo ('<option value="3">3</option>');
        echo ('<option value="4">4</option>');
        echo ('<option value="5">5</option>');
        echo ('<option value="6">6</option>');
        echo ('<option value="7">7</option>');
        echo ('<option value="8">8</option>');
        echo ('<option value="9">9</option>');
        echo ('<option value="9">10</option>');
        echo ('</select><br>');

        echo ('<br><br><button type="submit" name="btn-cadastrar" class="btn">Comprar Ingressos</button>');
    echo ('</form>');
    

    $link = gerarLink($stringLotes);
    echo ("<div><a href='".$link."'><img style='width:100%' src='whatsapp.png'></a></div>");
    echo ('<br><p style="font-size: 1em;">Compartilhe seu convite:</p>');
echo ('</div>');

gerarQR($id);




function carregarLotes(){
    global $conexao, $evento;
    $consulta = "SELECT * FROM Lote WHERE evento='$evento' and validade='DISPONÍVEL'";

    $gravacoes = mysqli_query($conexao, $consulta);
    $dados = array();
    while($linha = mysqli_fetch_assoc($gravacoes)){
        $dados[] = $linha; 
    }

    mysqli_close($conexao);
    $stringLotes = "";
    $size = sizeof($dados);
    for ($i = 0; $i < $size; $i++){
        
        $obj = $dados[$i];
        //echo json_encode($primeiro);
        //echo "<br>";
        $id = $obj['id'];
        $nome = $obj['nome'];
        $valor = number_format($obj['valor'], 2, ',', '.');
        
        echo ('<option value="'.$id.'">' . $nome . ' - R$ ' . $valor . '</option>');
        $stringLotes = $stringLotes . $nome . ' - R$ ' . $valor . "%0A";
      
    }
    return $stringLotes;
}

function gerarQR($id){
//Criar QR Code Correto
$codigo = "http://ingressozapp.com/convite/index.php?id=" . $id;

$aux = '../promoter/qr_img0.50j/php/qr_img.php?';
$aux .= 'd='.$codigo.'&';
$aux .= 'e=H&';
$aux .= 's=4&';
$aux .= 't=P';

echo ('<img class="qr" src="'.$aux.'" alt="" width="50%">');
}

function gerarLink($stringLotes){
    global $evento, $descricao, $id;
    $linha = "%0A";
    $link = "*" . $evento . "*"  . $linha;
    $link = $link . $descricao . $linha . $linha;
    $link = $link . "Link%20do%20Evento:" . $linha;
    $link = $link . "https://fb.me/e/1REnXlqC7" . $linha . $linha;
    $link = $link . "*Lotes:* " . $linha;
    $link = $link . $stringLotes. $linha;
    $link = $link . "*Ingressos:*";
    $link = $link . " http://ingressozapp.com/convite/index.php?id=" . $id. "";
    $link = "https://api.whatsapp.com/send?text=" . $link;
    return $link;
}
include_once '../promoter/includes/footer.php';
?>
<script>
    verificarLote()
    function verificarLote(){
        var valor = document.getElementById("selecionarLote").value;
        var link = document.getElementById("link").value;
        var linkPic = document.getElementById("linkPic");
        linkPic.href = link + valor;
    }
</script>