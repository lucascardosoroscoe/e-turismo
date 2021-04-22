<?php
    include_once '../includes/header.php';
    include 'selecionar_ingresso.php';
?>
<div class="row">
    <div class="col s12 m6 push-m3 ">
        <?php

        $evento = $obj['evento'] ;
        $vendedor = $obj['vendedor'];
        $cliente = $obj['cliente'];
        $telefone = $obj['telefone'];
        $valor = $obj['valor'];
        $lote = $obj['lote'];
        $sexo = $obj['sexo'];
        $validade = $obj['validade'];
        $data = $obj['data'];

        echo ('<h3 class="light">Código: '.$codigo.'</h3>');
        echo ('<a href="../editar/ingresso.php?codigo='.$codigo.'&evento='.$evento.'&vendedor='.$vendedor.'&cliente='.$cliente.'&telefone='.$telefone.'&valor='.$valor.'&lote='.$lote.'&sexo='.$sexo.'"><img src="../includes/editar.png" id="editar"bclass="icone"/></a>');
        echo ('<a href="../invalidar/ingresso.php?codigo='.$codigo.'"><img src="../includes/invalidar.png" id="excluir" class="icone"/></a>');
        echo ('<a href="../reativar/ingresso.php?codigo='.$codigo.'"><img src="../includes/revalidar.png" id="reativar" class="icone"/></a>');                        
       
        //echo json_encode($primeiro);
        //echo "<br>";
        //imprime o conteúdo do objeto 
        echo ("<h5>Código do ingresso: ".$obj['codigo']."</h5>"); 
        echo ("<h5>Evento: ".$obj['evento']."</h5>"); 
        echo ("<h5>Vendedor: ".$obj['vendedor']."</h5>"); 
        echo ("<h5>Cliente: ".$obj['cliente']."</h5>");
        echo ("<h5>Telefone: ".$obj['telefone']."</h5>"); 
        echo ("<h5>Valor: ".$obj['valor']."</h5>"); 
        echo ("<h5>Lote: ".$obj['lote']."</h5>"); 
        echo ("<h5>Sexo: ".$obj['sexo']."</h5>");
        echo ("<h5>Validade: ".$obj['validade']."</h5>"); 
        echo ("<h5>Data: ".$obj['data']."</h5>"); 
           
        ?>
        <button onclick="window.history.back()" class="btn">Voltar</button>
    </div>
</div>


<?php
    include_once '../includes/footer.php';
?>