<?php
    include('../includes/verificarAcesso.php'); 
    $hash = $_GET['hash'];
    $msg = $_GET['msg'];
    // $id = $_GET['id'];
    $consulta = "SELECT Ingresso.codigo, Ingresso.valor, Ingresso.validade, Ingresso.data, Ingresso.validade, Ingresso.msgTitularidade,
    Evento.id as idEvento, Evento.nome as evento, Evento.descricao as descricaoEvento,
    Vendedor.nome as vendedor, Cliente.nome as cliente, Cliente.telefone, Cliente.telefone as idCliente, Lote.nome as lote
    FROM Ingresso 
    JOIN Evento ON Evento.id = Ingresso.evento
    JOIN Vendedor ON Vendedor.id = Ingresso.vendedor
    JOIN Cliente ON Cliente.id = Ingresso.idCliente
    JOIN Lote ON Lote.id = Ingresso.lote
    WHERE Ingresso.hash = '$hash'";
    // $consulta = "SELECT Ingresso.codigo, Ingresso.valor, Ingresso.validade, Ingresso.data, Ingresso.validade, Ingresso.msgTitularidade,
    // Evento.id as idEvento, Evento.nome as evento, Evento.descricao as descricaoEvento,
    // Vendedor.nome as vendedor, Cliente.nome as cliente, Cliente.telefone, Cliente.telefone as idCliente, Lote.nome as lote
    // FROM Ingresso 
    // JOIN Hash ON Hash.hash = Ingresso.hash 
    // JOIN Evento ON Evento.id = Ingresso.evento
    // JOIN Vendedor ON Vendedor.id = Ingresso.vendedor
    // JOIN Cliente ON Cliente.id = Ingresso.idCliente
    // JOIN Lote ON Lote.id = Ingresso.lote
    // WHERE Hash.hash = '$hash' AND Hash.id = '$id'";
    $ingressos = selecionar($consulta);
    $contagem = 1;
    echo '<h5 class="text-center">'. $msg .'</h5>';
    foreach ($ingressos as $ingresso) {
        $evento = $ingresso['evento'];
        $codigo = $ingresso['codigo'];
        $msgTitularidade = $ingresso['msgTitularidade'];
        $cliente = $ingresso['cliente'];
        $idCliente = $ingresso['idCliente'];
        $telefone = $ingresso['telefone'];
        $descricaoEvento = $ingresso['descricaoEvento'];
        $evento = $ingresso['evento'];
        $idEvento = $ingresso['idEvento'];
        $lote = $ingresso['lote'];
        $aux = '../../app/qr_img0.50j/php/qr_img.php?';
        $aux .= 'd='.$codigo.'&';
        $aux .= 'e=H&';
        $aux .= 's=4&';
        $aux .= 't=P';
        
            echo'<h3 style="text-align: center;line-height: 0.8;">'.$evento.'</h3>';
            echo'<h5 style="text-align: center;line-height: 0.8;">Ingresso nº '.$codigo.'</h5>';
            echo ("<img style='width: 60%;margin-left: 20%' src='../getImagem.php?id=$idEvento'/><br>");
            echo ('<img style="margin-left: 25%;" src="'.$aux.'" alt="" width="50%">');
            // echo ('<h6 style="text-align: center;">CODIGO: '.$codigo.'</h6><br>');
            echo ('<h5 style="text-align: center;line-height: 0.8;">Lote: '.$lote.'</h5>');
            echo ('<p style="text-align: justify; text-justify: inter-word;font-size:x-small;line-height: 0.8;">AVISOS: Não compartilhe imagens do seu QR CODE com terceiros, mantenha o seu ingresso em local livre de umidade. O IngressoZapp não se responsabiliza por ingressos comprados fora do domínio "ingressozapp.com" ou de pontos de vendas oficiais do evento, ou por reembolso de valores do ingressos. A responsabilidade de entrega do evento é exclusiva do produtor, entre em contato com o mesmo caso possua alguma dúvida ou reclamação.</p>');
            echo ('<p style="text-align: center;font-size:small;line-height: 0.8;">Emitido utilizando o aplicativo IngressoZapp</p><br><br><br>');
        $contagem ++;
    }
?>
<script>
    if(window.print()){
        history.back();
    };
</script>