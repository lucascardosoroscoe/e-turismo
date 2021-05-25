<?php
include('includes/verificarAcesso.php');
verificarAcesso(3);

carregarPost();
getLote();
getCliente();
verificarIngresso();

function carregarPost(){
    global $codigo, $evento, $idLote, $nomeCliente, $telefone;
    $codigo    =  rand ( 100000 , 999999 );
    $evento    =  $_POST['selectEvento'];
    $idLote    =  $_POST["selectLote"];
    $nomeCliente   =  $_POST['inputNome'];
    $telefone  =  $_POST['inputTelefone'];
    $telefone = str_replace(" ", "", $telefone);
    $telefone = str_replace("(", "", $telefone);
    $telefone = str_replace(")", "", $telefone);
    $telefone = str_replace("-", "", $telefone);
    $telefone = str_replace("+55", "", $telefone);
    $prim = substr($telefone,0,1);
    if($prim == 0){
        $telefone = substr($telefone,1,11);
    }
}

function getLote(){
    global $idLote, $valor, $sexo, $quantidade, $vendidos;
    $consulta = "SELECT * FROM Lote WHERE id='$idLote'";
    $obj = selecionar($consulta);
    $lote = $obj[0];
    $valor     =  $lote['valor'];
    $sexo      =  $lote['sexo'];
    $quantidade=  $lote['quantidade'];
    $vendidos  =  $lote['vendidos'];
    $vendidos  =  $vendidos + 1 ;

}

function getCliente(){
    global $nomeCliente, $telefone, $idCliente;
    $consulta = "SELECT `id` FROM `Cliente` WHERE `nome` = '$nomeCliente' AND `telefone` = '$telefone'";
    $dados = selecionar($consulta);
    if($dados[0]['id'] == ""){
        $consulta = "INSERT INTO `Cliente`(`nome`, `telefone`) VALUES ('$nomeCliente', '$telefone')";
        $msg = executar($consulta);
        if($msg == "Sucesso!"){
            $consulta = "SELECT `id` FROM `Cliente` WHERE `nome` = '$nomeCliente' AND `telefone` = '$telefone'";
            $dados = selecionar($consulta);
            $idCliente = $dados[0]['id'];
        }else{
            echo "Erro ao criar Cliente!!!<br>";
        }
    }else{
        $idCliente = $dados[0]['id'];
    }
}

function verificarIngresso(){
    global $tipoUsuario,$idUsuario, $evento, $idCliente, $vendedor, $codigo, $local;
    if($tipoUsuario == '1'){
        $consulta = "SELECT * from Ingresso WHERE evento= '$evento' AND vendedor= '1' AND idCliente= '$idCliente'";
        $vendedor = 1;
    }else if($tipoUsuario == '2'){
        $consulta = "SELECT * from Ingresso WHERE evento= '$evento' AND vendedor= '2' AND idCliente= '$idCliente'";
        $vendedor = 2;
    }else if($tipoUsuario == '3'){
        $consulta = "SELECT * from Ingresso WHERE evento= '$evento' AND vendedor= '$idUsuario' AND idCliente= '$idCliente'";
        $vendedor = $idUsuario;
    }
    $dados = selecionar($consulta);
    if ($dados[0]['codigo'] == ""){
        gerarIngresso();
        
        $local='https://ingressozapp.com/app/enviar.php?codigo='.$codigo;
        enviarIngresso(); 
    }else{
        $local='https://ingressozapp.com/app/enviar.php?codigo='.$dados[0]['codigo'];
        echo("<h3>Você já gerou um ingresso para" . $nomeCliente . " deste mesmo Evento . Caso esteja gerando um novo ingresso, para outro cliente, por favor volte e coloque um nome mais completo.<br><br>Caso esteja tentantando reenviar o ingresso pois errou o número do Whatsapp ao gerar o ingresso <a href='$local'>Clique aqui</a> </h3>");

    }
}

function gerarIngresso(){
    global $codigo, $evento, $vendedor, $idCliente, $telefone, $valor, $idLote;
    $consulta = "INSERT INTO Ingresso (codigo, evento, vendedor, idCliente, valor, lote) VALUES ('$codigo', '$evento', '$vendedor', '$idCliente', '$valor', '$idLote')";
    // echo $consulta;
    $msg = executar($consulta);
    if($msg == "Sucesso!"){
        atualizarVendidosLote(); 
    }
    echo "Ingresso gerado.";
    
}

function atualizarVendidosLote(){
    global $vendidos, $idLote, $quantidade;
    if($quantidade == $vendidos){
        $consulta = "UPDATE Lote SET validade = 'ESGOTADO' WHERE id = $idLote ";
        $msg = executar($consulta);
        if($msg == 'Sucesso!'){
            emailVirada();
        }else{
            echo "Falha ao invalidar Lote!!!<br>";
        }
    }
    $consulta = "UPDATE `Lote` SET `vendidos`='$vendidos' WHERE `id` = '$idLote'";
    $msg = executar($consulta);    
}

function emailVirada(){
    echo "E-mail enviado";
}

function enviarIngresso(){
    global $local;
    $msg = $_POST["msg"];
    if (empty($msg)){
        // echo '<br>'.$local;
        header('Location: '.$local);
    }else if ($msg == "1"){
        $consulta = "UPDATE Ingresso SET validade = 'INVALIDO' WHERE codigo = '$codigo'";
        $msg = executar($consulta);
        if($msg == 'Sucesso!'){
            echo("<h1>Ingresso gerado com sucesso, permitir entrada!!!!</h1>");
        }else{
            echo "<h5>Falha ao invalidar ingresso</h5>";
        }
    }
}

?>