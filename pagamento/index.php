<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Checkout - ingressoZapp</title>

    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  </head>
  <body class="bg-dark">
    
    <?php
    
    require './vendor/autoload.php';
    require 'config.php';
    
    use Gerencianet\Exception\GerencianetException;
    use Gerencianet\Gerencianet;
    
    // $itemName = $_GET['item'];
    // $amount = intval($_GET['amount']);
    // $value = intval($_GET['value']);
    // $name = $_GET['name'];
    // $cpf = $_GET['cpf'];
    // $phone_number = $_GET['phone_number'];

    $itemName = "Ingresso Vintage Backstage";
    $amount = intval('2');
    $value = intval('25000');
    $name = "Tiago Cardoso Roscoe";
    $cpf = "10402739639";
    $phone_number = "67999654445";
    
    $item_1 = [
        'name' => $amount . ' - ' .$itemName, // nome do item, produto ou serviço
        'amount' => $amount, // quantidade
        'value' => $value // valor (1000 = R$ 10,00) (Obs: É possível a criação de itens com valores negativos. Porém, o valor total da fatura deve ser superior ao valor mínimo para geração de transações.)
    ];
    
    $item_2 = [
        'name' => 'Taxa de Comodidade', // nome do item, produto ou serviço
        'amount' => $amount, // quantidade
        'value' => $value * 0.1 // valor (2000 = R$ 20,00)
    ];
    
    $items =  [
        $item_1,
        $item_2
    ];
    
    $metadata = array('notification_url'=>'https://ingressozapp.com/retorno'); //Url de notificações onde vamos notificá-lo, independente se for pago pelo código de barras do boleto quanto pelo QR Code.
   
    $customer = [
       'name' => $name, // nome do cliente
       'cpf' => $cpf, // cpf válido do cliente
       'phone_number' => $phone_number, // telefone do cliente
    ];
    $configurations = [ // configurações de juros e mora
        'fine' => 200, // porcentagem de multa
        'interest' => 33 // porcentagem de juros
    ];
    $bankingBillet = [
        'expire_at' => date('Y-m-d', strtotime('tomorrow')) , // data de vencimento do titulo
        'message' => 'Pague pelo código de barras ou via PIX pelo QR Code', // mensagem a ser exibida no boleto
        'customer' => $customer,
    ];
    $payment = [
        'banking_billet' => $bankingBillet // forma de pagamento (banking_billet = Bolix)
    ];
    $body = [
        'items' => $items,
        'metadata' =>$metadata,
        'payment' => $payment
    ];
    try {
        $api = new Gerencianet($options);
        $pay_charge = $api->oneStep([],$body);
        // echo json_encode($pay_charge);
        $pix = $pay_charge['data']['pix'];
        $qrcode = $pix['qrcode'];
        $charge_id = $pix['charge_id'];
        $qrcode_image = $pix['qrcode_image'];
        $link = $pay_charge['data']['link'];
    } catch (GerencianetException $e) {
        print_r($e->code);
        print_r($e->error);
        print_r($e->errorDescription);
    } catch (Exception $e) {
        print_r($e->getMessage());
    }

    function converterReal($value){
        $reais = substr($value, 0, -2);
        $centavos = substr($value, strlen($value)-2);
        $final = $reais . ',' . $centavos;
        return $final;
    }
    ?>
