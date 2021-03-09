<body is="fundo">
<?php
    include_once '../produtor/includes/header.php';
    $user    =  $_GET['usuario'];
    $codigo    =  $_GET['codigo'];
    
    include('../produtor/includes/db_valores.php');
    $conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);

    $consulta = "SELECT * FROM Ingresso WHERE codigo='$codigo'";

    $gravacoes = mysqli_query($conexao, $consulta);
    $dados = array();
    while($linha = mysqli_fetch_assoc($gravacoes)){
        $dados[] = $linha; 
    }

    mysqli_close($conexao);

    $obj = $dados[0];
    //echo json_encode($primeiro);
    //echo "<br>";
    $valido = $obj['validade'];
    $evento = $obj['evento'];
    $cliente = $obj['cliente'];
    $vendedor = $obj['vendedor'];
    $lote = $obj['lote'];
    if ($valido == ""){
        $valido = "INVALIDO";
    } else if($valido == "VALIDO"){
        $conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
        $consulta = "update Ingresso set validade = 'INVALIDO' where codigo = '$codigo'";

        if(mysqli_query($conexao, $consulta))
        {
        }
        else
        {
            echo "<h5>Falha ao invalidar ingresso</h5>";
        }
        mysqli_close($conexao);
    }
    echo ('<h5 id="validade">INGRESSO '.$valido.'</h5><br>');
    echo ('<h6>Evento: '.$evento.'</h6>');
    echo ('<h6>Cliente: '.$cliente.'</h6>');
    echo ('<h6>Promoter: '.$vendedor.'</h6>');
    echo ('<h6>Lote: '.$lote.'</h6>');
    

include_once 'includes/footer.php';
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
</body>