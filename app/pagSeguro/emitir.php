<?php
include('../includes/verificarAcesso.php');
verificarAcesso(1);

if(carregarPost()){
    $consulta = "UPDATE `PedidoPagSeguro` SET `status`= 4 WHERE `id` = '$idPagSeguro'";
    $msg = executar($consulta);
    if(getLote()){
        if(getCliente()){
            verificarIngresso();
        }
    };
};



function carregarPost(){
    global $codigo, $evento, $idLote, $nomeCliente, $telefone, $tipoUsuario, $idPagSeguro;
    
    $evento    =  $_GET['idEvento'];
    $consulta = "SELECT `validade` FROM `Evento` WHERE `id` = '$evento'";
    $dados = selecionar($consulta);
    $validadeEvento = $dados[0]['validade'];
    if($validadeEvento != 'VALIDO'){
        $evento = "";
    }
    // $idLote    =  $_POST["selectLote"];
    $nomeCliente   =  $_GET['nome'];
    $telefone  =  $_GET['telefone'];
    $idLote  =  $_GET['idLote'];
    $idPagSeguro  =  $_GET['idPagSeguro'];
    $consulta = "SELECT `validade` FROM `Lote` WHERE `id` = '$idLote'";
    $dados = selecionar($consulta);
    $validadeEvento = $dados[0]['validade'];
    if($validadeEvento != 'DISPONÍVEL'){
        if($tipoUsuario != 1 && $validadeEvento != 'EXCLUSIVO'){
            $idLote = "";
        }
    }
    // $
    $telefone = str_replace(" ", "", $telefone);
    $telefone = str_replace("(", "", $telefone);
    $telefone = str_replace(")", "", $telefone);
    $telefone = str_replace("-", "", $telefone);
    $telefone = str_replace("+55", "", $telefone);
    $prim = substr($telefone,0,1);
    if($prim == 0){
        $telefone = substr($telefone,1,11);
    }
    // Verifica de Nome do Cliente, Lote e Telefone estão OK
    if($evento == "" || $idLote == "" || $nomeCliente == "" || $telefone == ""){
        echo "<h4>Evento: " . $evento ."<br>";
        echo "idLote: " . $idLote ."<br>";
        echo "nomeCliente: " . $nomeCliente ."<br>";
        echo "telefone: " . $telefone ."<br>";
        echo "Dados insuficientes para gerar o Ingresso, provavelmente o lote que você tentou vender já não está mais disponível.
        <a href='index.php'>CLIQUE AQUI PARA VOLTAR NA PÁGINA DE EMISSÃO</a></h4>";
        return false;
    }else{
        $codigo = gerarCodigo();
        return true;
    }
}

function gerarCodigo(){
    $codigo = 0;
    while ($codigo == 0) {
        $codigo    =  rand ( 100000 , 999999 );
        $consulta = "SELECT * FROM `Ingresso` WHERE `codigo` = '$codigo'";
        $dados = selecionar($consulta);
        if($dados[0] != ""){
            echo "Código ". $codigo ." já existe, gerando novo código.";
            $codigo = 0;
        }
    }
    // echo "Código Gerado com sucesso: " . $codigo;
    return $codigo;
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
    if($valor == "" || $quantidade == ""){
        echo "Dados insuficientes sobre o lote.";
        return false;
    }else{
        // echo "Lote carregado com sucesso!";
        return true;
    }
}

function getCliente(){
    global $nomeCliente, $telefone, $idCliente;
    $consulta = "SELECT `id` FROM `Cliente` WHERE `telefone` = '$telefone'";
    $dados = selecionar($consulta);
    if($dados[0]['id'] == ""){
        $consulta = "INSERT INTO `Cliente`(`nome`, `telefone`) VALUES ('$nomeCliente', '$telefone')";
        echo "Criando Cliente: <br>Nome: ".$nomeCliente."<br>Telefone: ".$telefone."<br>";
        $msg = executar($consulta);
        if($msg == "Sucesso!"){
            $consulta = "SELECT `id` FROM `Cliente` WHERE `nome` = '$nomeCliente' AND `telefone` = '$telefone'";
            $dados = selecionar($consulta);
            $idCliente = $dados[0]['id'];
            // echo "Cliente Criado com Sucesso: <br>Id: ".$idCliente."<br>";
            return true;
        }else{
            echo "Erro ao criar Cliente!!!<br>";
            echo $consulta . "<br>";
            return false;
        }
    }else{
        // echo "Cliente já existe no sistema.<br>";
        $idCliente = $dados[0]['id'];
        $consulta = "UPDATE `Cliente` SET `nome`='$nomeCliente' WHERE `id` = '$idCliente'";
        $msg = executar($consulta);
        if($msg == "Sucesso!"){
            // echo "Nome do Cliente atualizado com sucesso.<br>";
            return true;
        }else{
            echo "Erro ao atualizar nome do Cliente.<br>";
            return false;
        }
    }
}

function verificarIngresso(){
    global $tipoUsuario,$idUsuario, $evento, $idCliente, $vendedor, $codigo, $local, $nomeCliente;
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
    // if ($dados[0]['codigo'] == ""){
        if(gerarIngresso()){
            $local='https://ingressozapp.com/app/enviar.php?codigo='.$codigo;
            enviarIngresso(); 
        }
    // }else{
    //     $local='https://ingressozapp.com/app/enviar.php?codigo='.$dados[0]['codigo'];
    //     echo("<h3>Você já gerou um ingresso para " . $nomeCliente . " deste mesmo Evento . Caso esteja gerando um novo ingresso, para outro cliente, por favor volte e coloque um nome mais completo.<br><br>Caso esteja tentantando reenviar o ingresso pois errou o número do Whatsapp ao gerar o ingresso <a href='$local'>Clique aqui</a> </h3>");

    // }
}

function gerarIngresso(){
    global $codigo, $evento, $vendedor, $idCliente, $telefone, $valor, $idLote;
    $consulta = "INSERT INTO Ingresso (codigo, evento, vendedor, idCliente, valor, lote, origem) VALUES ('$codigo', '$evento', '$vendedor', '$idCliente', '$valor', '$idLote', 2)";
    // echo $consulta;
    $msg = executar($consulta);
    if($msg == "Sucesso!"){
        atualizarVendidosLote(); 
        // echo "Ingresso gerado.";
        return true;
    }else{
        echo "Erro ao gerar Ingresso";
        return false;
    }
    
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
    global $local, $codigo;
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