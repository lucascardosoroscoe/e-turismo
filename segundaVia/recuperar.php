<?php
include('../app/includes/verificarAcesso.php');
$email = $_POST['inputEmailAddress'];
$pedido = $_POST['pedido'];


$consulta = "SELECT * FROM Ingresso JOIN Cliente ON Cliente.id = Ingresso.idCliente WHERE Ingresso.pedido = '$pedido'";
$dados = selecionar($consulta);
$codigo  = $dados[0]['codigo'];
$emailPedido  = $dados[0]['email'];
if($emailPedido == $email){
    if($codigo == ""){
        header('Location: https://api.whatsapp.com/send?phone=5567993481631&text=Gostaria%20de%20Solicitar%20a%20segunda%20via%20do%20meu%20ingresso%2C%20j%C3%A1%20tentei%20pelo%20link%20mas%20n%C3%A3o%20consegui.E-mail%3A%20'.$email.'%20Pedido%3A%20'.$pedido);
    }else{
        header('Location: ../app/qr.php?codigo='.$codigo);
    }
}else if($emailPedido == ""){
    header('Location: https://api.whatsapp.com/send?phone=5567993481631&text=Gostaria%20de%20Solicitar%20a%20segunda%20via%20do%20meu%20ingresso%2C%20j%C3%A1%20tentei%20pelo%20link%20mas%20n%C3%A3o%20consegui.%20E-mail%3A%20'.$email.'%20Pedido%3A%20'.$pedido);
}else{
    $msg = "O e-mail informado não confere com o e-mail do pedido.";
    header('Location: https://ingressozapp.com/segundaVia/?msg='.$msg);

}


?>