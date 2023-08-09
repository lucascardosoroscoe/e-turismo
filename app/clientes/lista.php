<?php
include('../includes/verificarAcesso.php');
verificarAcesso(2);



$id = $_POST['inputId'];
$nome = $_POST['inputName'];
$telefone = $_POST['inputTelefone'];
$consulta = "SELECT Cliente.id, Cliente.nome, Cliente.telefone FROM Cliente 
JOIN Ingresso ON Ingresso.idCliente = Cliente.id
JOIN Evento ON Ingresso.evento = Evento.id 
WHERE Evento.produtor = $idUsuario GROUP BY Cliente.telefone
";
if($tipoUsuario ==1){
    $consulta = "SELECT Cliente.id, Cliente.nome, Cliente.telefone
    FROM Cliente
    JOIN Ingresso ON Ingresso.idCliente = Cliente.id
    WHERE Ingresso.evento = '$idEvento' GROUP BY Cliente.telefone
";
}
$dados = selecionar($consulta);
foreach ($dados as $cliente) {
    echo strtok($cliente['nome'], " ").','.$cliente['telefone'].'<br>';
}
// header('Location: index.php?msg='.$msg);
?>