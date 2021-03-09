<?php
    include_once 'includes/header.php';
session_start();
/*session created*/
$produtor  =  $_SESSION["usuario"];
$validade =  $_SESSION["validade"];

if ($validade == "VALIDO"){

    
echo('
<div class="row">
    <div style="display: flex;margin-left: 30px;">
        <img src="includes/logo.png" alt="" class="logo">
        <div class="">
            <h4>INGRESSOZAPP</h4>
            <h6 style="">LR Software</h6>
        </div>
    
    </div>
    <div class="col s12 m6 push-m3 ">
        
        <div class="titulo">    
            <h3>PAINEL ADMINISTRATIVO</h3>
        </div>
        <div class="ico">
            <a href="https://ingressozapp.com/produtor/visualizar/vendedor.php"><img src="includes/vendedor.png"class="ic"/></a>
            <p class="ti">Vendedores</p>
        </div>
        <div class="ico">
            <a href="https://ingressozapp.com/produtor/visualizar/evento.php"><img src="includes/evento.png" class="ic"/></a>
            <p class="ti">Eventos</p>
        </div>
        <div class="ico">
            <a href="https://ingressozapp.com/produtor/lote/visualizar.php"><img src="includes/lote.png" class="ic"></a>
            <p class="ti">Lotes</p>
        </div>
        <div class="ico">
            <a href="https://ingressozapp.com/produtor/custos/"><img src="includes/custo.png" class="ic"></a>
            <p class="ti">Custos</p>
        </div>
        <div class="ico">
            <a href="https://ingressozapp.com/produtor/recebimento/"><img src="includes/ingresso.png" class="ic"/></a>
            <p class="ti">Recebimento</p>
        </div>
        <div class="ico">
            <a href="https://ingressozapp.com/bar/produtos/"><img src="../includes/caixa.png" class="ic"/></a>
            <p class="ti">Bar</p>
        </div>
        <div class="ico">
            <a href="https://ingressozapp.com/produtor/relatorio" ><img src="includes/relatorio.png" class="ic"></a>
            <p class="ti">Relatórios</p>
        </div>
        <a href="https://ingressozapp.com/produtor/login/index.php" ><p class="ti">Sair<p></a>
    </div>
</div>
');
} else {
    header('Location: https://ingressozapp.com/produtor/login/');
}


include_once 'includes/footer.php';
?>