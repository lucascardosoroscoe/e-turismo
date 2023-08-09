<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Checkout example · Bootstrap v5.1</title>

    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="form-validation.css" rel="stylesheet">
  </head>
  <body class="bg-light">
    
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
    $value = intval('2500');
    $name = "Tiago Cardoso Roscoe";
    $cpf = "10402739639";
    $phone_number = "67999654445";
    
    $item_1 = [
        'name' => $itemName, // nome do item, produto ou serviço
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
      <img class="d-block mx-auto mb-4" src="../assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
    </div>

    <div class="row g-5">
      <div class="col-md-5 col-lg-4 order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-primary">Seu Carrinho</span>
          <span class="badge bg-primary rounded-pill"><? echo $amount;?></span>
        </h4>
        <!-- Conteúdo do carrinho -->
        <ul class="list-group mb-3">
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0"><? echo $itemName;?></h6>
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
      </div>
      <div class="col-md-7 col-lg-8">
          <h4 class="mb-3">Método de Pagamento</h4>

          <div class="my-3">
            <div class="form-check">
              <input id="pix" name="paymentMethod" type="radio" class="form-check-input" checked onclick="abrirPix()" required>
              <label class="form-check-label" for="pix">PIX</label>
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

          <div class="row gy-3" id="menu_pix">
            <?php
                $aux = '../app/qr_img0.50j/php/qr_img.php?';
                $aux .= 'd='.$qrcode.'&';
                $aux .= 'e=H&';
                $aux .= 's=4&';
                $aux .= 't=P';
                echo ('<img style="margin-left: 25%;width:auto;" src="'.$aux.'" alt="" width="50%">');
            ?>
            <div class="col-md-12">

                <label for="cc-name" class="form-label">PIX COPIA E COLA</label>
                <form class="card p-2">
                    <div class="input-group">
                        <input type="text" class="form-control" id="pix-copia" value="<? echo $qrcode;?>" >
                        <button class="btn btn-secondary" id="botaoCopy">Copiar</button>
                    </div>
                </form>
            </div>
          </div>
          <div class="row gy-3" id="menu_cartao" style="display:none;">
            <div class="col-md-6">
              <label for="cc-name" class="form-label">Nome no cartão</label>
              <input type="text" class="form-control" id="cc-name" placeholder="" required>
              <small class="text-muted">Nome Completo Exibido no cartão</small>
              <div class="invalid-feedback">
                Nome no cartão é obrigatório
              </div>
            </div>

            <div class="col-md-6">
              <label for="cc-number" class="form-label">Número do cartão</label>
              <input type="text" class="form-control" id="cc-number" placeholder="" required>
              <div class="invalid-feedback">
                Número do cartão é obrigatório
              </div>
            </div>

            <div class="col-md-4">
              <label for="cc-mes" class="form-label">Mes de Validade</label>
              <input type="text" class="form-control" id="cc-mes" placeholder="" required>
              <div class="invalid-feedback">
                Mês de Validade é Obrigatória
              </div>
            </div>
            <div class="col-md-4">
              <label for="cc-ano" class="form-label">Ano de Validade</label>
              <input type="text" class="form-control" id="cc-ano" placeholder="" required>
              <div class="invalid-feedback">
                Ano de Validade é Obrigatória
              </div>
            </div>

            <div class="col-md-4">
              <label for="cc-cvv" class="form-label">CVV</label>
              <input type="text" class="form-control" id="cc-cvv" placeholder="" required>
              <div class="invalid-feedback">
                Código de Segurança Obrigatório
              </div>
            </div>
            <div class="col-md-4">
              <label for="cc-cep" class="form-label">CEP</label>
              <input type="text" class="form-control" id="cc-cep" placeholder="" required>
              <small class="text-muted">CEP (fatura do cartão)</small>
              <div class="invalid-feedback">
                Campo de CEP é obrigatório
              </div>
            </div>

            <div class="col-md-8">
              <label for="cc-endereco" class="form-label">Endereço</label>
              <input type="text" class="form-control" id="cc-endereco" placeholder="" required>
              <div class="invalid-feedback">
                Endereço é obrigatório
              </div>
            </div>

            <div class="col-md-4">
              <label for="cc-numero" class="form-label">Número do Endereço</label>
              <input type="text" class="form-control" id="cc-numero" placeholder="" required>
              <div class="invalid-feedback">
                Número é Obrigatório
              </div>
            </div>
            <div class="col-md-4">
              <label for="cc-cidade" class="form-label">Cidade</label>
              <input type="text" class="form-control" id="cc-cidade" placeholder="" required>
              <div class="invalid-feedback">
                Cidade é Obrigatória
              </div>
            </div>

            <div class="col-md-4">
              <label for="cc-estado" class="form-label">Estado (Ex: MS)</label>
              <input type="text" class="form-control" id="cc-estado" placeholder="" required>
              <div class="invalid-feedback">
                Estado é Obrigatório
              </div>
            </div>
            <button class="btn btn-primary" id="botaoCartao">Concluir Compra</button>
          </div>
          <div class="row gy-3" id="menu_boleto" style="display:none;">
            <a href="<?php echo $link;?>" class="btn btn-primary">Acessar Boleto</a>
          </div>
      </div>
    </div>
  </main>

        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">&copy; 2022 IngressoZapp</p>
            <ul class="list-inline">
            <li class="list-inline-item"><a href="#">Política de Privacidade</a></li>
            <li class="list-inline-item"><a href="#">Termos e Condições</a></li>
            <li class="list-inline-item"><a href="https://api.whatsapp.com/send?phone=5567993481631&text=Ol%C3%A1!%20Estou%20com%20dificuldade%20para%20comprar%20um%20ingresso">Suporte</a></li>
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

            let botaoCartao = document.getElementById('botaoCartao');
            botaoCartao.addEventListener("click", function(event){
                event.preventDefault();
                concluirCartao();
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
            function concluirCartao(){
                var s=document.createElement('script');
                s.type='text/javascript';
                var v=parseInt(Math.random()*1000000);
                s.src='https://api.gerencianet.com.br/v1/cdn/79425d53d0cf005e1b1800359141be7f/'+v;
                s.async=false;
                s.id='79425d53d0cf005e1b1800359141be7f';
                if(!document.getElementById('79425d53d0cf005e1b1800359141be7f')){
                    document.getElementsByTagName('head')[0].appendChild(s);
                };
                $gn={validForm:true,processed:false,done:{},ready:function(fn){$gn.done=fn;}};

                $gn.ready(function (checkout) {

                    $brand = 'visa';
                    number = document.getElementById('cc-number').value;
                    cvv = document.getElementById('cc-cvv').value;
                    expiration_month = document.getElementById('cc-mes').value;
                    expiration_year = document.getElementById('cc-ano').value;

                    checkout.getPaymentToken(
                    {
                        brand: 'visa', // bandeira do cartão
                        number: number, // número do cartão
                        cvv: cvv, // código de segurança
                        expiration_month: expiration_month, // mês de vencimento
                        expiration_year: expiration_year // ano de vencimento
                    },

                    // brand: 'visa', // bandeira do cartão
                    //     number: '4012001038443335', // número do cartão
                    //     cvv: '123', // código de segurança
                    //     expiration_month: '05', // mês de vencimento
                    //     expiration_year: '2021' // ano de vencimento

                    function (error, response) {
                        if (error) {
                        // Trata o erro ocorrido
                        console.error(error);
                        } else {
                        // Trata a resposta
                            payment_token = response.data.payment_token
                            console.log(response.data.payment_token);
                        }
                    }
                    );

                });
            }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>    <script src="form-validation.js"></script>
  </body>
</html>