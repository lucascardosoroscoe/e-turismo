<?php
include('../../includes/verificarAcesso.php');
verificarAcesso(2);
include('../../includes/header.php');
try {
    $msg = $_GET['msg'];
} catch (\Throwable $th) {
    throw $th;
}
function calcularValor(){
    global $vendas, $retiradas, $taxas;
    $vendas = getVendas();
    $retiradas = getRetiradas();
    $taxas = getTaxas();
    $valor = $vendas - $retiradas - $taxas;
    return $valor;
}
function getVendas(){
    global $idEvento;
    $consulta = "SELECT SUM(Ingresso.valor) as valor FROM Ingresso 
    WHERE Ingresso.evento = '$idEvento' AND Ingresso.validade != 'CANCELADO' AND Ingresso.vendedor = '1'";
    $dados = selecionar($consulta);
    $linkPrincipal = $dados[0]['valor'];
    $consulta = "SELECT SUM(Ingresso.valor) as valor FROM Ingresso
    WHERE Ingresso.evento = '$idEvento' AND Ingresso.validade != 'CANCELADO' AND Ingresso.vendedor != '1' AND Ingresso.origem = '2'";
    $dados = selecionar($consulta);
    $indicacoes = $dados[0]['valor'];
    return $linkPrincipal + $indicacoes;
}
function getRetiradas(){
    global $idEvento;
    $consulta = "SELECT SUM(Retiradas.valor) as valor FROM Retiradas 
    WHERE Retiradas.idEvento = '$idEvento' AND Retiradas.status != '3'";
    $dados = selecionar($consulta);
    return $dados[0]['valor'];
}
function getTaxas(){
    global $idEvento, $taxas;
    $consulta = "SELECT count(Ingresso.codigo) as quantidade FROM Ingresso 
    WHERE Ingresso.evento = '$idEvento' AND Ingresso.validade != 'CANCELADO' AND Ingresso.vendedor != '1' AND Ingresso.origem = '1'";
    $dados = selecionar($consulta);
    $quantidade = $dados[0]['quantidade'];
    if($quantidade >= 10){
        $taxas = $taxas + 150;
    }
    return $taxas;
}
$valor = calcularValor();
?>     
    <div style='background-image: url("../img/fundoLogin.jpg"); background-size: cover;height: 100%;'>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header">
                            <h3 class="text-center font-weight-light my-4">Solicitar Retirada
                                <?php if($msg != ""){echo "<br>".$msg;}?>
                            </h3>
                        </div>
                        <div class="card-body">
                            <form action="create.php" id="create" method="POST" enctype="multipart/form-data">
                                <h6 class="font-weight-light">Evento: <?php echo $nomeEvento; ?></h6>
                                <h6 class="font-weight-light">Total de Vendas Online: R$<?php echo number_format($vendas, 2, ',', '.'); ?></h6>
                                <h6 class="font-weight-light">Retiradas: R$<?php echo number_format($retiradas, 2, ',', '.'); ?></h6>
                                <h6 class="font-weight-light">Taxas: R$<?php echo number_format($taxas, 2, ',', '.'); ?> ( Venda Promoter: R$150,00/evento, tráfego pago pode ser cobrado após a solicitação de retirada )</h6>
                                <h6 class="font-weight-light">Valor Disponível: R$<?php echo number_format($valor, 2, ',', '.'); ?></h6>
                                <h6 class="font-weight-light">Data de Solicitação: <?php echo date('d/m/Y', strtotime('-3 hours')); ?></h6>
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputValor">Valor Solicitado*</label>
                                            <div class="input-group mb-1">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">R$</span>
                                                </div>
                                                <input class="form-control py-4" id="inputValor"  name="inputValor" type="number" min="0" max="<?php echo $valor;?>" value="<?php echo $valor;?>" placeholder="Valor da Retirada" step="1" required/>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">,00</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputNome">Nome/Razão Social*</label>
                                            <input class="form-control py-4" id="inputNome"  name="inputNome" type="text" placeholder="Nome Completo/Razão Social da Conta" value="<?php echo $usuario;?>" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputTipoPIX">Tipo PIX*</label>
                                            <select class="form-control" name="inputTipoPIX" id="inputTipoPIX" required>
                                                <option value="">Selecione o Tipo de Chave</option>
                                                <option value="Telefone">Telefone</option>
                                                <option value="E-mail">E-mail</option>
                                                <option value="CPF">CPF</option>
                                                <option value="CNPJ">CNPJ</option>
                                                <option value="Chave Aleatória">Chave Aleatória</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputPIX">Chave PIX*</label>
                                            <input class="form-control py-4" id="inputPIX"  name="inputPIX" type="text" placeholder="Sua Chave PIX" required/>
                                        </div>
                                    </div>
                                    
                                </div>
                                <h6 class="font-weight-light">Aviso*: O pagamento será feito um dia útil após a solicitação de retirada. Pedidos realizados na sexta-feira ou fim de semana serão executados no primeiro dia útil da outra semana até às 18:00. Em caso de Dúvidas <a href="https://api.whatsapp.com/send?phone=5567999854042&text=Ol%C3%A1%2C%20gostaria%20de%20tirar%20uma%20d%C3%BAvida%20sobre%20minha%20retirada%20de%20dinheiro%20das%20vendas%20online%20nana%20plataforma%3A%20*DIGITE%20SUA%20D%C3%9AVIDA%20ABAIXO*">Clique Aqui</a></h6>
                                <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" onclick="enviarForm()" >Solicitar Retirada</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
include('../../includes/footer.php');
?>