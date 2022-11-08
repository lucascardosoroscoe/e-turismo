<?php
include('../../includes/verificarAcesso.php');
verificarAcesso(2);
include('../../includes/header.php');
try {
    $msg = $_GET['msg'];
    $id = $_GET['id'];
} catch (\Throwable $th) {
    throw $th;
}
function getRetirada(){
    global $id, $valorRetirada, $dataRetirada, $chavePIX, $tipoPIX, $nomePIX;
    $consulta = "SELECT * FROM Retiradas WHERE Retiradas.id = '$id'";
    $dados = selecionar($consulta);
    $retirada = $dados[0];
    $valorRetirada = $retirada['valor'];
    $dataRetirada = $retirada['createdAt'];
    $chavePIX = $retirada['chavePIX'];
    $tipoPIX = $retirada['tipoPIX'];
    $nomePIX = $retirada['nome'];
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
    WHERE Retiradas.idEvento = '$idEvento' AND Retiradas.status = '2'";
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
                            <h3 class="text-center font-weight-light my-4">Concluir Retirada
                                <?php 
                                    getRetirada();
                                    if($msg != ""){echo "<br>".$msg;}
                                ?>
                            </h3>
                        </div>
                        <div class="card-body">
                            <form action="execut.php" id="create" method="POST" enctype="multipart/form-data">
                                <h6 class="font-weight-light">Evento: <?php echo $nomeEvento; ?></h6>
                                <h6 class="font-weight-light">Total de Vendas Online: R$<?php echo number_format($vendas, 2, ',', '.'); ?></h6>
                                <h6 class="font-weight-light">Retiradas Anteriores: R$<?php echo number_format($retiradas, 2, ',', '.'); ?></h6>
                                <h6 class="font-weight-light">Taxas (a princípio): R$<?php echo number_format($taxas, 2, ',', '.'); ?> ( Venda Promoter: R$150,00/evento)</h6>
                                <h6 class="font-weight-light">Valor Disponível (a princípio): R$<?php echo number_format($valor, 2, ',', '.'); ?></h6>
                                <h6 class="font-weight-light">Solicitação: <?php echo $tipoPIX.": ".$chavePIX." (".$nomePIX.")" ?></h6>
                                <h6 class="font-weight-light">Valor: R$<?php echo number_format($valorRetirada, 2, ',', '.'); ?></h6>
                                <h6 class="font-weight-light">Data de Solicitação: <?php echo date('d/m/Y', strtotime('-3 hours')); ?></h6>
                                <div class="form-row">
                                    <input id="id"  name="id" type="hidden" value="<?php echo $id;?>" required/>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputValor">Valor Executado*</label>
                                            <div class="input-group mb-1">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">R$</span>
                                                </div>
                                                <input class="form-control py-4" id="inputValor"  name="inputValor" type="number" min="0" max="<?php echo $valorRetirada + 150;?>" value="<?php echo $valorRetirada;?>" placeholder="Valor da Retirada" step="1" required/>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">,00</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="small mb-1" for="comprovante">Comprovante</label>
                                            <div class="input-group mb-1">
                                                <input class="form-control" id="comprovante"  name="comprovante" type="file" style="height:48px;"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="small mb-1" for="observacao">Observação (Em caso de desconto ou Taxa extra descrever aqui)*</label>
                                            <textarea class="form-control py-4" id="observacao"  name="observacao" type="text" rows="3" placeholder="" required></textarea>
                                        </div>
                                    </div>
                                </div>
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