<?php
    include('../../includes/verificarAcesso.php');
    verificarAcesso(2);
    $id   = $_POST['id'];
    $inputValor   = $_POST['inputValor'];
    $observacao   = $_POST['observacao'];
    $comprovante      = $_FILES["comprovante"];

    function getRetirada(){
        global $id, $valorRetirada, $dataRetirada, $chavePIX, $tipoPIX, $nomePIX;
        $consulta = "SELECT * FROM Retiradas WHERE Retiradas.id = '$id'";
        $dados = selecionar($consulta);
        $retirada = $dados[0];
        $valorRetirada = $retirada['valor'];
        $dataRetirada = $retirada['createdAt'];
        $chavePIX = $retirada['chavePIX'];
        $tipoPIX = $retirada['tipoPIX'];
        $nomePIX = $retirada['nome'];
    }

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
        WHERE Retiradas.idEvento = '$idEvento' AND Retiradas.status = '2'";
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

    if($inputValor <= $valor + 150){
        echo "OK";
        $consulta = "UPDATE `Retiradas` SET `status`='2',`comprovante`='',`valorExecutado`='$inputValor',`valorTaxas`='0',`descricaoTaxas`='$observacao' WHERE `id` = '$id'";
        $msg = executar($consulta);
        if($msg != "Sucesso!"){
                $msg = "Erro ao criar Retirada, por favor contate o suporte!!";
                header('Location: executar.php?msg='.$msg);
        }else{
            header('Location: index.php?msg='.$msg);
        }
    }else{
        $msg = "Valor Incorreto: Digite um valor abaixo do valor Disponível + taxa de R$150,00";
        echo $msg;
        // header('Location: executar.php?msg='.$msg);
    }
?>