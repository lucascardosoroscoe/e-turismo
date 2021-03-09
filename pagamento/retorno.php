
<?php
include_once '../produtor/includes/header.php';
include_once '../produtor/includes/db_valores.php';

//$hoje = date('d/m/Y h:m', strtotime("-3 hour"));


session_start();
$ordem = $_SESSION['ordem'];
$evento = $_SESSION['evento'];

    $consulta = "SELECT Lote.id as idLote, Lote.nome as descricao , Lote.valor, Item.quantidade FROM Item JOIN Ordem ON Item.ordem = Ordem.id JOIN Lote ON Lote.id = Item.referencia WHERE Ordem.id = '$ordem'";
    $dados = selecionar($consulta);
    
    
    

/*
$consulta = "";
$dados = selecionar($consulta);
$dados = $dados[0];
$nomeCliente = $dados['nomeCliente'];
$nomeEvento = $dados['nomeEvento'];
$nomePromoter = $dados['nomePromoter'];
$nomeProdutor = $dados['nomeProdutor'];
*/
?>
<div class="row">
    <div class="col s12 m6 push-m3 ">
        <div style="display: flex;">
            <img src="../produtor/includes/logo.png" alt="" class="logo">
            <div class="empresa">
            <h4>INGRESSOZAPP</h4>
            <h6 style="text-align: end;">LR Software - <?php echo $hoje ?></h6>
            </div>
        </div>
        <br><br>
        <h3>Muito Obrigado!</h3>

        <h6>Você acaba de adquirir:
        <br>
        <?php exibirItens($dados) ?>
        <br>
        Você receberá seus ingressos diretamente no seu Whatsapp.<br>
        Lembramos que o QR CODE de verificação só poderá ser usado uma vez, sendo considerado INVÁLIDO numa segunda tentativa de entrar, 
        por isso não conpartilhe uma imagem do ingresso sem antes tampar parcialmente o QR CODE.<br>     
        Saiba mais sobre o aplicativo IngressoZapp e nosso sistema anti-fraude de gerenciamento de Ingressos para eventos no nosso site: www.ingressozapp.com
        <h6>
        
    </div>
</div>

<?php
function exibirItens($dados){
    global $evento;
    $size = sizeof($dados);
    for ($i = 0; $i < $size; $i++){
        
        $obj = $dados[$i];
        //echo json_encode($primeiro);
        //echo "<br>";
        $idLote = $obj['idLote'];
        $descricao = $obj['descricao'];
        $valor = number_format($obj['valor'], 2, ',', '.');
        $quantidade = $obj['quantidade'];
        //echo $descricao;
        $msg = $quantidade . " Ingresso " . $evento . " - " . $descricao . " (R$" . $valor . ")<br>";
        echo $msg;
    }
}

function selecionar($consulta){
    global $servidor, $usuario, $senha, $bdados;
    
    $conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
    
    $gravacoes = mysqli_query($conexao, $consulta);
    
    $dados = array();
    
    while($linha = mysqli_fetch_assoc($gravacoes))
    {
        $dados[] = $linha; 
    }
    return $dados;
}

    include_once '../promoter/includes/footer.php';
?>