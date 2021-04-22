<form id="dados" action="Dashboard.php" method="post">
<?php

include('../../produtor/includes/db_valores.php');
$codigo = $_GET['codigo'];
    header('Location: https://ingressozapp.com/portaria?codigo='.$codigo);
?>