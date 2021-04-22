<?php
include_once '../includes/header.php';
session_start();
/*session created*/
$produtor  =  $_SESSION["usuario"];
$validade =  $_SESSION["validade"];

if ($validade == "VALIDO"){
     include('../includes/db_valores.php');

     $conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
          


     $user  = $_GET['usuario'];
     $produtor   = $_GET['produtor'];
     $nome  = $_GET['nome'];
     $telefone   = $_GET['telefone'];
     $email  = $_GET['email'];

     $consulta = "SELECT * FROM Vendedor WHERE email='$email'";
     $gravacoes = mysqli_query($conexao, $consulta);
     $dados = array();
     while($linha = mysqli_fetch_assoc($gravacoes)){
         $dados[] = $linha; 
     }
     $act= $dados[0];
     $pass = $act['senha'];
     $prod = $act['produtor'];
     if (empty ($dados)){
          $consulta = "insert into Vendedor (usuario, produtor, nome, telefone, email ) values ('$user','$produtor','$nome','$telefone','$email')";
     }else{
          if ($prod == $produtor){
               $msg = "E-mail do vendedor já cadastrado";
               header('Location: vendedor.php?msg='.$msg);
          }else{
          $consulta = "insert into Vendedor (usuario, produtor, nome, telefone, email, senha ) values ('$user','$produtor','$nome','$telefone','$email', '$pass')";
          }     
     }

     mysqli_close($conexao);

     $conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
     if(mysqli_query($conexao, $consulta))
     {
          $linha = "%0A";
          $link = "https://api.whatsapp.com/send?phone=55";
          $mensagem = "Olá%20$nome,%20tudo%20bem?%20%0AVocê%20acaba%20de%20ser%20cadastrado%20no%20aplicativo%20IngressoZapp%20como%20promoter%20oficial%20$produtor.%0APor%20meio%20do%20aplicativo%20você%20poderá%20enviar%20os%20ingressos%20do%20evento%20direto%20no%20whatsapp%20do%20cliente.%0AClique%20no%20link%20e%20baixe%20o%20aplicativo:%0Ahttps://play.google.com/store/apps/details?id=ingressozapp.com.promoteringressozapp%0ALogin:%20$user%0ASenha:%20ingressozapp%0A%0AEssa%20é%20uma%20senha%20padrão,%20em%20seu%20primeiro%20acesso%20você%20vai%20precisar%20modifica-la,%20basta%20colocar%20uma%20nova%20senha%20única%20e%20que%20só%20você%20terá%20acesso.%0A%0APara%20emitir%20um%20ingresso,%20siga%20as%20instruções%20do%20vídeo:%0Ahttps://www.instagram.com/p/B_qUDaFHzBi/?igshid=1l1wbx754c5ia";
          $link = $link . $telefone . "&text=" . $mensagem;

          echo "<div class='row'><div class='col s12 m6 push-m3'>";
          echo "<br><br><a href='". $link ."' target='_blank' class='btn'>Enviar aviso no Whatsapp</a><br><br>";
          echo "<a href='../visualizar/vendedor.php' target='_blank' class='btn'>Voltar</a>";
          echo "</div></div>";
     }
     else
     {
          $msg = "Não é possível cadastrar um usuario que já existe";
          header('Location: vendedor.php?msg='.$msg);
     }

     mysqli_close($conexao);
}else {
     header('Location: https://ingressozapp.com/produtor/login/');
}
include_once '../includes/footer.php';
?>