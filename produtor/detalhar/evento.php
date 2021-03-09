<?php
    include_once '../includes/header.php';
    include 'selecionar_evento.php';
?>
<div class="row">
    <div class="col s12 m6 push-m3 ">
        <?php
        echo('<h3 id="edit">Nome: '.$nome.'</h3>');

        $descricao = $obj['descricao'];
        

        echo ('<a href="../editar/evento.php?nome='.$nome.'&descricao='.$descricao.'"><img src="../includes/editar.png" id="editar" class="icone"/></a>');
        echo ('<a href="../invalidar/evento.php?nome='.$nome.'"><img src="../includes/invalidar.png" id="excluir"   class="icone"/></a>');
        echo ('<a href="../reativar/evento.php?nome='.$nome.'"><img src="../includes/revalidar.png" id="reativar"   class="icone"/></a>');
  
            
        
        //echo json_encode($primeiro);
        //echo "<br>";
        //imprime o conteúdo do objeto 
        echo ("<h4 id='nome'>Nome do evento: ".$obj['nome']."</h4>"); 
        echo ("<img class='imgEvento' src='../../getImagem.php?nome=$nome&produtor=$produtor'/>");
        echo ("<h4>Data do Evento: ".$obj['data']."</h4>"); 
        echo ("<h4>Descrição do Evento: ".$obj['descricao']."</h4>"); 
        echo ("<h4>Validade do Evento: ".$obj['validade']."</h4>");
           
        ?>
        <a href="https://ingressozapp.com/produtor/" class="btn">Voltar</a>
    </div>
</div>
<?php
    include_once '../includes/footer.php';
?>