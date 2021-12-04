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
                            echo '<a style="margin-bottom:10px;" class="btn btn-primary btn-block" href="login/index.php"><h6>Fazer login</h6></a>';
                        }else{
                            echo '<a style="margin-bottom:10px;" class="btn btn-primary btn-block"  href="ingresso.php"><h6>Emitir ingresso</h6></a>';
                        }
                        ?>
                        
                        <div class="menuSelecaoGuias">
                            <div class="row">
                                <div class="col-lg-4">
                                    <a style="margin-bottom:10px;" class="btn btn-primary btn-block" href="#ingressozapp"><h6>IngressoZapp - Introdução <i class="fas fa-sort-down"></i></h6></a>
                                </div>
                                <div class="col-lg-4">
                                    <a style="margin-bottom:10px;" class="btn btn-primary btn-block" href="#promoter"><h6>Promoter - Venda de Ingressos <i class="fas fa-sort-down"></i></h6></a>
                                </div>
                                <div class="col-lg-4">
                                    <a style="margin-bottom:10px;" class="btn btn-primary btn-block" href="#intro"><h6>Produtor - Inscrição no IngressoZapp <i class="fas fa-sort-down"></i></h6></a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <a style="margin-bottom:10px;" class="btn btn-primary btn-block" href="#barIntro"><h6>Bar - Introdução <i class="fas fa-sort-down"></i></h6></a>
                                </div>
                                <div class="col-lg-4">
                                    <a style="margin-bottom:10px;" class="btn btn-primary btn-block" href="#caixa"><h6>Caixa - Carregando Saldo <i class="fas fa-sort-down"></i></h6></a>
                                </div>
                                <div class="col-lg-4">
                                    <a style="margin-bottom:10px;" class="btn btn-primary btn-block" href="#bar"><h6>Bar - Entrega dos Produtos <i class="fas fa-sort-down"></i></h6></a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <a style="margin-bottom:10px;" class="btn btn-primary btn-block" href="#portaria"><h6>Portaria - Conferência de Ingressos <i class="fas fa-sort-down"></i></h6></a>
                                </div>
                                <div class="col-lg-4">
                                    <a style="margin-bottom:10px;" class="btn btn-primary btn-block" href="#produtor"><h6>Produtor - Gerencie seu Evento <i class="fas fa-sort-down"></i></h6></a>
                                </div>
                                <div class="col-lg-4">
                                    <a style="margin-bottom:10px;" class="btn btn-primary btn-block" href="#produtor"><h6>Produtor - Dicas <i class="fas fa-sort-down"></i></h6></a>
                                </div>
                            </div>
                        </div>
                        
                        <div id="ingressozapp" class="row">
                            <div class="col-lg-12">
                                <h5 style="padding-top:50px; padding-bottom: 30px;">IngressoZapp - Introdução</h5>
                            </div>
                            <div class="col-lg-4">
                                <img src="img/ingressozapp.png" style="width:100%" alt="Imagem App Ingressozapp" srcset="">
                            </div>
                            <div class="col-lg-8">
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
                        <div id="promoter" class="row">
                            <div class="col-lg-12">
                                <h5 style="padding-top:50px; padding-bottom: 30px;"> Promoter - Venda de ingressos</h5>
                            </div>
                            <div class="col-lg-3">
                                <h6>1 - Faça Login no App</h6>
                                <img src="img/login.jpeg" style="width:100%" alt="Imagem App Ingressozapp" srcset="">
                                <p class="text-justify">  
                                    Caso, ainda não tenha feito login, <a href="">Clique aqui </a>para fazer login no aplicativo usando seu e-mail e senha passados pelo produtor de eventos que te cadastrou como promoter.
                                </p>
                            </div>
                            <div class="col-lg-3">
                                <h6>2 - Menu/Emitir Ingresso</h6>
                                <img src="img/menu.jpeg" style="width:100%" alt="Imagem App Ingressozapp" srcset="">
                                <p class="text-justify">  
                                    Clique no ícone "<i class="fas fa-bars"></i>" para abrir o menu lateral, em seguida clique em "Emitir Ingresso" para acessar a página de emissão de ingressos.
                                </p>
                            </div>
                            <div class="col-lg-3">                                    
                                <h6>3 - Gerar Ingresso</h6>
                                <img src="img/emissao.jpeg" style="width:100%" alt="Imagem App Ingressozapp" srcset="">
                                <p class="text-justify">  
                                    Selecione o evento, em seguida o lote que o cliente vai comprar, preencha com o nome e telefone do cliente e clique em "Emitir Ingresso" para que o ingresso seja gerado.
                                </p>
                            </div>
                            <div class="col-lg-3">
                                <h6>4 - Enviar no Whatsapp</h6>
                                <img src="img/ingresso.jpeg" style="width:100%" alt="Imagem App Ingressozapp" srcset="">
                                <p class="text-justify">  
                                    Você será encaminhado para o aplicativo "Whatsapp", clique no botão "<i class="fas fa-paper-plane"></i>" para enviar o ingresso diretamente para o cliente em seu Whatsapp.
                                </p>
                            </div>
                        </div>

                        <div id="barIntro" class="row">
                            <div class="col-lg-12">
                                <h5 style="padding-top:50px; padding-bottom: 30px;">Bar - Introdução</h5>
                            </div>
                            <div class="col-lg-12">
                                <p class="text-justify"> 
                                    <span style="margin: 50px;">
                                    Otimize seu bar e trabalhe com mais rapidez e segurança utilizando nosso sistema de caixa e retirada de produtos no bar. O IngressoZapp pensando na comodidade e praticidade da experiência não só dos produtores, assim como dos clientes, desenvolveu uma maneira eficiente de compra e venda de produtos no bar de eventos.<br>
                                    <span style="margin: 50px;">
                                    O público recarrega seu QR CODE (cartão ou ingresso virtual) no caixa. A partir daí o valor fica creditado no código e poderá ser usado livremente no bar. Basta solicitar o produto desejado ao funcionário do bar, que utiliza um celular para ler o QR CODE e debitar o valor do produto solicitado.<Br>
                                </p>
                            </div>
                        </div>

                        <div id="caixa" class="row">
                            <div class="col-lg-12">
                                <h5 style="padding-top:50px; padding-bottom: 30px;">Caixa - Carregando Saldo</h5>
                            </div>
                            <div class="col-lg-4">
                                <img src="img/caixa.jpeg" style="width:100%" alt="Imagem App Ingressozapp" srcset="">
                            </div>
                            <div class="col-lg-8">
                                <p class="text-justify"> 
                                    <span style="margin: 50px;">
                                    Para Carregar saldo nos QR Codes do bar do evento, o produtor utiliza um aplicativo a parte, o Caixa IngressoZapp<br>
                                    <br>
                                    <span style="margin: 50px;">
                                    Antes de usar o Aplicativo de Caixa IngressoZapp o produtor de eventos deve acessar o aplicativo, fazer login, com seu e-mail e senha oficiais e entregá-lo ao caixa responsável. <br>
                                    <br>
                                    Para carregar o saldo no cartão QR CODE físico ou no próprio ingresso siga as instruções:<br>
                                    1- O cliente comparece ao caixa e solicita o crédito no valor desejado (caso o cliente ainda não possua o QR CODE, recebe um novo cartão)<br>
                                    2- O funcionário do Caixa utilizando o aplicativo  Caixa IngressoZapp, clica no ícone  de câmera 📷 e focaliza o QR CODE do cliente. <br>
                                    3- Em tela será exibido o saldo do disponível em cartão. O cliente é informado então quanto já possuía de saldo. <br>
                                    4- O responsável pelo caixa recebe o valor que o cliente deseja adicionar (dinheiro, cartão, PIX, disponibilizados pelo produtor de eventos)<br>
                                   
                                    5- Selecionando o valor pago pelo cliente adiciona-se o saldo no cartão e informa-se o saldo total do cliente em cartão.<br>
                                </p>
                            </div>
                        </div>


                        <div id="bar" class="row">
                            <div class="col-lg-12">
                                <h5 style="padding-top:50px; padding-bottom: 30px;">Bar - Entrega dos Produtos</h5>
                            </div>
                            <div class="col-lg-4">
                                <img src="img/bar.jpeg" style="width:100%" alt="Imagem App Ingressozapp" srcset="">
                            </div>
                            <div class="col-lg-8">
                                <p class="text-justify">  
                                    <span style="margin: 50px;">
                                    Para fazer a venda, descontando o saldo dos QR Codes, o produtor utiliza um aplicativo a parte, o Bar IngressoZapp<br>
                                    <br>
                                    <span style="margin: 50px;">
                                    Antes de usar o Aplicativo de Bar IngressoZapp o produtor de eventos deve acessar o aplicativo, fazer login, com seu e-mail e senha oficiais e entregá-lo aos responsávei pelas entregas dos produtos no bar. <br>
                                    <br>
                                    Para debitar executar a venda dos produtos no bar siga as instruções:<br>
                                    1- O cliente comparece no bar e solicita o produto desejado<br>
                                    2- O funcionário do Bar utilizando o aplicativo Bar IngressoZapp, clica no ícone  de câmera 📷 e focaliza o QR CODE do cliente. <br>
                                    3- Em tela serão exibida uma página com todos os produtos cadastrados para venda, com imagem e preço. <br>
                                    4- No topo da tela de produtos é informado o saldo do cliente em R$. Ess saldo é informado ao cliente<br>
                                    5- O responsável clica no produto escolhido pelo cliente.<br>
                                    6- Caso o cliente possua saldo suficiente,esse saldo é debitado, a tela fica verde e o saldo restante é mostrado em tela. Caso não possua, a tela fica vermelha e o saldo restante é mostrado em tela.<br>
                                    7- O saldo restante é informado ao cliente.<br>
                                    8- O cliente recebe o produto solicitado.<br>
                                </p>
                            </div>
                        </div>

                        <div id="portaria" class="row">
                            <div class="col-lg-12">
                                <h5 style="padding-top:50px; padding-bottom: 30px;">Portaria - Conferência de Ingressos</h5>
                            </div>
                            <div class="col-lg-4">
                                <img src="img/portaria.jpeg" style="width:100%" alt="Imagem App Ingressozapp" srcset="">
                            </div>
                            <div class="col-lg-8">
                                <p class="text-justify">  
                                    <span style="margin: 50px;">
                                    Para controle de entrada no evento, o produtor utiliza um aplicativo a parte, o Portaria IngressoZapp<br>
                                    <span style="margin: 50px;">
                                    Antes de usar o Aplicativo de Portaria IngressoZapp o produtor de eventos deve acessar o aplicativo, fazer login, com seu e-mail e senha oficiais e entregá-lo aos responsáveis pela portaria.<br>

                                    Para fazer o controle da portaria, siga as instruções:<br>
                                    1- O cliente apresenta o ingresso recebido no Whatsapp <br>
                                    2- O funcionário da portaria utilizando o aplicativo Portaria IngressoZapp, clica no ícone de câmera 📷 e focaliza o QR CODE do cliente. <br>
                                    3.1- Caso o ingresso esteja válido, uma confirmação na cor verde aparecerá na tela com as informações do ingresso. <br>
                                    3.2- Caso  o ingresso esteja usado, uma confirmação na cor azul aparecerá na tela com as informações do ingresso. <br>
                                    3.2- Caso  o ingresso esteja inválido, uma confirmação na cor vermelha aparecerá na tela. <br>
                                    4- A entrada no evento só será permitida para os Ingressos considerados válidos. O ingresso será automaticamente considerado como usado na plataforma após a entrada do cliente, impedindo fraude e tentativas de mais entradas usando o mesmo QR CODE.<br>
                                    <br>
                                    Obs: Caso o cliente esteja sem internet, apenas com a mensagem do Whatsapp, utilize o código de  6 dígitos (Ex: 426122) apara verificar a validade do ingresso. Inserindo o código no campo “Código do Ingresso” e clicando em “Buscar Ingresso”<br>

                                </p>
                            </div>
                        </div>
                        <div id="produtor" class="row">
                            <div class="col-lg-12">
                                <h5 style="padding-top:50px; padding-bottom: 30px;">Produtor - Gerenicie seu evento</h5>
                            </div>
                            <div class="col-lg-4">
                                <img src="img/ingressozapp.png" style="width:100%" alt="Imagem App Ingressozapp" srcset="">
                            </div>
                            <div class="col-lg-8">
                                <p class="text-justify font-weight-light">  
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
<?php
include('./includes/footer.php');
?>