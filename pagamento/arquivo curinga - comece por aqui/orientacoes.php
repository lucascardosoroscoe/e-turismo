

0-Para que o script funcione a vers�o do php no seu servidor de ser alterada para a versao 5.6 no m�nimo.  OK

1-voc� deve utilizar um formul�rio que far� a captura dos dados para que seja poss�vel enviar os dados para a cielo para que a compra seja efetivada.
  em anexo existem dois arquivos de exemplo:
  1.1- um que vai capturar os dados;
  1.2- outro que vai enviar os dados para cielo fazer a valida��o da compra.
  1.3- voc� deve obter seu key junto a cielo para que possa configurar seu arquivo de compra para que o pagamento seja direcionado para sua conta.
       para fazer o cadastro e obter estes dados acesse: https://cadastrosandbox.cieloecommerce.cielo.com.br/

2-voc� deve estar cadastrado. voc� deve ligar para 0800 570 8472 e ter em m�os o cpf ou cnpj do seu cliente.
  fale que voc� quer instalar a API 3.0 para webservice (API e-Commerce Cielo). diga que quer que a compra seja realizada no ambiente do seu site.
  eles v�o fazer um levantamento do faturamenteo para avaliar quais percentuais cobrar�o;
  eles v�o te enviar um formul�rio para que seja preenchido com os dados cliente;
  voc� deve responder e reenviar para eles;
  
3-voc� deve instalar no site onde deseja instalar o arquivo. ele teve ter certificado para que o endere�o do site seja da forma: "https://" e n�o "http://" se for este �ltimo eles n�o aprovar�o.
  a cielo exige que o site esteja em ambiente seguro. veja com seu provedor sobre esta instala��o.
  utilize o script abaixo:

RewriteEngine On


$stringLotes = carregarLotes();




RewriteCond %{HTTP_HOST} ^site.com.br$
RewriteRule ^(.*)$ "http\:\/\/www^site.com.br\.com.br\/$1" [R=301,L]
RewriteCond %{HTTPS} !=on
RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

voc� deve substituir "site" para no do endere�o que deseja instalar os arquivos. n�o altere mais nada.
com este arquivo se algu�m acessar o site utilizando "http://" automaticamente ele ser� redirecionado o mesmo endere�o utilizando "https://" que o modo de seguran�a exigido pela cielo.
este conte�do deve estar em um arquivo chamado: .htaccess

este arquivo deve estar no raiz do seu site. caso j� exista um arquivo no seu diret�rio raiz, renomeie-o antes de copiar o arquivo com esta configura��o.
observe a pasta: \arquivos secretos para configuracao

4-voc� dever� estar configurado para que a compra seja direcionada para o ambiente sandbox que � o ambiente de testes da cielo. no arquivo compra.php existe uma linha que voc� deve comentar ou n�o, fazendo o direcionamento para o ambiente de produ��o e sandbox, ambiente de testes;
  o seu arquivo deve estar�configurado para o ambiente de testes, sandbox.
  ap�s enviar o formul�rio, a cielo vai acessar seu site e vai fazer uma compra. voc� deve ter produtos com valores de um real.
  se tudo funcionar bem, eles autorizar�o o uso. caso ocorra algo, entre em contato comigo.
  ap�s a autoriza��o, voc� deve configurar para que as compras sejam direcinadas para o ambiente de produ��o.

5-para mais orienta��es acesse:
https://developercielo.github.io/manual/cielo-ecommerce

6-qual arquivo devo executar primeiro:
  6.1-Insira seu Key e ID nos arquivos para que as vendas sejam realizadas no seu ambiente de teste. 
      Refiro-me as var�veis:
      $MerchantID=""; //insira seu id informado pela cielo - leia \arquivo curinga - comece por aqui      
      $MerchantKey=""; //insira seu key informado pela cielo - leia \arquivo curinga - comece por aqui

       insira seu KEY e sey ID nos arquivos comprar.php, cancelamento.php, buscar-informacao-sobre-uma-determinada-venda.php, consultar-venda-comentado.php   
       para obt�-los voc� deve observer o item 1 deste arquivo.
	   
	   Aten��o:
	   para colocar em ambiente de produ��o, ou seja, para que as vendas sejam efetivamente registradas quando seu trabalho estiver pronto, voc� dever� inserir seu id e key de produ��o que a cielo vai informar e alterar a url que executa o comando para ambiente de produ��o.
	   voc� vai encontr�-las no endereco do item 5 deste arquivo. 
   
  6.2-Copiei todos os arquivos para uma pasta no seu provedor.
  6.3-Execute o formulario.php e registre sua primeira venda no ambiente de teste;
  
  Ap�s ter criado sua primeira venda voc� poder� utilizar os outros arquivos para fazer seus testes: 
  6.3.1-arquivo onde poder� consultar todas as vendas;
  6.3.2-arquivo onde poder� consultar uma �nica venda;
  6.3.3-arquivo para realizar cancelamentos;

