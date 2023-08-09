<?php
//Ocultando os erros de PHP, para exibí-los troque Zero por Hum.
// ini_set('display_errors',0);
//Mude o timezone de acordo com sua região. Por padrão está setado para reconhecer horário de verão,
//se você está no nordeste onde o horário de verão não se aplica use o seguinte timezone: America/Fortaleza
date_default_timezone_set("America/Sao_Paulo");
//Definindo o idioma da aplicação
setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );
//E-mail usado na sua conta do pagseguro
$pagseguro_email = "lucascardosoroscoe@gmail.com";
//Token gerado pelo Pagseguro (PARA USAR EM MODO PRODUÇÃO GERE UM TOKEN NO PAINEL PAGSEGURO).
$pagseguro_token = "135032530FC640C3A6592D2717334E69";
//Para usar o checkout em modo produção deixe essa variável em branco, para usar em modo teste mantenha o valor ".sandbox".
//$sandbox = ".sandbox";
$sandbox = ".sandbox";
//Essa URL será acionada sempre que uma transação ocorrer
$pagseguro_url = "https://".$sandbox.".pagseguro.uol.com.br/v2/transactions";
//Essa URL carrega a api javaScript do PagSeguro
$pagseguro_url_js = "https://stc".$sandbox.".pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js";
//Essa URL será acionada quando o status de uma transação for modificado para Pago ou outro status. Mude essa URL de acordo com o endereço do seu site e de onde está a aplicação.
$pagseguro_retorno = "https://ingressozapp.com/pagamentos/retorno.php";
?>
