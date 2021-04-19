<?php
include('./includes/verificarAcesso.php');
verificarAcesso(3);
include('./includes/header.php');
?>
<div style='background-image: url("./img/fundoLogin.jpg"); background-size: cover;height: 100%;'>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Sobre Nós</h3>
                    </div>
                    <div class="card-body">
                        <p class="text-justify font-weight-light">  
                            <span style="margin: 50px;">
                            O Sistema de gerenciamento de venda de ingressos IngressoZapp foi criado no início de 2020. 
                            Surgiu a partir da necessidade do nosso criador em seus próprios eventos. 
                            Habituado a vender seus ingressos por meio de promoters oficiais do evento, 
                            sentiu falta de um sistema que que permitisse um melhor controle dessas vendas, 
                            visto que, morava a cerca de mil quilômetros do local onde realizava anualmente seus eventos. 
                            <br><br>
                            <span style="margin: 50px;">
                            O aplicativo além de permitir ao produtor acompanhar em tempo real a venda dos ingresso, 
                            ainda levanta informações importantes para as estratégias de Marketing adotadas por ele, 
                            elimina a logística de distribuição e reposição de ingresso, extingue o custo de impressão do ingressos físicos, 
                            impede fraudes, permite um melhor controle de disponibilidade dos lotes à venda e constrói um banco de dados 
                            organizado dos clientes, facilitando a venda em eventos futuros.</p>
                        <a href="http://ingressozapp.com/" target="_blank" class="btn btn-primary btn-block" rel="noopener noreferrer">Saiba Mais</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('./includes/footer.php');
?>