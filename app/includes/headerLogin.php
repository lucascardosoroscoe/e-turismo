<!DOCTYPE html>
  <html>
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <meta name="description" content="IngressoZapp" />
      <meta name="author" content="Lucas Cardoso Roscoe" />
      <title>IngressoZapp</title>
      <link rel="icon" type="imagem/png" href="<?php echo $HTTP_HOST . "/app";?>/img/logo.jpeg" />
      <link  rel="stylesheet" href="<?php echo $HTTP_HOST . "/app";?>/css/styles.css" />
      <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
      <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>

    <body>
<?php


setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

// if ($validade == "VALIDO"){}else{header('Location: ../../produtor/login/');}
?>
<body class="sb-nav-fixed">
    <!-- Barra Topo do Site -->
      <nav class="sb-topnav navbar navbar-expand bg-dark">
      <!-- navbar-dark bg-dark -->
        <!-- Título Site -->
        
          <a class="navbar-brand" href="<?php echo $HTTP_HOST . "/app";?>/index.php"><img src="<?php echo $HTTP_HOST . "/app";?>/img/logo.png" alt="Soluções2c" srcset="" style="height:40px;"></a>
        <!-- Botão do Menu -->
        <!-- Barra de Pesquisa -->
          <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <!-- <div class="input-group">
              <?php //selectEvento();?>
            </div> -->
          </form>
        <!-- Menu de Usuário -->
          <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">Configurações</a>
                <a class="dropdown-item" onclick="window.print()">Exportar PDF</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?php echo $HTTP_HOST . "/app";?>/login">Login</a>
              </div>
            </li>
          </ul>
      </nav>
    <!-- Menu Lateral Esquerda -->
      <div>
      <div>
      <main class="fh">
  
