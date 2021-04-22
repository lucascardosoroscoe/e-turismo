<?php
    include_once '../includes/header.php';
    include 'selecionar_vendedor.php';
?>
<div class="row">
    <div class="col s12 m6 push-m3 ">
        <?php

        echo ('<h3 class="light">'.$usuário.'</h3>');
        
        $nome = $obj['nome'];
        $telefone = $obj['telefone'];
        $email = $obj['email'];
        $validade = $obj['validade'];
      
        echo ('<a href="../editar/vendedor.php?usuario='.$nom.'&nome='.$nome.'&telefone='.$telefone.'&email='.$email.'&validade='.$validade.'"><img src="../includes/editar.png" id="editar"    class="icone"/></a>');
        echo ('<a href="../invalidar/vendedor.php?usuario='.$nom.'"><img src="../includes/invalidar.png" id="excluir" class="icone"/></a>');
        echo ('<a href="../reativar/vendedor.php?usuario='.$nom.'"><img src="../includes/revalidar.png" id="reativar" class="icone"/></a>');
        
        echo ('<h5>Nome: '.$nome.'</h5>');
        echo ('<h5>Telefone: '.$telefone.'</h5>');
        echo ('<h5>E-mail: '.$email.'</h5>');
        echo ('<h5>Validade: '.$validade.'</h5>');
       
        ?>

        <a href="https://ingressozapp.com/produtor/" class="btn">Voltar</a>
    </div>
</div>

<?php
    include_once '../includes/footer.php';
?>