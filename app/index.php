<?php
include('./includes/verificarAcesso.php');
include('./includes/header.php');
?>
<div style='background-image: url("./img/fundoLogin.jpg"); background-size: cover;height: 100%;'>
    <div style="width: 96%; margin-left: 2%;">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h5 class="text-center font-weight-light my-4">Bem vindo ao Guia de utilização do aplicativo IngressoZapp!</h5>
                    </div>
                    <div class="card-body">
                        <?php
                            if($idUsuario == ""){
                                echo '<a style="margin-bottom:10px;" class="btn btn-primary btn-block mb-3" href="login/index.php"><h6>Fazer login</h6></a>';
                            }else{
                                echo '<div class="row">';
                                    echo '<div class="col-lg-6 mb-3"><a class="btn btn-primary btn-block" href="ingresso.php"><i class="fas fa-ticket-alt"></i> Emitir ingresso</a></div>';
                                    echo '<div class="col-lg-6 mb-3"><a class="btn btn-primary btn-block" href="./eventos/adicionar.php"><i class="fas fa-plus"></i> Criar Evento</a></div>';
                                echo '</div>';
                            }
                        ?>
                        <div class="row">
                            <?php
                                if($tipoUsuario == 2){
                                    $consulta = "SELECT Evento.id, Evento.nome, Evento.slug, Evento.data, Evento.descricao, Evento.validade, (SELECT SUM(valor) FROM Ingresso WHERE Ingresso.evento = Evento.id AND (Ingresso.validade = 'USADO' OR Ingresso.validade = 'VALIDO')) as vendas, (SELECT COUNT(valor) FROM Ingresso WHERE Ingresso.evento = Evento.id AND (Ingresso.validade = 'USADO' OR Ingresso.validade = 'VALIDO')) as quantidade, (SELECT COUNT(id) FROM Lote WHERE Lote.evento = Evento.id) as lotes FROM Evento WHERE produtor = '$idUsuario' AND validade != 'EXCLUIDO' ORDER BY data DESC";
                                    addTabela($consulta);
                                    $consulta = "SELECT Evento.id, Evento.nome, Evento.slug, Evento.data, Evento.descricao, Evento.validade, (SELECT SUM(valor) FROM Ingresso WHERE Ingresso.evento = Evento.id AND (Ingresso.validade = 'USADO' OR Ingresso.validade = 'VALIDO')) as vendas, (SELECT COUNT(valor) FROM Ingresso WHERE Ingresso.evento = Evento.id AND (Ingresso.validade = 'USADO' OR Ingresso.validade = 'VALIDO')) as quantidade, (SELECT COUNT(id) FROM Lote WHERE Lote.evento = Evento.id) as lotes FROM Evento JOIN Coprodutor ON Evento.id = Coprodutor.idEvento WHERE Coprodutor.idProdutor = '$idUsuario' AND Evento.validade != 'EXCLUIDO' ORDER BY Evento.data DESC";
                                    addTabela($consulta);
                                }
                            ?>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <a style="margin-bottom:10px;" class="btn btn-primary btn-block" href="./eventos"><h6><i class="far fa-calendar-alt"></i> Meus Eventos</h6></a>
                            </div>
                            <div class="col-lg-4">
                                <a style="margin-bottom:10px;" class="btn btn-primary btn-block" href="./vendedores"><h6><i class="fas fa-user-friends"></i> Meus Vendedores</h6></a>
                            </div>
                            <div class="col-lg-4">
                                <a style="margin-bottom:10px;" class="btn btn-primary btn-block" href="./clientes"><h6><i class="fas fa-user-friends"></i> Meus Clientes</h6></a>
                            </div> 
                        </div>
                        <div id="ingressozapp" class="row mt-5">
                            <div class="col-lg-3">
                                <img src="img/ingressozapp.jpeg" style="width:100%" alt="Imagem App Ingressozapp" srcset="">
                            </div>
                            <div class="col-lg-9">
                                <p class="text-justify">  
                                    <span style="margin: 50px;">
                                    O sistema de gestão de eventos IngressoZapp foi criado no fim de 2019. Surgiu a partir da necessidade do nosso criador em seus próprios eventos. Habituado em vender seus ingressos por meio de promoters oficiais do evento, sentiu a falta de uma gestão que permitisse um controle eficiente de suas vendas e obter com assertividade relatórios gráficos e insights para aprimorar cada vez mais seus eventos, inibindo gastos desnecessários e aumentando a lucratividade por meio da tecnologia.<br>
                                    <span style="margin: 50px;">
                                    Surgiu inicialmente como um aplicativo de emissão de ingressos online utilizando a tecnologia QR CODE e enviando convite diretamente para o WhatsApp do cliente. O IngressoZapp revolucionou o mercado de vendas de ingressos por promotoria, ao permitir aos promoters venderem sem sair de casa. A partir da ideia inicial o sistema evoluiu para um Sistema completo de gestão de eventos, utilizado por dezenas de produtores.<br>
                                    <span style="margin: 50px;">
                                    O aplicativo além de permitir ao produtor acompanhar em tempo real a venda dos ingressos, monitora individualmente o desempenho de seus vendedores, e, ainda gera informações importantes para as estratégias de Marketing adotadas por ele, faz o cadastro dos produtos e vendas do bar em tempo real, online, com ou sem o uso de um cartão físico com a tecnologia QR CODE disponibilizados para os produtores pela Empresa, elimina a logística de distribuição e reposição de ingresso, extingue o custo de impressão dos ingressos físicos, impede fraudes, permite um maior e melhor controle de disponibilidade dos lotes a venda e, ainda constrói um banco de dados organizado dos clientes, facilitando o marketing para os eventos futuros. Unindo a venda dos Ingressos, vendas do bar e o controle de custos do seu evento, tenha relatórios completos do seu resultado financeiro. Evite surpresas e tenha mais assertividade em sua estratégia com o IngressoZapp.<br>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .descricao{
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 6;
        -webkit-box-orient: vertical; 
    }
    .card-footer{
        background-color: #03382d;  
    }
    .infos{
        color: #fff;
    }
    .infos:hover{
        color: #35898d
    }
