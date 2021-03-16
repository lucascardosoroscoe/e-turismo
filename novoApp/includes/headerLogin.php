<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Painel de Controle IngressoZapp" />
    <meta name="author" content="Lucas Cardoso Roscoe" />
    <title>IngressoZapp</title>
    <link href="<?php echo $HTTP_HOST;?>/css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
  </head>
  <body class="sb-nav-fixed">
    <?php
      include('bancoDados.php');
      session_start();
      /*session created*/
      $_SESSION["idUsuario"] = '';
      $_SESSION["usuario"] = '';
      $_SESSION["tipoUsuario"] = '';
      
    ?>
    <nav class="sb-topnav navbar navbar-expand " style="background-color: #fff;">
          <a class="navbar-brand" href="<?php echo $HTTP_HOST;?>/index.php"><img src="<?php echo $HTTP_HOST;?>/img/logo.png" alt="Soluções2c" srcset="" style="height:40px;"></a>
        <!-- Botão do Menu -->
          <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
    </nav>
    <div id="layoutSidenav_content">
        <main>