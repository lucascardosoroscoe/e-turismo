<?php
    include('../includes/verificarAcesso.php');
    verificarAcesso(2);
    include '../includes/header.php';
    $codigo    =  $_GET['codigo'];

    $consulta = "SELECT * FROM Ingresso JOIN Cliente ON Ingresso.idCliente = Cliente.id WHERE codigo='$codigo'";
    $dados = selecionar($consulta);

    $obj = $dados[0];
    $valido = $obj['validade'];
    $evento = $obj['evento'];
    $cliente = $obj['nome'];
    $vendedor = $obj['vendedor'];
    $lote = $obj['lote'];
    if ($valido == ""){
        $valido = "INVALIDO";
    } else if($valido == "VALIDO"){
        $consulta = "UPDATE Ingresso SET validade = 'USADO' WHERE codigo = '$codigo'";
        $msg = executar($consulta);
    }
    echo ('<h5 id="validade">INGRESSO '.$valido.'</h5><br>');
    echo ('<h6>Evento: '.$evento.'</h6>');
    echo ('<h6>Cliente: '.$cliente.'</h6>');
    echo ('<h6>Promoter: '.$vendedor.'</h6>');
    echo ('<h6>Lote: '.$lote.'</h6>');
?>

<script>
var validade = document.getElementById("validade");
var fundo = document.getElementById("fundo");
if (validade.innerHTML == "INGRESSO VALIDO"){
    document.body.style.backgroundColor = "green";
} else if(validade.innerHTML == "INGRESSO INVALIDO"){
    document.body.style.backgroundColor = "red";
} else{
    document.body.style.backgroundColor = "blue";
}
</script>
<style>
    h5 {
        color: #ffffff;
        font-size: 2.83em !important;
    }
    h6 {
        color: #ffffff;
        font-size: 2em !important;
    }
</style>
<?php

include_once '../includes/footer.php';
?>