</style>
<?php

    function addTabela($consulta){
        $eventos = selecionar($consulta);
        if(sizeof($eventos) == 1){
            echo'<div style="width: 37%"></div>';
        }else if(sizeof($eventos) == 2){
            echo'<div style="width: 25%"></div>';
        }else if(sizeof($eventos) == 3){
            echo'<div style="width: 19  %"></div>';
        }
        foreach ($eventos as $evento) {
            echo '<div class="col-lg-3">';
                echo '<div class="card shadow-lg border-0 rounded-lg mt-1">';
                    echo '<div class="card-header">';
                        echo '<h5 class="text-center my-0" style="font-size:small;">'.$evento['nome'].'</h5>';
                        echo '<a href="https://ingressozapp.com/eventos/'.$evento['slug'].'" class="float-left my-1 " style="font-size:x-small; color:#fff"><i class="fas fa-link"></i> Link do Evento</a>';
                        echo '<h6 class="float-right my-1" style="font-size:x-small;"><i class="fas fa-calendar"></i> '.$evento['data'].'</h6>';
                    echo '</div>';
                    echo '<a href="https://ingressozapp.com/app/assets/selecionarEvento.php?idEvento='.$evento['id'].'&nomeEvento='.$evento['nome'].'&u=/app/relatorios/vendaIngresso/">';
                        echo '<div class="card-body">';
                            echo '<div class="d-flex">';
                                echo '<img class="imgEvento w-25" style="height: 100px;"src="getImagem.php?id='.$evento['id'].'"/>';
                                echo '<p class="descricao text-muted w-75 px-2" style="font-size:x-small; height: 90px;">Descrição: '.$evento['descricao'].'</p>';
                            echo '</div>';
                            echo '<p class="float-right"><i class="fas fa-chart-line"></i> Relatório</p>';
                        echo '</div>';
                    echo '</a>';
                    echo '<div class="card-footer d-flex" style="padding: 1em">';
                        echo '<a href="https://ingressozapp.com/app/assets/selecionarEvento.php?idEvento='.$evento['id'].'&nomeEvento='.$evento['nome'].'&u=/app/lotes/" class="infos" style="height: 30px; width:33%;">';
                            echo '<p style="font-size:xx-small; margin-bottom:0;">Lotes: </p>';
                            echo '<p style="font-size:x-small;">'.$evento['lotes'].' lotes</p>';
                        echo '</a>';
                        echo '<a href="https://ingressozapp.com/app/assets/selecionarEvento.php?idEvento='.$evento['id'].'&nomeEvento='.$evento['nome'].'&u=/app/relatorios/vendaIngresso/" class="infos" style="height: 30px; width:33%;">';
                            echo '<p style="font-size:xx-small; margin-bottom:0;">Ingressos: </p>';
                            echo '<p style="font-size:x-small;">'.$evento['quantidade'].' ingressos</p>';
                        echo '</a>';
                        echo '<a href="https://ingressozapp.com/app/assets/selecionarEvento.php?idEvento='.$evento['id'].'&nomeEvento='.$evento['nome'].'&u=/app/relatorios/vendaIngresso/" class="infos" style="height: 30px; width:334;">';
                            echo '<p style="font-size:xx-small; margin-bottom:0;">Vendas: </p>';
                            echo '<p style="font-size:x-small;">R$'.number_format($evento['vendas'],2,",",".").'</p>';
                        echo '</a>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        }
    }
                            
    include('./includes/footer.php');
?>