<body>
<?php
    include('../app/includes/verificarAcesso.php');
    // verificarAcesso(2);
    include('../app/includes/header.php');

    $codigo    =  $_GET['codigo'];


    $consulta = "SELECT Ingresso.codigo, Evento.id as idEvento, Evento.produtor, Evento.nome as evento, Vendedor.nome as vendedor, Cliente.nome as cliente, Ingresso.valor, Ingresso.validade, Ingresso.motivoInvalidar, Ingresso.data, Ingresso.horaLeitura, Lote.nome as lote
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
    $produtor = $obj['produtor'];
    $idEvento = $obj['idEvento'];
    $cliente = $obj['cliente'];
    $vendedor = $obj['vendedor'];
    $lote = $obj['lote'];
    $data = $obj['data'];
    $horaLeitura = $obj['horaLeitura'];
    $valor = $obj['valor'];
    $motivo = $obj['motivoInvalidar'];
    if($idUsuarioPortaria != ""){
        if ($produtor != $idUsuarioPortaria){
            $valido = "PARA EVENTO INVÁLIDO - Pertence a outro produtor";
        }
    }
    if ($valido == ""){
        $valido = "NÃO ENCONTRADO";
    } else if($valido == "VALIDO"){
        $timezone = new DateTimeZone('America/Sao_Paulo');
        $agora = new DateTime('now', $timezone);
        $dataHora = $agora->format('d-m-Y H:i:s');
        $consulta = "update Ingresso set validade = 'USADO', horaLeitura = '$dataHora' where codigo = '$codigo'";
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
                if($idUsuarioPortaria == ""){
                    echo'<form action="usuarioPortaria.php" id="usuarioPortaria" method="POST">';
                        echo'<div class="form-row">';
                            echo'<div class="col-md-12">';
                                echo'<div class="form-group">';
                                    echo'<label class="small mb-1" for="inputEmailAddress">E-mail do Produtor de Eventos*</label>';
                                    echo'<input class="form-control py-4" id="inputEmailAddress"  name="inputEmailAddress" type="email" aria-describedby="emailHelp" placeholder="Digite o e-mail" required/>';
                                echo'</div>';
                            echo'</div>';
                        echo'</div>';
                        echo'<div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" onclick="enviarForm()" >Validar produtor</button></div>';
                    echo'</form>';
                }else{
                    
                }
                if($valido == "VALIDO" || $valido == "USADO" || $valido == "CANCELADO"){
                    if($valido == "CANCELADO"){
                        echo ('<h6 class="text">'.$motivo.'</h6>');
                    }
                    echo ('<h6 class="text">Evento: '.$evento.'</h6>');
                    echo ('<h6 class="text">Cliente: '.$cliente.'</h6>');
                    echo ('<h6 class="text">Promoter: '.$vendedor.'</h6>');
                    echo ('<h6 class="text">Lote: '.$lote.' (R$'.$valor.',00)</h6>');
                    echo ('<h6 class="text">Data compra: '.$data.'</h6>');
                    if($valido == "USADO"){
                        $hora = gmdate('d-m-Y H:i:s', strtotime( $horaLeitura ) - 7200);
                        echo ('<h6 class="text">Horário de Validação: '.$hora.' (Brasília)</h6>');
                    }
                    echo ("<img id='img' style='width: 100%;border-radius: 27px; border: solid 2px #000;' src='https://ingressozapp.com/app/getImagem.php?id=$idEvento'/>");
                    
                }else{
                    echo ('<h6 class="text">Suspeita de fraude!!! Ingresso não encontrado no sistema, verifique a conversa em que o promoter enviou a mensagem e chame o promoter para confirmar a versão do cliente.</h6>');
                }
            echo ('</div>');
        echo ('</div>');
    echo ('</div>');
    
    
    

include_once '../app/includes/footer.php';
?>
<div class="fab-container">
    <div class="button iconbutton" onclick="window.close()">
        <i class="fas fa-camera" style="margin: auto;"></i>
    </div>
</div>
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
    var cor =  "black";
}
Array.from(document.getElementsByClassName("text")).forEach(
    function(element, index, array) {
        element.style.color =  cor;
    }
);
</script>
<style>
    button {
        font-size: xxx-large;
    }
    span {
        font-size: xxx-large;
    }
    h5 {
        font-size: 1.6em !important;
    }
    h6 {
        font-size: 1em !important;
    }
    .fab-container{
        position:fixed;
        bottom:50px;
        right:50px;
        cursor:pointer;
    }
    .iconbutton{
        width:50px;
        height:50px;
        border-radius: 100%;
        background: #FF4F79;
        box-shadow: 5px 5px 2px #222222;
    }
    .button{
        width:60px;
        height:60px;
        background:#000000;
    }
    .fa-camera{
        display:flex;
        align-items:center;
        justify-content:center;
        height: 100%;
        color:white;
        margin: auto !important;
    }
</style>
</body>