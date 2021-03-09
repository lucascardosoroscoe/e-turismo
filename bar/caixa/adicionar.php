<?php
include '../../includes/header.php';
$id = $_GET['id'];
$idFicha = $_GET['idFicha'];
$valor = $_GET['valor'];

    $consulta = "UPDATE `Fichas de Bar` SET `valor`=`valor` + $valor WHERE `idFicha` = '$idFicha'";
    $msg = executar($consulta);
    $nCaixa = $_SESSION["nCaixa"];
    $consulta = "INSERT INTO `Log Fichas`(`idFicha`, `nCaixa`, `valor`) VALUES ($idFicha , $nCaixa, '$valor')";
    $msg = executar($consulta);

    header('Location: https://ingressozapp.com/bar/caixa/index.php?id=' . $id);
?>
<style>