<?php
    include_once '../includes/header.php';
    include 'selecionar_produtor.php';
?>
<div class="row">
    <div class="col s12 m6 push-m3 ">
        <?php

        echo ('<h3 class="light">'.$user.'</h3>');
        
        $pass = $obj['senha'];
        $nome = $obj['nome'];
        $telefone = $obj['telefone'];
        $email = $obj['email'];
        $validade = $obj['validade'];
        $cidade = $obj['cidade'];
        $estado = $obj['estado'];
      
        echo ('<a href="../editar/produtor.php?usuario='.$user.'&senha='.$pass.'&nome='.$nome.'&telefone='.$telefone.'&email='.$email.'&validade='.$validade.'&cidade='.$cidade.'&estado='.$estado.'"><img src="../includes/editar.png" id="editar"    class="icone"/></a>');
        echo ('<a href="../invalidar/produtor.php?usuario='.$user.'"><img src="../includes/invalidar.png" id="excluir" class="icone"/></a>');
        echo ('<a href="../reativar/produtor.php?usuario='.$user.'"><img src="../includes/revalidar.png" id="reativar" class="icone"/></a>');
        
        echo ('<h5>Usuário: '.$user.'</h5>');
        echo ('<h5>Senha: '.$pass.'</h5>');
        echo ('<h5>Nome: '.$nome.'</h5>');
        echo ('<h5>Telefone: '.$telefone.'</h5>');
        echo ('<h5>E-mail: '.$email.'</h5>');
        echo ('<h5>Validade: '.$validade.'</h5>');
        echo ('<h5>E-mail: '.$cidade.'</h5>');
        echo ('<h5>Validade: '.$estado.'</h5>');
        ?>

        <a href="https://ingressozapp.com/master/" class="btn">Voltar</a>
    </div>
</div>

<?php
    include_once '../includes/footer.php';
?>