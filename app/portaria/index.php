<body>
<?php
    include('../includes/verificarAcesso.php');
    // verificarAcesso(2);
    include('../includes/header.php');

    $codigo    =  $_GET['codigo'];
    $consulta = "SELECT Ingresso.codigo, Evento.id as idEvento, Evento.nome as evento, Vendedor.nome as vendedor, Cliente.nome as cliente, Ingresso.valor, Ingresso.validade, Ingresso.data, Lote.nome as lote
    FROM Ingresso 
    JOIN Evento ON Ingresso.evento = Evento.id
    JOiN Vendedor ON Ingresso.vendedor = Vendedor.id
    JOIN Cliente ON Ingresso.idCliente = Cliente.id
    JOIN Lote ON Ingresso.lote = Lote.id
    WHERE codigo='$codigo'";
    $dados = selecionar($consulta);
    $obj = $dados[0];
    $valido = $obj['validade'];
    $evento = $obj['evento'];
    $cliente = $obj['cliente'];
    $vendedor = $obj['vendedor'];
    $lote = $obj['lote'];
    $data = $obj['data'];
    $valor = $obj['valor'];
    if ($valido == ""){
        $valido = "INVALIDO";
    } else if($valido == "VALIDO"){
        $consulta = "update Ingresso set validade = 'USADO' where codigo = '$codigo'";
        $msg = executar($consulta);
        if($msg != "Sucesso!"){
            echo "<h5>Falha ao invalidar ingresso</h5>";
        }
    }
    echo ('<div class="container-fluid">');
        echo ('<div class="card mb-4">');
            echo ('<div class="card-header" id="card">');
            echo ('<h5 id="validade">INGRESSO '.$valido.'</h5>');
            echo ('</div>');
            echo ('<div class="card-body">');
            echo ("<img id='img' style='width: 100%;border-radius: 27px; border: solid 4px #000;' src='../getImagem.php?id=$idEvento'/>");
            echo ('<h6 class="text">Evento: '.$evento.'</h6>');
            echo ('<h6 class="text">Cliente: '.$cliente.'</h6>');
            echo ('<h6 class="text">Promoter: '.$vendedor.'</h6>');
            echo ('<h6 class="text">Lote: '.$lote.' (R$'.$valor.',00)</h6>');
            echo ('<h6 class="text">Data compra: '.$data.'</h6>');
        echo ('</div>');
    echo ('</div>');
    
    

include_once '../includes/footer.php';
?>
<script>
var validade = document.getElementById("validade");
var fundo = document.getElementById("fundo");
var card = document.getElementById("card");
var img = document.getElementById("img");
var text = document.getElementsByClassName("text");
card.style.backgroundImage = "none";
if (validade.innerHTML == "INGRESSO VALIDO"){
    card.style.backgroundColor = "green";
    img.style.borderColor = "green";
    var cor = "green"
} else if(validade.innerHTML == "INGRESSO USADO"){
    card.style.backgroundColor = "blue";
    img.style.borderColor = "blue";
    var cor =  "blue";
} else {
    card.style.backgroundColor = "red";
    img.style.borderColor = "red";
    var cor =  "#fff";
}
Array.from(document.getElementsByClassName("text")).forEach(
    function(element, index, array) {
        element.style.color =  cor;
    }
);
</script>
<style>
    h5 {
        font-size: 1.6em !important;
    }
    h6 {
        font-size: 1.5em !important;
    }
</style>
</body>