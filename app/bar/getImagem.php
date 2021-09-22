<?php
    $servidor = '127.0.0.1:3306';
    $bsenha ='vjdC7p5XBy';
    $busuario ='u989688937_IHLyR';
    $bdados ='u989688937_WtNbV';

    $idImagem = $_GET['id'];

    $conexao = mysqli_connect($servidor, $busuario, $bsenha, $bdados);
    $consulta = "SELECT `imagem` FROM Imagem WHERE `idImagem`='$idImagem'";
    $gravacoes = mysqli_query($conexao, $consulta);

    $row = mysqli_fetch_assoc($gravacoes);
    Header( "Content-type: image/gif"); 
    echo $row['imagem']; 

?>