<div class="container">
  <main>
    <div class="py-5 text-center">
      <img class="d-block mx-auto mb-4" src="../app/img/logo.png" alt="" height="100">
    </div>

    <div class="row g-5">
      <div class="col-md-5 mt-3 order-md-last">
        
        <!-- Conteúdo do carrinho -->
        <ul class="list-group mb-3">
          <li class="list-group-item lh-sm">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
              <span class="text-primary">Seu Carrinho</span>
              <span class="badge bg-primary rounded-pill"><? echo $amount;?></span>
            </h4>
          </li>
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0"><? echo $amount . ' x ' .$itemName;?></h6>
              <small class="text-muted">Ingressos</small>
            </div>
            <span class="text-muted">R$<? echo converterReal($value * $amount);?></span>
          </li>
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0">Taxa de Conveniência</h6>
              <small class="text-muted">10% sobre o valor dos ingressos</small>
            </div>
            <span class="text-muted">R$<?php echo converterReal($value * $amount * 0.1);?></span>
          </li>
          <li class="list-group-item d-flex justify-content-between">
            <span>Total</span>
            <strong>R$<?php echo converterReal($value * $amount * 1.1);?></strong>
          </li>
        </ul>
        <!-- Cupon de desconto - DESATIVADO -->
        <form class="card p-2" action="#">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Código Promocional">
            <button class="btn btn-secondary" id="botaoCupom">Cupom</button>
          </div>
        </form>
        <!-- Conteúdo do carrinho -->
        <ul class="list-group mb-3 mt-3">
          <li class="list-group-item lh-sm">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
              <span class="text-primary">Dados do Comprador</span>
              <span class="badge bg-primary rounded-pill">I</span>
            </h4>
          </li>
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0"><? echo $name;?></h6>
              <small class="text-muted"><? echo $cpf;?></small>
            </div>
            <span class="text-muted"><? echo $phone_number;?></span>
          </li>
          <li class="list-group-item lh-sm">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
              <span class="text-primary">Dados do Recebedor</span>
              <span class="badge bg-primary rounded-pill">I</span>
            </h4>
          </li>
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0">LR Software Ltda.</h6>
              <small class="text-muted">37.524.891/0001-95</small>
            </div>
            <span class="text-muted">67 99348-1631</span>
          </li>
          <li class="list-group-item">
            <a class="btn btn-primary" style="width:100%" href="https://api.whatsapp.com/send?phone=5567993481631&text=Ol%C3%A1!%20Estou%20com%20dificuldade%20para%20comprar%20um%20ingresso">Dúvidas? Fale com o Suporte</a>
          </li>
        </ul>
      </div>
      
      <div class="col-md-7 mt-3">
        <div class="card ml-3 mr-3 bg-white rounded">
          <h4 class="card-header mb-3 text-center">Método de Pagamento</h4>
          <div class="card-body p-3">
            <div class="d-flex justify-content-between">
              <div class="form-check">
                <input id="pix" name="paymentMethod" type="radio" class="form-check-input" checked onclick="abrirPix()" required>
                <label class="form-check-label" for="pix"><b>PIX - SIMPLIFICADO</b></label>
              </div>
              <div class="form-check">
                <input id="credito" name="paymentMethod" type="radio" class="form-check-input" onclick="abrirCredito()" required>
                <label class="form-check-label" for="credito">Cartão de Crédito</label>
              </div>
              <div class="form-check">
                <input id="boleto" name="paymentMethod" type="radio" class="form-check-input" onclick="abrirBoleto()" required>
                <label class="form-check-label" for="boleto">Boleto</label>
              </div>
            </div>

            <div class="row gy-3 mt-3" id="menu_pix">
              <div class="w-100">
                <?php
                    $aux = '../app/qr_img0.50j/php/qr_img.php?';
                    $aux .= 'd='.$qrcode.'&';
                    $aux .= 'e=H&';
                    $aux .= 's=4&';
                    $aux .= 't=P';
                    echo ('<img style="margin-left: 25%;" src="'.$aux.'" alt="" width="50%">');
                ?>
              </div>
              <div class="col-md-12">

                  <label for="cc-name" class="form-label">PIX COPIA E COLA</label>
                  <form class="card p-2">
                      <div class="input-group">
                          <input type="text" class="form-control" id="pix-copia" value="<? echo $qrcode;?>" >
                          <button class="btn btn-primary" id="botaoCopy">Copiar</button>
                      </div>
                  </form>
              </div>
            </div>
            
            <form action="cartao.php" method="post">
              <div class="row gy-3 mt-3" id="menu_cartao" style="display:none;">
                <input type="hidden" name="itemName" value="<?php echo $itemName;?>">
                <input type="hidden" name="amount" value="<?php echo $amount;?>">
                <input type="hidden" name="value" value="<?php echo $value;?>">
                <input type="hidden" name="name" value="<?php echo $name;?>">
                <input type="hidden" name="phone_number" value="<?php echo $phone_number;?>">
                <div class="col-md-6">
                  <label for="cc-name" class="form-label">Nome no cartão</label>
                  <input type="text" class="form-control" id="cc-name" name="cc-name" placeholder="" value="<?php echo $name;?>" required>
                  <small class="text-muted">Nome Completo Exibido no cartão</small>
                </div>

                <div class="col-md-6">
                  <label for="cc-number" class="form-label">Número do cartão</label>
                  <input type="text" class="form-control" id="cc-number" name="cc-number" placeholder="" required>
                </div>

                <div class="col-md-4">
                  <label for="cc-mes" class="form-label">Mes de Validade</label>
                  <input type="text" class="form-control" id="cc-mes" name="cc-mes" placeholder="" required>
                </div>
                <div class="col-md-4">
                  <label for="cc-ano" class="form-label">Ano de Validade</label>
                  <input type="text" class="form-control" id="cc-ano" name="cc-ano" placeholder="" required>
                </div>

                <div class="col-md-4">
                  <label for="cc-cvv" class="form-label">CVV</label>
                  <input type="text" class="form-control" id="cc-cvv" name="cc-cvv" placeholder="" required>
                </div>
                <div class="col-md-4">
                  <label for="cc-cep" class="form-label">CEP</label>
                  <input type="text" class="form-control" id="cc-cep" name="cc-cep" placeholder="" required>
                  <small class="text-muted">CEP (fatura do cartão)</small>
                </div>

                <div class="col-md-8">
                  <label for="cc-endereco" class="form-label">Endereço</label>
                  <input type="text" class="form-control" id="cc-endereco" name="cc-endereco" placeholder="" required>
                  <small class="text-muted">Endereço (fatura do cartão)</small>
                </div>

                <div class="col-md-2">
                  <label for="cc-numero" class="form-label">Número</label>
                  <input type="text" class="form-control" id="cc-numero" name="cc-numero" placeholder="" required>
                </div>
                <div class="col-md-7">
                  <label for="cc-cidade" class="form-label">Cidade</label>
                  <input type="text" class="form-control" id="cc-cidade" nome="cc-cidade" placeholder="" required>
                </div>

                <div class="col-md-3">
                  <label for="cc-estado" class="form-label">Estado (Ex: MS)</label>
                  <input type="text" class="form-control" id="cc-estado" name="cc-estado" placeholder="" required>
                </div>
                <button class="btn btn-primary" id="botaoCartao" type="submit">Concluir Compra</button>
                </form>
              </div>
              <div class="row gy-3 mt-3" id="menu_boleto" style="display:none;">
                <a href="<?php echo $link;?>" class="btn btn-primary">Acessar Boleto</a>
              </div>
            </form>
        
          </div>
        </div>
      </div>
    </div>
  </main>
  <footer class="my-3 text-muted text-center text-small">
      <p class="mb-1">&copy; 2022 IngressoZapp</p>
      <ul class="list-inline">
      <li class="list-inline-item"><a href="#">Política de Privacidade</a></li>
      <li class="list-inline-item"><a href="#">Termos e Condições</a></li>
      </ul>
  </footer>
</div>
<script type='text/javascript'>
    let botaoCopy = document.getElementById('botaoCopy');
    botaoCopy.addEventListener("click", function(event){
        event.preventDefault();
        document.getElementById('pix-copia').select();
        document.execCommand('copy');
    });

    let botaoCupom = document.getElementById('botaoCupom');
    botaoCupom.addEventListener("click", function(event){
        event.preventDefault();
        alert("Cupom Inválido");
    });

    function abrirPix(){
        document.getElementById('menu_pix').style.display ='flex';
        fecharCredito();
        fecharBoleto();
    }
    function abrirCredito(){
        document.getElementById('menu_cartao').style.display ='flex';
        fecharPix();
        fecharBoleto();
    }
    function abrirBoleto(){
        document.getElementById('menu_boleto').style.display ='flex';
        fecharPix();
        fecharCredito();
    }
    function fecharPix(){
        document.getElementById('menu_pix').style.display ='none' ;
    }
    function fecharCredito(){
        document.getElementById('menu_cartao').style.display ='none' ;
    }
    function fecharBoleto(){
        document.getElementById('menu_boleto').style.display ='none' ;
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>    <script src="form-validation.js"></script>
</body>
</html>