<?php
include('../app/includes/verificarAcesso.php');
verificarAcesso(1);
$hash = bin2hex(openssl_random_pseudo_bytes(32));
if(carregarPost()){
    if(getLote()){
        if(verificarIngresso()){     
            exibirIngressos(); 
        }else{
            header('Location: index.php?msg='.$msg);
        }


    }else{
        // header('Location: index.php?msg='.$msg);
    }
};



function carregarPost(){
    global $evento, $idLote, $inputQuantidade, $telefone, $tipoUsuario, $inputPreco, $inputLote, $imagem;
    
    $evento    =  $_POST['selectEvento'];
    $consulta = "SELECT `validade` FROM `Evento` WHERE `id` = '$evento'";
    $dados = selecionar($consulta);
    $validadeEvento = $dados[0]['validade'];
    if($validadeEvento != 'VALIDO'){
        $evento = "";
    }
    $inputPreco   =  $_POST['inputPreco'];
    $inputLote  =  $_POST['inputLote'];
    $inputQuantidade   =  $_POST['inputQuantidade'];
    $idLote  =  $_POST['selectLote'];
    $imagem      = $_FILES["inputImagem"];
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
    if($evento == "" || $idLote == ""){
        echo "<h4>Evento: " . $evento ."<br>";
        echo "idLote: " . $idLote ."<br>";
        echo "Dados insuficientes para gerar o Ingresso, provavelmente o lote que você tentou vender já não está mais disponível.
        <a href='index.php'>CLIQUE AQUI PARA VOLTAR NA PÁGINA DE EMISSÃO</a></h4>";
        return false;
    }else{
        return true;
    }
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
        return true;
    }
}

function verificarIngresso(){
    global $vendidos, $quantidade, $inputQuantidade, $msg, $local;
    if($vendidos <= $quantidade){
        for ($i=0; $i < $inputQuantidade; $i++) { 
            $gerado = gerarIngresso();
        }
    }else{
        $msg =  "Não é possível gerar esta quantidade de ingressos para esse lote, ultimas unidades disponíveis";
    }
    return $gerado;
}

function gerarIngresso(){
    global $codigo, $evento, $idCliente, $valor, $idLote, $hash, $msg;
    $idCliente = 1;
    $origem = 3;
    $codigo = gerarCodigo();
    $consulta = "INSERT INTO Ingresso (codigo, evento, vendedor, idCliente, valor, lote, origem, hash) VALUES ('$codigo', '$evento', '4', '$idCliente', '$valor', '$idLote', '$origem', '$hash')";
    $msg = executar($consulta);
    if($msg == "Sucesso!"){
        return true;
    }else{
        $msg = "Erro ao gerar Ingresso";
        return false;
    }
}

function gerarCodigo(){
    $codigo = 0;
    while ($codigo == 0) {
        $codigo    =  rand ( 000000 , 999999 );
        $consulta = "SELECT * FROM `Ingresso` WHERE `codigo` = '$codigo'";
        $dados = selecionar($consulta);
        if($dados[0] != ""){
            // echo "Código ". $codigo ." já existe, gerando novo código.";
            $codigo = 0;
        }
    }
    return $codigo;
}





function exibirIngressos(){
    global $hash, $imagem, $inputPreco, $inputLote;
    if($imagem != NULL) { 
        {
            $ext = strtolower(substr($imagem['name'],-4)); //Pegando extensão do arquivo
            $new_name = time(). rand() . $ext; //Definindo um novo nome para o arquivo
            $dir = './imagens/'; //Diretório para uploads 
            move_uploaded_file($imagem['tmp_name'], $dir.$new_name); //Fazer upload do arquivo
         } 
    }
    $consulta = "SELECT Ingresso.codigo, Ingresso.valor, Ingresso.validade, Ingresso.data, Ingresso.validade, Ingresso.msgTitularidade,
    Evento.id as idEvento, Evento.nome as evento, Evento.descricao as descricaoEvento, Evento.data as dataE,
    Vendedor.nome as vendedor, Cliente.nome as cliente, Cliente.telefone, Cliente.telefone as idCliente, Lote.nome as lote
    FROM Ingresso 
    JOIN Evento ON Evento.id = Ingresso.evento
    JOIN Vendedor ON Vendedor.id = Ingresso.vendedor
    JOIN Cliente ON Cliente.id = Ingresso.idCliente
    JOIN Lote ON Lote.id = Ingresso.lote
    WHERE Ingresso.hash = '$hash'";
    $ingressos = selecionar($consulta);
    $contagem = 1;
    echo('<div class="line">');
        foreach ($ingressos as $ingresso) {
            $evento = $ingresso['evento'];
            $codigo = $ingresso['codigo'];
            $valor = $ingresso['valor'];
            $msgTitularidade = $ingresso['msgTitularidade'];
            $cliente = $ingresso['cliente'];
            $idCliente = $ingresso['idCliente'];
            $telefone = $ingresso['telefone'];
            $descricaoEvento = $ingresso['descricaoEvento'];

            $dataI = $ingresso['data'];
            $dataE = $ingresso['dataE'];
            $idEvento = $ingresso['idEvento'];
            $lote = $ingresso['lote'];
            $aux = '../app/qr_img0.50j/php/qr_img.php?';
            $aux .= 'd='.$codigo.'&';
            $aux .= 'e=H&';
            $aux .= 's=4&';
            $aux .= 't=P';
            echo '<div class="page">';
                ?>
                <div class="esquerda" style="width: 100px;margin-right:40px">
                    <!-- <img src="logoTCC.png" class="fvl"> -->
                    <img src="logoIngressozapp.png" class="fvl">
                </div> 
                <div class="centro" style="width: 200px;height:39.5mm">
                <?php $dataE = date_create($dataE);?>

                <!-- <p style="text-align: center;font-size: 10px"><?php echo $evento . ' - ' . date_format($dataE, 'd-m');?></p> -->
                <p style="text-align: center;font-size: 10px"><?php echo $evento;?></p>
                <?php //echo "<img src='../getImagem.php?id=$idEvento' alt='' style='width: 150px'>";?>
                    <?php echo "<img src='./imagens/".$new_name."' alt='' style='width: 145px;'>";?>
                </div> 
                <div class="direita"> 
                    <img src="logoIngressozapp.png" alt="" style="width: 90px;margin-top:10px">
                    <?php 
                        echo'<p style="text-align: center;font-size: 9px; margin:2px;">Ingresso nº '.$codigo.'</p>';
                        if ($inputPreco) {
                            if($inputLote){
                                echo'<p style="text-align: center;font-size: 8px; margin:2px;">'.$lote.' R$'.$valor.'</p>';
                            }else{
                                echo'<p style="text-align: center;font-size: 8px; margin:2px;">R$'.$valor.'</p>';
                            }
                        }else{
                            if($inputLote){
                                echo'<p style="text-align: center;font-size: 8px; margin:2px;">'.$lote.'</p>';
                            }
                        }

                        echo ('<img style="margin-left:10%" src="'.$aux.'" alt="" width="80%">');
                    ?>
                </div>
                <?php 
            echo '</div>';
            if($contagem ==1){
                $contagem++;
            }else{
                echo('</div>');
                echo('<div class="line">');
                $contagem = 1;
            }

        }
        
    echo('</div>');
}



?>

<link rel="stylesheet" href="print.css">

<script>
    if(window.print()){
        history.back();
    };
</script>