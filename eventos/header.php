<?php
  include('../app/includes/verificarAcesso.php');
  $idProdutor = $_GET['produtor'];
  if($idProdutor != ""){
    $consulta = "SELECT * FROM `Produtor` WHERE `id` = '$idProdutor'";
    $dados = selecionar($consulta);
    $nome = $dados[0]['nome'];
    $consulta= "SELECT * FROM `Evento` WHERE `data` >= '2021/12/28' AND `validade` = 'VALIDO' AND `produtor` = '$idProdutor' ORDER BY `data`, `nome`";
  }else{
    $consulta= "SELECT * FROM `Evento` WHERE `data` >= '2021/12/28' AND `validade` = 'VALIDO' ORDER BY `data`, `nome`";
  }
  $dados = selecionar($consulta);
?>
<!DOCTYPE html>
  <html>
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <meta name="description" content="Eu já garanti meu ingresso, bora??? garanta o seu também." />
      <meta name="author" content="Lucas Cardoso Roscoe" />
      <meta property="og:description" content="Eu já garanti meu ingresso, bora??? Garanta o seu também."/>
      <meta property="og:title" content="IngressoZapp<?php echo ' - ' . $nome ?>"/>
      <meta property="og:image" content="<?php echo $HTTP_HOST . "/app"?>/img/logo.png"/>
      <meta name="twitter:url" content="http://ingressozapp.com/eventos/?produtor=<?php echo $idProdutor?>">
      <meta name="twitter:title" content="Eu já garanti meu ingresso, bora??? Garanta o seu também.">
      <meta name="twitter:image" content="<?php echo $HTTP_HOST . "/app"?>/img/logo.png">
      <title>IngressoZapp<?php echo ' - ' . $nome ?></title>
      <link  rel="stylesheet" href="<?php echo $HTTP_HOST . "/app";?>/css/styles.css" />
      <link rel="stylesheet"  href="<?php echo $HTTP_HOST . "/app";?>/css/table.css">
      <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
      <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>
      
<body class="sb-nav-fixed">
  <div id="fb-root"></div>
  <script async defer crossorigin="anonymous" src="https://connect.facebook.net/pt_PT/sdk.js#xfbml=1&version=v12.0&appId=350396228785481&autoLogAppEvents=1" nonce="FMKMNtpB"></script>

  <?php setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese'); ?>

    <!-- Barra Topo do Site -->
      <nav class="sb-topnav navbar navbar-expand " style="height:100px; background-color:#000;">
      <!-- navbar-dark bg-dark -->
        <!-- Título Site -->
        
          <a class="navbar-brand" href="<?php echo $HTTP_HOST . "/app";?>/index.php"><img src="<?php echo $HTTP_HOST . "/app";?>/img/logo.png" alt="IngressoZapp" srcset="" style="height:100px;"></a>
        <!-- Botão do Menu -->
          <!-- <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button> -->
        <!-- Barra de Pesquisa -->
          <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <!-- <div class="input-group">
              <?php //selectEvento();?>
            </div> -->
          </form>
          <div style="width:-webkit-fill-available;"></div>
          <img src="<?php echo $HTTP_HOST . "/app";?>getImagem.php?id=<?php echo $idEvento;?>" alt="Instagram" style="display:none;">
          <a href="https://www.instagram.com/ingressozapp/" target="_blank"><img src="<?php echo $HTTP_HOST . "/app";?>/img/instagram-logo.png" alt="Instagram" style="height:60px;width:60px"></a>
        
      </nav>
    <!-- Menu Lateral Esquerda -->
      <div id="layoutSidenav" style="background-color: #333;">
        <div id="layoutSidenav_nav" style="display: none; position:relative;">
          <nav class="sb-sidenav accordion sb-sidenav-dark" style="display:none;" id="sidenavAccordion">
             <div class="sb-sidenav-menu">
              <div class="nav">
                <?php echo('<a class="nav-link" href="'.$HTTP_HOST . "/app".'/index.php"><div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>IngressoZapp</a>');?>
              </div>
            </div>
            <div class="sb-sidenav-footer"> </div> 
          </nav>
        </div>


        <div id="layoutSidenav_content">
  <main class="fh">
<style>
  @media (min-width: 992px) {
    #layoutSidenav_content {
      padding-left: 0 !important;
    }
  }
</style>