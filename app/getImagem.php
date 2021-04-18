<?php
    include('includes/verificarAcesso.php');
    $codigo  =  $_GET["codigo"];

    $consulta = "SELECT imagem FROM Evento WHERE id = $id";
    $imagem = selecionar($consulta);
    
    Header( "Content-type: image/gif"); 
    echo $imagem[0]['imagem'];
?>