<?php
    include('produtor/includes/db_valores.php');
    $produtor  =  $_GET["produtor"];
    $nome = $_GET["nome"];
    $conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);

    $consulta = "SELECT * FROM Evento WHERE produtor='$produtor' AND nome = '$nome'";
    $gravacoes = mysqli_query($conexao, $consulta);

    $row = mysqli_fetch_assoc($gravacoes);

    Header( "Content-type: image/gif"); 
    echo $row['imagem']; 
?>