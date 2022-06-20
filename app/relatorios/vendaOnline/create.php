<?php
    include('../../includes/verificarAcesso.php');
    verificarAcesso(2);
    $inputValor   = $_POST['inputValor'];
    $inputNome   = $_POST['inputNome'];
    $inputTipoPIX   = $_POST['inputTipoPIX'];
    $inputPIX   = $_POST['inputPIX'];
    function calcularValor(){
        global $vendas, $retiradas, $taxas;
        $vendas = getVendas();
        $retiradas = getRetiradas();
        $taxas = getTaxas();
        $valor = $vendas - $retiradas - $taxas;
        return $valor;
    }
    function getVendas(){
        global $idEvento;
        $consulta = "SELECT SUM(Ingresso.valor) as valor FROM Ingresso 
        WHERE Ingresso.evento = '$idEvento' AND Ingresso.validade != 'CANCELADO' AND Ingresso.vendedor = '1'";
        $dados = selecionar($consulta);
        $linkPrincipal = $dados[0]['valor'];
        $consulta = "SELECT SUM(Ingresso.valor) as valor FROM Ingresso
        WHERE Ingresso.evento = '$idEvento' AND Ingresso.validade != 'CANCELADO' AND Ingresso.vendedor != '1' AND Ingresso.origem = '2'";
        $dados = selecionar($consulta);
        $indicacoes = $dados[0]['valor'];
        return $linkPrincipal + $indicacoes;
    }
    function getRetiradas(){
        global $idEvento;
        $consulta = "SELECT SUM(Retiradas.valor) as valor FROM Retiradas 
        WHERE Retiradas.idEvento = '$idEvento' AND Retiradas.status != '3'";
        $dados = selecionar($consulta);
        return $dados[0]['valor'];
    }
    function getTaxas(){
        global $idEvento, $taxas;
        $consulta = "SELECT count(Ingresso.codigo) as quantidade FROM Ingresso 
        WHERE Ingresso.evento = '$idEvento' AND Ingresso.validade != 'CANCELADO' AND Ingresso.vendedor != '1' AND Ingresso.origem = '1'";
        $dados = selecionar($consulta);
        $quantidade = $dados[0]['quantidade'];
        if($quantidade >= 10){
            $taxas = $taxas + 150;
        }
        return $taxas;
    }
    $valor = calcularValor();



    if($inputValor <= $valor){
        $consulta = "INSERT INTO `Retiradas`(`idEvento`, `valor`, `tipoPIX`, `chavePIX`, `nome`) VALUES ('$idEvento','$inputValor','$inputTipoPIX','$inputPIX','$inputNome')";
        $msg = executar($consulta);
        if($msg != "Sucesso!"){
                $msg = "Erro ao criar Retirada, por favor contate o suporte!!";
                header('Location: addRetirada.php?msg='.$msg);
        }else{
            header('Location: index.php?msg='.$msg);
        }
    }else{
        $msg = "Valor Incorreto: Digite um valor abaixo do valor Disponível";
        header('Location: addRetirada.php?msg='.$msg);
    }
?>