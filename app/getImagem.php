<?php
    include('includes/bancoDados.php');
    $id  =  $_GET["id"];

    $consulta = "SELECT imagem FROM Evento WHERE id = $id";
    $imagem = selecionar($consulta);
    
    Header( "Content-type: image/gif"); 
    echo $imagem[0]['imagem'];
?>