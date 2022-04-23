<?php
include('includes/verificarAcesso.php');
verificarAcesso(3);
$hash = bin2hex(openssl_random_pseudo_bytes(32));
if(carregarPost()){
    if(getLote()){
        if(getCliente()){
            verificarIngresso();
        }
    }else{
        header('Location: ingresso.php?msg='.$msg);
    }
};



function carregarPost(){
    global $codigo, $evento, $idLote, $nomeCliente, $inputQuantidade, $telefone, $tipoUsuario, $inputEmail;
    
    $evento    =  $_POST['selectEvento'];
    $consulta = "SELECT `validade` FROM `Evento` WHERE `id` = '$evento'";
    $dados = selecionar($consulta);
    $validadeEvento = $dados[0]['validade'];
    if($validadeEvento != 'VALIDO'){
        $evento = "";
    }
    // $idLote    =  $_POST["selectLote"];
    $nomeCliente   =  $_POST['inputNome'];
    $inputEmail   =  $_POST['inputEmail'];
    $inputQuantidade   =  $_POST['inputQuantidade'];
    $telefone  =  $_POST['inputTelefone'];
    $idLote  =  $_POST['selectLote'];
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
    global $idLote, $valor, $sexo, $quantidade, $vendidos, $inputQuantidade, $vendas, $msg;
    $consulta = "UPDATE `Lote` SET `vendidos`=(SELECT COUNT(Ingresso.codigo) FROM Ingresso WHERE Ingresso.lote = '$idLote') WHERE Lote.id = '$idLote'";
    $msg = executar($consulta);   
    $consulta = "SELECT * FROM Lote WHERE id='$idLote'";
    $obj = selecionar($consulta);
    $lote = $obj[0];
    $valor     =  $lote['valor'];
    $sexo      =  $lote['sexo'];
    $quantidade=  $lote['quantidade'];
    $vendas  =  $lote['vendidos'];
    if($vendas>=$quantidade){
        $consulta = "UPDATE Lote SET validade = 'ESGOTADO' WHERE id = $idLote ";
        $msg = executar($consulta);
        $msg = "Atenção!!! Este lote acabou de se esgotar, selecione outro lote.";
        return false;
    }
    $vendidos  =  $vendas + $inputQuantidade ;
    if($valor == "" || $quantidade == ""){
        $msg = "Dados insuficientes sobre o lote.";
        return false;
    }else{
        // echo "Lote carregado com sucesso!";
        return true;
    }
}

function getCliente(){
    global $nomeCliente, $telefone, $idCliente, $inputEmail;
    $consulta = "SELECT `id` FROM `Cliente` WHERE `telefone` = '$telefone'";
    $dados = selecionar($consulta);
    if($dados[0]['id'] == ""){
        $consulta = "INSERT INTO `Cliente`(`nome`, `telefone`, `email`) VALUES ('$nomeCliente', '$telefone', '$inputEmail')";
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
        $consulta = "UPDATE `Cliente` SET `nome`='$nomeCliente',  `email`='$inputEmail' WHERE `id` = '$idCliente'";
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
    global $tipoUsuario,$idUsuario, $vendidos, $quantidade, $inputQuantidade, $vendedor, $hash, $local, $idLote, $vendas;
    if($tipoUsuario == '1'){
        // $consulta = "SELECT * from Ingresso WHERE evento= '$evento' AND vendedor= '1' AND idCliente= '$idCliente'";
        $vendedor = 1;
    }else if($tipoUsuario == '2'){
        // $consulta = "SELECT * from Ingresso WHERE evento= '$evento' AND vendedor= '2' AND idCliente= '$idCliente'";
        $vendedor = 2;
    }else if($tipoUsuario == '3'){
        // $consulta = "SELECT * from Ingresso WHERE evento= '$evento' AND vendedor= '$idUsuario' AND idCliente= '$idCliente'";
        $vendedor = $idUsuario;
    }
    // $dados = selecionar($consulta);
    if($vendidos <= $quantidade){
        for ($i=0; $i < $inputQuantidade; $i++) { 
            $gerado = gerarIngresso();
        }
    }else{
        $msg =  "Não é possível gerar esta quantidade de ingressos para esse lote, ultimas unidades disponíveis";
    }
    if($gerado){
        $local='http://ingressozapp.com/app/enviar.php?hash='.$hash;
        enviarIngresso(); 
    }else{
        header('Location: ingresso.php?msg='.$msg);
    }
}

function gerarIngresso(){
    global $codigo, $evento, $vendedor, $idCliente, $valor, $idLote, $hash, $msg;
    $codigo = gerarCodigo();
    if($vendedor == 1){
        $origem = 2;
    }else{
        $origem = 1;
    }
    $consulta = "INSERT INTO Ingresso (codigo, evento, vendedor, idCliente, valor, lote, origem, hash) VALUES ('$codigo', '$evento', '$vendedor', '$idCliente', '$valor', '$idLote', '$origem', '$hash')";
    // echo '<br>'.$consulta .'<br>';
    $msg = executar($consulta);
    if($msg == "Sucesso!"){
        return true;
    }else{
        $msg = "Erro ao gerar Ingresso";
        return false;
    }
}



function emailVirada(){
    echo "E-mail enviado";
}

function enviarIngresso(){
    global $local;
    header('Location: '.$local);
}

?>