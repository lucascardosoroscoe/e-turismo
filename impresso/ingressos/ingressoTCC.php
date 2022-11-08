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
    $ingressos = selecionar($consulta);
    $contagem = 1;
    // echo '<h5 class="text-center">'. $msg .'</h5>';
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
            $evento = $ingresso['evento'];
            $idEvento = $ingresso['idEvento'];
            $lote = $ingresso['lote'];
            $aux = '../../app/qr_img0.50j/php/qr_img.php?';
            $aux .= 'd='.$codigo.'&';
            $aux .= 'e=H&';
            $aux .= 's=4&';
            $aux .= 't=P';
            echo '<div class="page">';
                ?>
                <div class="esquerda" style="width: 100px;">
                    <img src="logoFMV.png" class="fvl">
                </div>
                <div class="centro" style="width: 200px;height:48mm">
                    <p style="text-align: center;font-size: 12px"><?php echo $evento . ' - ' . $data?></p>
                    <?php echo "<img src='logoRick.png' alt='' style='width: 150px'>";?>
                    <p style="text-align: center;font-size: 12px">Local: Crystal Hall</p>
                </div>
                <div class="direita" style="width: 100px;">
                    <img src="logoIngressozapp.png" alt="" style="width: 90px;margin-top:10px">
                    <?php 
                        echo'<p style="text-align: center;font-size: 9px; margin:2px;">Ingresso nº '.$codigo.'</p>';
                        echo'<p style="text-align: center;font-size: 9px; margin:2px;">Valor: R$'.$valor.'</p>';
                        echo ('<img style="margin-left:5%" src="'.$aux.'" alt="" width="90%">');
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
    
?>
<link rel="stylesheet" href="print.css">
<script>
    if(window.print()){
        history.back();
    };
</script>