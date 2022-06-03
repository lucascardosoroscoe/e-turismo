<?php
    include('./includes/verificarAcesso.php');
 $consulta = "SELECT * FROM `Ingresso` WHERE `evento` = 341;";
 $dados = selecionar($consulta);
 $i = 0;
 foreach ($dados as $ingresso) {
     if($i == 23){
        $codigo = $ingresso['codigo'];
        $consulta = "UPDATE `Ingresso` SET `vendedor`='382' WHERE `codigo` = '$codigo';";
        $msg = executar($consulta);
        $i = 0;
     }else{
        $i = $i + 1 ; 
     }
 }
?>