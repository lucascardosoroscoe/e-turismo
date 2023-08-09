<?php
    include_once 'includes/header.php';
session_start();
/*session created*/
$master  =  $_SESSION["usuario"];
$login =  $_SESSION["login"];

if ($login == "VALIDO"){

    
echo('
<div class="row">
    <div class="col s12 m6 push-m3 ">
        <img src="includes/logo.png"class="logo">
        <div class="titulo">    
            <h3>PAINEL CENTRAL</h3>
        </div>
        <div class="ico">
            <a href="https://ingressozapp.com/master/visualizar/evento.php"><img src="includes/evento.png" class="ic"/></a>
            <p class="ti">Eventos</p>
        </div>
        <div class="ico">
            <a href="https://ingressozapp.com/master/visualizar/produtor.php"><img src="includes/vendedor.png"class="ic"/></a>
            <p class="ti">Produtores</p>
        </div>
        <div class="ico">
            <a href="https://ingressozapp.com/master/visualizar/ingresso.php"><img src="includes/ingresso.png" class="ic"/></a>
            <p class="ti">Ingressos</p>
        </div>
        <div class="ico">
            <a href="https://ingressozapp.com/master/lote"><img src="includes/lote.png" class="ic"></a>
            <p class="ti">Lotes</p>
        </div>
        <div class="ico" style="margin-left: 25%;">
            <a href="https://ingressozapp.com/master/relatorio" ><img src="includes/relatorio.png" class="ic"></a>
            <p class="ti">Relatórios</p>
            <br>
            <a href="https://ingressozapp.com/produtor/login/index.php" ><p class="ti">Sair<p></a>
        </div>
    </div>
</div>
');
} else {
    header('Location: https://ingressozapp.com/master/login/');
}


include_once 'includes/footer.php';
?>