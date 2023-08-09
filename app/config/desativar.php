<?php
    include('../includes/verificarAcesso.php');
    verificarAcesso(3);
    
    if($tipoUsuario == '2'){
        $consulta = "UPDATE `Produtor` SET `validade`='INVALIDO' WHERE `id` = '$idUsuario'";
    }else if($tipoUsuario == '3'){
        $consulta = "UPDATE `Vendedor` SET `validade`='INVALIDO' WHERE `id` = '$idUsuario'";
    }
    $msg = executar($consulta);

    $_SESSION["idUsuario"] = '';
    $_SESSION["usuario"] = '';
    $_SESSION["tipoUsuario"] = '';
    $_SESSION["emailUsuario"] = '';
    $_SESSION["idLote"] = "";
    $_SESSION["nCaixa"] = "";
    $_SESSION["msg"] = "";
    $msg = 'Conta desativada com sucesso';
    header('Location: ../index.php?msg='.$msg);
?>